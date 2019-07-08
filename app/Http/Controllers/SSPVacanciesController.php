<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use App\EmployeeStatus;
use App\QualificationRecruitment;
use App\Recruitment;
use App\Support\Helper;
use App\SystemSubModule;
use Illuminate\Support\Facades\Response;

class SSPVacanciesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){
        $this->contextObj = new Recruitment();
        $this->baseViewPath = 'selfservice-portal.vacancies';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_VACANCIES);

        if ($allowedActions == null || !$allowedActions->contains('List')){
            return View('not-allowed')
                ->with('title', 'Vacancies')
                ->with('warnings', array('You do not have permissions to access this page.'));
        }

        $warnings = [];

        $employee =  Employee::find($employee_id);


        if(empty($employee)) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }

        $vacancies = $this->contextObj::with(['department','employeeStatus','qualification', 'skills'])->get()->all();

        $jobStatuses = EmployeeStatus::get()->all();
        $jobDepartments = Department::pluck('description', 'id');
        $jobQualifications = QualificationRecruitment::pluck('description', 'id');

        // load the view and pass the vacancies
        return view($this->baseViewPath .'.index',compact('warnings', 'vacancies', 'jobStatuses' , 'jobDepartments', 'jobQualifications'));
    }
}

