<?php

namespace App\Http\Controllers;

use App\Team;
use App\Title;
use App\Branch;
use App\Gender;
use App\Country;
use App\Employee;
use App\Division;
use App\Language;
use App\JobTitle;
use App\TimeGroup;
use App\Taxstatus;
use App\Department;
use App\LineManager;
use App\EthnicGroup;
use App\Maritalstatus;
use App\EmployeeStatus;
use App\ImmigrationStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;

class EmployeesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Employee();
        $this->baseViewPath = 'employees';
        $this->baseFlash = 'Employee details ';
    }

    /**
     * Display a listing of the employees.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        //$employees = $this->contextObj::with('department','jobTitle')->paginate(10);

        $employees = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('employees'));
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->contextObj->findData($id);

        $titles = Title::pluck('description','id')->all();
        $genders = Gender::pluck('description','id')->all();
        $maritalstatuses = Maritalstatus::pluck('description','id')->all();
        $countries = Country::pluck('description','id')->all();
        $languages = Language::pluck('description','id')->all();
        $ethnicGroups = EthnicGroup::pluck('description','id')->all();
        $immigrationStatuses = ImmigrationStatus::pluck('description','id')->all();
        $taxstatuses = TaxStatus::pluck('description','id')->all();
        $departments = Department::pluck('description','id')->all();
        $teams = Team::pluck('description','id')->all();
        $employeeStatuses = EmployeeStatus::pluck('description','id')->all();
        $jobTitles = JobTitle::pluck('description','id')->all();
        $divisions = Division::pluck('description','id')->all();
        $branches = Branch::pluck('description','id')->all();

        $lineManagers = array();
        $j = JobTitle::ManagerialJobs()->with(['employees' => function($q){
            $q->EmployeesLite();
        }])->get();

        $j->each(function($item) use (&$lineManagers){
            $item->description = trim($item->description);
            $lineManagers[$item->description] = array();
            $item->employees->each(function($e) use (&$lineManagers,$item){
                $fullName = $e->first_name . ' ' .$e->surname;
                $temp = array($fullName => $e->id);
                array_push($lineManagers[$item->description], $temp);
            });
        });

        return view($this->baseViewPath .'.edit',
            compact('data','titles','genders','maritalstatuses',
                    'countries','languages','ethnicGroups',
                    'immigrationStatuses','taxstatuses','departments',
                    'teams','employeeStatuses','jobTitles',
                    'divisions','branches','lineManagers'));
    }

    /**
     * Store a new employee in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validator($request);

        $input = array_except($request->all(),array('_token'));

        $this->contextObj->addData($input);

        \Session::put('success', $this->baseFlash . 'created Successfully!');

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Update the specified employee in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validator($request);

        $input = array_except($request->all(),array('_token','_method'));

        $this->contextObj->updateData($id, $input);

        \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified employee from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $this->contextObj->destroyData($id);

        \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');
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
            'title_id' => 'nullable',
            'initials' => 'nullable|string|min:0|max:10',
            'first_name' => 'nullable|string|min:0|max:50',
            'surname' => 'nullable|string|min:0|max:50',
            'known_as' => 'nullable|string|min:0|max:50',
            'birth_date' => 'nullable|date_format:j/n/Y',
            'marital_status_id' => 'nullable',
            'id_number' => 'required|numeric|string|min:1|max:50',
            'passport_country_id' => 'nullable|numeric|min:0|max:4294967295',
            'nationality' => 'nullable|string|min:0|max:50',
            'language_id' => 'nullable|numeric|min:0|max:4294967295',
            'gender_id' => 'nullable',
            'ethnic_group_id' => 'nullable',
            'immigration_status_id' => 'nullable',
            'time_group_id' => 'nullable',
            'passport_no' => 'nullable|string|min:0|max:50',
            'spouse_full_name' => 'nullable|string|min:0|max:50',
            'employee_no' => 'required|string|min:1|max:50',
            'employee_code' => 'required|string|min:1|max:50',
            'tax_number' => 'nullable|numeric|string|min:0|max:50',
            'tax_status_id' => 'nullable',
            'date_joined' => 'nullable|string|min:0',
            'date_terminated' => 'nullable|string|min:0',
            'department_id' => 'nullable',
            'team_id' => 'nullable',
            'employee_status_id' => 'nullable',
            'physical_file_no' => 'nullable|string|min:0|max:50',
            'job_title_id' => 'nullable',
            'division_id' => 'nullable',
            'branch_id' => 'nullable',
            'picture' => 'nullable|file|string|min:0|max:4294967295',
            'line_manager_id' => 'nullable|numeric|min:0|max:4294967295',
            'leave_balance_at_start' => 'nullable|numeric|min:-2147483648|max:2147483647',
     
        ];
        

        $this->validate($request, $validateFields);
    }

    
}
