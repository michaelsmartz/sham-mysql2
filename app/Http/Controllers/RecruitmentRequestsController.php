<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Department;
use App\EmployeeStatus;
use App\Enums\RecruitmentType;
use App\Interview;
use App\QualificationRecruitment;
use App\Recruitment;
use App\Skill;
use App\Support\Helper;
use App\SystemSubModule;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class RecruitmentRequestsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Recruitment();
        $this->baseViewPath = 'recruitment_requests';
        $this->baseFlash = 'Recruitment requests details ';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $job_title = $request->get('job_title', null);

        if(!empty($job_title)){
            $request->merge(['job_title' => '%'.$job_title.'%']);
        }

        $description = $request->get('description', null);

        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $year_experience = $request->get('year_experience', null);

        if(!empty($year_experience)){
            $request->merge(['year_experience' => '%'.$year_experience.'%']);
        }

        $field_of_study = $request->get('field_of_study', null);

        if(!empty($field_of_study)){
            $request->merge(['field_of_study' => '%'.$field_of_study.'%']);
        }

        $start_date = $request->get('start_date', null);

        if(!empty($start_date)){
            $request->merge(['start_date' => '%'.$start_date.'%']);
        }

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_RECRUITMENT_REQUESTS);

        $requests = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('requests','allowedActions'));
    }

    public function create(){
        $skills = Skill::pluck('description','id')->all();
        $departments = Department::pluck('description','id')->all();
        $positions = EmployeeStatus::pluck('description','id')->all();
        $qualifications = QualificationRecruitment::pluck('description','id')->all();

        $recruitmentTypes = RecruitmentType::ddList();

        $interviewTypes = Interview::pluck('description','id')->all();

        $request = $this->contextObj;
        $_mode = 'create';

        return view($this->baseViewPath .'.create', compact('_mode', 'request', 'departments',
            'positions', 'qualifications', 'skills', 'interviewTypes','recruitmentTypes'));
    }

    /**
     * Store a new branch in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $this->saveRecruitmentRequest($request);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {

        $data = $skills = $departments = $positions = $qualifications = $interviewTypes = $recruitmentTypes = null;
        $_mode = 'edit';
        $id = Route::current()->parameter('recruitment_request');

        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);

            $data->load(['skills','interviewTypes']);

            $skills = Skill::pluck('description','id')->all();
            $departments = Department::pluck('description','id')->all();
            $positions = EmployeeStatus::pluck('description','id')->all();
            $qualifications = QualificationRecruitment::pluck('description','id')->all();
            $recruitmentTypes = RecruitmentType::ddList();
            $interviewTypes = Interview::pluck('description','id')->all();
        }

        $recruitmentSkills = $data->skills->pluck('id');
        $recruitmentInterviewTypes = $data->interviewTypes->pluck('id');

        return view($this->baseViewPath .'.edit',
            compact('_mode', 'data', 'departments', 'positions', 'qualifications',
                'skills', 'interviewTypes', 'recruitmentTypes',
                'recruitmentInterviewTypes','recruitmentSkills'));
    }

    /**
     * Update the specified branch in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validator($request);

            $this->saveRecruitmentRequest($request, $id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    public function manageCandidate(Request $request, $id){
        $data = $this->contextObj->findData($id);

        $recruitmentCandidates = $data->candidates()->orderBy('candidate_recruitment.id','asc')->pluck('first_name','candidate_recruitment.candidate_id');
        $candidates = Candidate::pluck('first_name', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.manage-candidate', compact('data', 'candidates', 'recruitmentCandidates'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.manage-candidate', compact('data', 'candidates', 'recruitmentCandidates'));
    }

    public function updateCandidate(Request $request, $id){
        try {
            $candidates = array_get($request->all(),'candidates');

            $data = Recruitment::find($id);
            $data->candidates()
                ->sync($candidates); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }


    public function updateStatus(Request $request, $id, $status){
        try {
            $data = Recruitment::find($id);

            if($data) {
                $data->is_approved = $status;
                $data->save();
            }
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }
        return redirect()->route($this->baseViewPath .'.index');
    }


    /**
     * Remove the specified branch from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('recruitment_request');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function getCandidates(Request $request)
    {
        $result = false;
        try {
            $id = Route::current()->parameter('request');

            $data = $this->contextObj->findData($id);

            $result = $data->candidates()->with(['skills','qualifications'])->get();

        } catch (Exception $exception) {
            
        } finally {
            return Response()->json($result);
        }
    }

    protected function saveRecruitmentRequest($request, $id = null) {

        $employee_id  = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $otherFields = [
            '_token',
            '_method',
            'redirectsTo',
            'start_date_submit',
            'end_date_submit',
            'skills',
            'interview_types'
        ];
        foreach($otherFields as $field){
            ${$field} = array_get($request->all(), $field);
        }

        $input = array_except($request->all(), $otherFields);
        $input['employee_id'] = $employee_id;

        if ($id == null) { // Create
            $data = $this->contextObj->addData($input);
        } else { // Update
            $this->contextObj->updateData($id, $input);
            $data = Recruitment::find($id);
        }

        if($data) {
            $data->skills()->sync($skills);
            $data->interviewTypes()->sync($interview_types);
        }
    }

    /**
     * Validate the given request with the defined rules.
     *
     * @param  Request $request
     *
     * @return boolean
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'job_title' => 'required|string|min:0|max:50',
            'employee_status_id' => 'nullable',
            'department_id' => 'nullable',
            'employee_id' => 'nullable',
            'year_experience' => 'nullable',
            'qualification_id' => 'nullable',
            'field_of_study' => 'required|string|min:0|max:50',
            'recruitment_type_id' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'quantity' => 'nullable',
            'min_salary' => 'nullable',
            'max_salary' => 'nullable',
            'description' => 'nullable|string|min:0',
        ];

        $this->validate($request, $validateFields);
    }
}