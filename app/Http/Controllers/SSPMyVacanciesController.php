<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Department;
use App\Employee;
use App\EmployeeStatus;
use App\QualificationRecruitment;
use App\Recruitment;
use App\Support\Helper;
use App\SystemSubModule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

class SSPMyVacanciesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->contextObj = new Recruitment();
        $this->baseViewPath = 'selfservice-portal.vacancies';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     * @throws \Throwable
     */
    public function index(Request $request)
    {
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_VACANCIES);

        if ($allowedActions == null || !$allowedActions->contains('List')) {
            return View('not-allowed')
                ->with('title', 'Vacancies')
                ->with('warnings', array('You do not have permissions to access this page.'));
        }

        $warnings = [];
        $already_apply = null;
        $candidate_id = null;

        $employee = Employee::find($employee_id);

        if (empty($employee)) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }

        $candidate = Candidate::where('employee_no', $employee->employee_no)->get()->first();

        //Filter by closing_date
        $closing_date = $request->get('closing_date', null);

        //Filter by qualification
        if(!empty($request->input('qualification')) && $request->input('qualification') != 0){
            $qualification = $request->input('qualification');
        }else{
            $qualification = null;
        }

        //Filter by department
        if(!empty($request->input('department')) && $request->input('department') != 0){
            $department = $request->input('department');
        }else{
            $department = null;
        }

        //Filter by quick filter employee status
        $search_employee_status = $request->get('search_employee_status', null);

        $vacancies = $this->getVacancies($closing_date, $qualification, $department, $search_employee_status);

        foreach ($vacancies as $vacancy) {
            $vacancy->posted_on = Carbon::createFromTimeStamp(strtotime($vacancy->posted_on))->diffForHumans();

            $dtEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $vacancy->end_date);
            $vacancy->end_date = $dtEndDate->toFormattedDateString();

            if (!is_null($candidate) && !is_null($vacancy->id)) {
                $already_apply = DB::table('candidate_recruitment')->where('candidate_id', $candidate->id)
                    ->where('recruitment_id', $vacancy->id)->get()->first();

                $candidate_id = $candidate->id;
            }

            $vacancy->already_apply = $already_apply;
        }

        $jobStatuses = EmployeeStatus::get()->all();
        $jobDepartments = Department::pluck('description', 'id');
        $jobQualifications = QualificationRecruitment::pluck('description', 'id');

        if ($request->ajax()) {
            return view($this->baseViewPath . '.load', compact('vacancies', 'candidate_id'))->render();
        }

        // load the view and pass the vacancies
        return view($this->baseViewPath . '.index', compact('warnings', 'vacancies', 'candidate_id', 'jobStatuses', 'department', 'jobDepartments', 'qualification', 'jobQualifications', 'closing_date'));
    }

    public function applyInterview(Request $request)
    {
        $already_candidate = null;
        $candidate_id = null;

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $salary_expectation = ($request->has('salary_expectation')) ? $request->get('salary_expectation') : null;
        $recruitment_id = ($request->has('recruitment_id')) ? $request->get('recruitment_id') : null;
        $page = ($request->has('page')) ? $request->get('page') : 1;

        if (!is_null($salary_expectation) && !is_null($recruitment_id)) {

            $recruitment = Recruitment::find($recruitment_id);
            $employee = Employee::with(['addresses' => function ($query) {
                return $query->where('address_type_id', 1);
            }])
                ->where('id', $employee_id)
                ->get()
                ->first();

            if (!empty($employee) && !empty($recruitment)) {
                if ($employee->employee_no) {
                    $already_candidate = Candidate::where('employee_no', $employee->employee_no)->get()->first();
                    $candidate_id = ($already_candidate) ? $already_candidate->id : null;
                }

                //if not in candidate table do insert
                if (is_null($already_candidate)) {
                    $employee_arr = $employee->ToArray();

                    $data_employee = array_only($employee_arr,
                        ["employee_no",
                            "title_id",
                            "gender_id",
                            "marital_status_id",
                            "first_name",
                            "surname",
                            "id_number",
                            "passport_no",
                            "passport_country_id",
                            "nationality",
                            "immigration_status_id",
                            "birth_date"
                        ]);

                    //candidate table need only home address
                    if ($employee_arr['addresses'][0]) {
                        $data_address = array_only($employee_arr['addresses'][0], [
                            "addr_line_1",
                            "addr_line_2",
                            "addr_line_3",
                            "addr_line_4",
                            "city",
                            "province",
                            "zip_code",
                        ]);
                    } else {
                        $data_address = [];
                    }

                    $candidate = array_merge($data_employee, $data_address);

                    if (!is_null($candidate)) {
                        DB::table('candidates')->insert($candidate);
                        $candidate_id = DB::getPdo()->lastInsertId();
                    }
                }

                if (!is_null($candidate_id) && !is_null($recruitment_id)) {

                    $already_apply = DB::table('candidate_recruitment')->where('candidate_id', $candidate_id)
                        ->where('recruitment_id', $recruitment_id)->get()->first();

                    //if already applied do not insert again
                    if (is_null($already_apply)) {
                        $candidate_recruitment = [
                            'candidate_id' => $candidate_id,
                            'recruitment_id' => $recruitment_id,
                            'salary_expectation' => $salary_expectation
                        ];

                        DB::table('candidate_recruitment')->insert($candidate_recruitment);
                    }
                }

            }
        }

        return Redirect::to("my-vacancies?page=".$page);
    }

    public function addSalaryExpectation(Request $request)
    {
        $recruitment_id = Route::current()->parameter('recruitment_id');
        $page = Route::current()->parameter('page');

        if ($request->ajax()) {
            $view = view($this->baseViewPath . '.salary', compact('recruitment_id', 'page'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.salary', compact('recruitment_id', 'page'));
    }

    /**
     * @param $closing_date
     * @param $qualification
     * @param $department
     * @param $search_employee_status
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    private function getVacancies($closing_date, $qualification, $department, $search_employee_status){

        $vacancies = $this->contextObj::with([
                'department',
                'qualification',
                'employeeStatus',
                'skills']);

        if (!is_null($closing_date) && is_null($qualification) && is_null($department)) {
            $vacancies = $vacancies
                ->whereDate('end_date', '>', $closing_date);
        }
        else if (!is_null($closing_date) && is_null($qualification) && !is_null($department)) {
            $vacancies = $vacancies
                ->where('department_id', $department)
                ->whereDate('end_date', '>', $closing_date);
        }
        elseif (is_null($closing_date) && !is_null($qualification) && is_null($department)){
            $vacancies = $vacancies
                ->where('qualification_id', $qualification);
        }
        elseif (is_null($closing_date) && !is_null($qualification) && !is_null($department)){
            $vacancies = $vacancies
                ->where('qualification_id', $qualification)
                ->where('department_id', $department);
        }
        elseif (!is_null($closing_date) && !is_null($qualification) && is_null($department)){
            $vacancies = $vacancies
                ->where('qualification_id', $qualification)
                ->whereDate('end_date', '<', $closing_date);
        }
        elseif (!is_null($closing_date) && !is_null($qualification) && !is_null($department)){
            $vacancies = $vacancies
                ->where('qualification_id', $qualification)
                ->where('department_id', $department)
                ->whereDate('end_date', '>=', Carbon::createFromFormat('d/m/Y', $closing_date)->format('Y-m-d'));
        }
        elseif (is_null($closing_date) && is_null($qualification) && is_null($department)){
            $vacancies = $vacancies
                ->whereDate('end_date', '>=', Carbon::now());
        }
        elseif (is_null($closing_date) && is_null($qualification) && !is_null($department)){
            $vacancies = $vacancies
                ->where('department_id', $department);
        }

        if(!is_null($search_employee_status)) {
            $vacancies = $vacancies
                ->where('employee_status_id', $search_employee_status);
        }

        return $vacancies->where('is_approved', '=', 1)
            ->whereIn('recruitment_type_id', [1, 3])
            ->orderBy('posted_on', 'desc')
            ->paginate(2);
    }

    public function showCandidateStatus(Request $request)
    {
        $candidateId = Route::current()->parameter('candidate_id');
        $recruitmentId = Route::current()->parameter('recruitment_id');

        $recruitment = Recruitment::with(['trackCandidateStatus' => function($query) use ($candidateId){
            return $query->where('candidate_id',$candidateId);
        }])->find($recruitmentId);

        $candidate = Candidate::candidatesList()->with(['interviews', 'offers', 'contracts'])->find($candidateId);

        $view = view($this->baseViewPath . '.candidate-status', compact('recruitment','candidate'))->renderSections();

        return response()->json([
            'title' => $view['modalTitle'],
            'content' => $view['modalContent'],
            'footer' => $view['modalFooter']
        ]);
    }
}

