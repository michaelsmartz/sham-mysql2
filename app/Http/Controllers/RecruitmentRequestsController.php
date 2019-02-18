<?php

namespace App\Http\Controllers;

use App\Department;
use App\Interview;
use App\Position;
use App\RecruitmentQualification;
use App\RecruitmentRequest;
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
        $this->contextObj = new RecruitmentRequest();
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
        $positions = Position::pluck('description','id')->all();
        $qualifications = RecruitmentQualification::pluck('description','id')->all();

        $interview_types = Interview::pluck('description','id')->all();

        $request = $this->contextObj;

        return view($this->baseViewPath .'.create', compact('request', 'departments',
            'positions', 'qualifications', 'skills', 'interview_types'));
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
        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);

            $interviews = $data->interviews;

            $skills = Skill::pluck('description','id')->all();
            $departments = Department::pluck('description','id')->all();
            $positions = Position::pluck('description','id')->all();
            $qualifications = RecruitmentQualification::pluck('description','id')->all();
        }

        return view($this->baseViewPath .'.edit',
            compact('data', 'departments', 'positions', 'qualifications', 'skills', 'interviews'));
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

            $this->saveRecruitmentRequest($request);

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

        dd($request);

        $otherFields = [
            '_token',
            '_method',
            'attachment',
            'redirectsTo',
            'date_available_submit',
            'birth_date_submit',
            'skills',
            'disabilities',
            'qualifications',
            'previous_employments',
            'picture',
            'profile_pic'
        ];
        foreach($otherFields as $field){
            ${$field} = array_get($request->all(), $field);
        }

        $input = array_except($request->all(), $otherFields);

        if ($id == null) { // Create
            $data = $this->contextObj->addData($input);
        } else { // Update
            $this->contextObj->updateData($id, $input);
            $data = Candidate::find($id);
        }

        $this->attach($request, $data->id);

        if(isset($interviews)){
            foreach($interviews as $interview){
                $data->interviews()
                    ->updateOrCreate(['recruitment_id'=>$data->id], $interview);
            }
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
            'picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender_id' => 'nullable',
            'preferred_notification_id' => 'nullable',
            'title_id' => 'required',
            'marital_status_id' => 'nullable',
            'first_name' => 'required|string|min:0|max:50',
            'surname' => 'required|string|min:0|max:50',
            'home_address' => 'required|string|min:0|max:50',
            'email' => 'nullable',
            'phone' => 'nullable',
            'id_number' => 'required|string|min:1|max:50',
            'position_applying_for' => 'required|string|min:1|max:50',
            'date_available' => 'nullable|string|min:0',
            'salary_expectation' => 'nullable|numeric|min:0',
            'overview' => 'nullable|string|min:0',
            'cover' => 'nullable|string|min:0',
        ];

        $this->validate($request, $validateFields);
    }
}