<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Department;
use App\EmployeeStatus;
use App\Enums\InterviewResultsType;
use App\Enums\InterviewStatusType;
use App\Enums\RecruitmentType;
use App\Interview;
use App\Offer;
use App\QualificationRecruitment;
use App\Recruitment;
use App\Skill;
use App\Support\Helper;
use App\SystemSubModule;
use Barryvdh\DomPDF\Facade as PDF;
use App\Traits\MediaFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class RecruitmentRequestsController extends CustomController
{
    use MediaFiles;

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

        $requests = $this->contextObj::orderBy('start_date','DESC')->filtered()->paginate(10);

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

        $processed = $this->checkIfAlreadyProcessed($id);

        if ($data->is_approved == true)
        {
            // show the view and pass the data to it
            return view($this->baseViewPath . '.show',
                compact('_mode', 'processed', 'data', 'departments', 'positions', 'qualifications',
                    'skills', 'interviewTypes', 'recruitmentTypes',
                    'recruitmentInterviewTypes', 'recruitmentSkills'));
        }
        else {
            // show the view and pass the data to it
            return view($this->baseViewPath . '.edit',
                compact('_mode', 'processed', 'data', 'departments', 'positions', 'qualifications',
                    'skills', 'interviewTypes', 'recruitmentTypes',
                    'recruitmentInterviewTypes', 'recruitmentSkills'));
        }
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
            $processed = $this->checkIfAlreadyProcessed($id);

            $data = Recruitment::find($id);

            if($data) {
                if ($data->is_approved == false && $processed == 0) {
                    $this->validator($request);
                    $this->saveRecruitmentRequest($request, $id);
                } else if($processed == 0) {
                    $data->is_approved = $request->is_approved;
                    $data->is_completed = $request->is_completed;
                    $data->save();
                }
            }

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    private function checkIfAlreadyProcessed($id){
        $data = Recruitment::find($id);

        if($data) {
            //check if status is not 0 (initial state) in pivot candidate_recruitment
            foreach ($data->candidates as $candidate) {
                //check if status is not 0 therefore meaning processed already start
                if ($candidate->pivot->status > 0)
                    return 1;
            }

            //check if recruitment has interview type in pivot candidate_interview_recruitment
            if ($data->interviews->count() == 0)
                return 0;

        }

        return 1;
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

            if (!is_null($data)) {
                $interview_types = $data->interviewTypes()->get()->all();

                 $candidate_interview_recruitment_pivot = [];

                $data->candidates()
                    ->sync($candidates); //sync what has been selected
                foreach ($interview_types as $interview_type) {
                    foreach ($candidates as $key => $candidate) {
                        $candidate_interview_recruitment_pivot[] = [
                            'candidate_id' => $candidate,
                            'interview_id' => $interview_type->id,
                            'recruitment_id' => $id,
                        ];
                    }
                }

                $data->interviews()->sync([]);
                $data->interviews()->sync($candidate_interview_recruitment_pivot);

                \Session::put('success', $this->baseFlash . 'updated Successfully!!');
            }

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
            $id = Route::current()->parameter('recruitment_request');

            $data = $this->contextObj->findData($id);

            $result = $data->candidates()
                ->with(['media','jobTitle','previousEmployments','qualifications',
                    'status'=> function ($query) use ($id)
                    {
                        return  $query->where('recruitment_id', $id);
                    },
                    'interviews'=> function ($query) use ($id)
                    {
                        return  $query->where('recruitment_id', $id);
                    },
                    'offers'=> function ($query) use ($id)
                    {
                        return  $query->where('recruitment_id', $id);
                    }
                ])
                ->get();

        } catch (Exception $exception) {
            dd($exception);
        } finally {
            return Response()->json($result);
        }
    }

    public function getOfferLetters(Request $request) {
        try {

            $result = Offer::select(['description','id'])->get();

        } catch(Exception $exception) {

            $result = false;
        }

        return Response()->json($result);

    }

    public function showStages(Request $request){
        $id = Route::current()->parameter('recruitment_request');

        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);
        }

        return view($this->baseViewPath .'.stages', compact('data'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function editInterview(Request $request)
    {
        $interview_id = Route::current()->parameter('interview');
        $recruitment_id = Route::current()->parameter('recruitment_request');
        $candidate_id = Route::current()->parameter('candidate');

        $data = $this->contextObj::find($recruitment_id);
        $interview = $data->interviews()
            ->where('recruitment_id', $recruitment_id)
            ->where('interview_id', $interview_id)
            ->where('candidate_id', $candidate_id)
            ->first();

        $status = InterviewStatusType::ddList();
        $results = InterviewResultsType::ddList();

        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload document files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "5", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];

        if($request->ajax()) {
            $view = view('interview_requests.edit', compact('data','status','results','interview', 'recruitment_id', 'interview_id', 'candidate_id','uploader'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view('interview_requests.edit', compact('data','status','results','interview', 'recruitment_id', 'interview_id', 'candidate_id','uploader'));
    }

    /**
     * Update the specified branch in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function updateInterview(Request $request, $id)
    {
        try {
            $input = array_except($request->all(),array('_token','_method','attachment','schedule_at_submit'));
            $data = Recruitment::find($id);

            $interview = $data->interviews()
                ->where('recruitment_id', $input['recruitment_id'])
                ->where('interview_id', $input['interview_id'])
                ->where('candidate_id', $input['candidate_id'])
                ->get()->first();

            $pivot_table_id = $interview->pivot->id;

            DB::table('candidate_interview_recruitment')
                ->where('id', $pivot_table_id)
                ->update($input);

            $this->attach($request, $id, 'Recruitment');

            \Session::put('success', 'Interview updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not update Interview!');
        }

        return redirect()->route('recruitment_requests.stages',[$id]);
    }

    public function stateSwitch(Request $request){

        $id = intval(Route::current()->parameter('recruitment_request'));
        $candidate = intval(Route::current()->parameter('candidate'));
        $state = intval(Route::current()->parameter('state'));
        $result = true;

        $recruitment = Recruitment::find($id);
        $dataToSync = ['candidate_id' => $candidate, 'status' => $state];
        
        try{
            $recruitment->candidates()->updateExistingPivot($candidate, $dataToSync);
        } catch(Exception $exception) {
            $result = false;
        }
        
        return Response()->json($result);
    }

    public function downloadOffer(Request $request){

        $id = intval(Route::current()->parameter('recruitment_request'));
        $cdt = intval(Route::current()->parameter('candidate'));

        $startingOn = $request->get('starting_on');
        $contractId = $request->get('contract_id');

        $recruitment = Recruitment::find($id);
        $recruitment->load(['department']);
        $candidate = Candidate::find($cdt);

        try {

            $pdf = PDF::loadView('recruitments.offer-letter', compact('recruitment','candidate'))
                   ->setPaper('a4', 'portrait');

        } catch(Exception $exception) {

        }

        return $pdf->download($recruitment->job_title . ' - ' . $candidate->name .'- offer letter.pdf');

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