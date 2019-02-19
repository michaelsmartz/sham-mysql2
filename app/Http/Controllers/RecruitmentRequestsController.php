<?php

namespace App\Http\Controllers;

use App\Department;
use App\EmployeeStatus;
use App\Enums\RecruitmentType;
use App\Interview;
use App\Position;
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
     * Display a listing of the branches.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_RECRUITMENT_REQUESTS);

        $requests = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }
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

        return view($this->baseViewPath .'.create', compact('request', 'departments',
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
            compact('data', 'departments', 'positions', 'qualifications',
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

    protected function saveRecruitmentRequest($request, $id = null) {
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

        if ($id == null) { // Create
            $data = $this->contextObj->addData($input);
        } else { // Update
            $this->contextObj->updateData($id, $input);
            $data = Recruitment::find($id);
        }

        $data->skills()->sync($skills);
        $data->interviewTypes()->sync($interview_types);
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
            'year_experience' => 'nullable',
            'qualification_id' => 'nullable',
            'field_of_study' => 'required|string|min:0|max:50',
            'recruitment_type_id' => 'nullable',
            'start_date' => 'required',
            'end_date' => 'required',
            'min_salary' => 'nullable',
            'max_salary' => 'nullable',
            'description' => 'nullable|string|min:0',
        ];

        $this->validate($request, $validateFields);
    }
}