<?php

namespace App\Http\Controllers;

use App\Team;
use App\Title;
use App\Branch;
use App\Gender;
use App\Country;
use App\Employee;
use App\EmailAddress;
use App\DisabilityCategory;
use App\Division;
use App\Language;
use App\JobTitle;
use App\TelephoneNumber;
use App\TimeGroup;
use App\Taxstatus;
use App\Department;
use App\LineManager;
use App\EthnicGroup;
use App\Maritalstatus;
use App\EmployeeStatus;
use App\ImmigrationStatus;
use App\Qualification;
use App\Skill;
use App\SysConfigValue;
use App\Traits\MediaFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Redirect;

class EmployeesController extends CustomController
{
    use MediaFiles;
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
        $employees = $this->contextObj::with('department','jobTitle')->filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('employees'));
    }

    public function create(){
        list($titles, $genders, $maritalstatuses, $countries, $languages, $ethnicGroups,
        $immigrationStatuses, $taxstatuses, $departments, $teams, $employeeStatuses,
        $jobTitles, $divisions, $branches, $skills, $disabilities) = $this->getDropdownsData();
        $acceptedFiles = "['doc', 'docx', 'ppt', 'pptx', 'pdf']";

        $sfeCode = SysConfigValue::where('key','=', 'LATEST_SFE_CODE')->first();
        $this->contextObj->employee_code = $this->increment($sfeCode->value);
        $sfeCode->value = $this->contextObj->employee_code;
        $sfeCode->save();

        if(!isset($this->contextObj->picture)){
            $this->contextObj->picture = asset('/img/avatar.png');
        }
        $employee = $this->contextObj;

        return view($this->baseViewPath .'.create',
            compact('_mode','fullPageEdit','data','titles','genders','maritalstatuses',
                    'countries','languages','ethnicGroups',
                    'immigrationStatuses','taxstatuses','departments',
                    'teams','employeeStatuses','jobTitles',
                    'divisions','branches','skills','disabilities','lineManagers','employee','acceptedFiles'));        
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = $titles = $genders = $countries = $maritalstatuses = null;
        $languages = $ethnicGroups = $immigrationStatuses = $taxstatuses = null;
        $departments = $teams = $employeeStatuses = $jobTitles = $divisions = null;
        $branches = null;
        $_mode = 'edit';
        $fullPageEdit = true;
        $lineManagers = array();
        $acceptedFiles = "['doc', 'docx', 'ppt', 'pptx', 'pdf']";

        $id = Route::current()->parameter('employee');

        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);

            if(!isset($data->picture)){
                $data->picture = asset('/img/avatar.png');
            }
            $data->load(['skills','disabilities']);

            $data->homeAddress = $data->addresses->where('address_type_id', 1)->first();
            $data->postalAddress = $data->addresses->where('address_type_id', 2)->first();

            $data->privateEmail = $data->emails->where('email_address_type_id', 1)->first();
            $data->workEmail = $data->emails->where('email_address_type_id', 2)->first();

            $data->homePhone = $data->phones->where('telephone_number_type_id', 1)->first();
            $data->mobilePhone = $data->phones->where('telephone_number_type_id', 2)->first();
            $data->workPhone = $data->phones->where('telephone_number_type_id', 3)->first();
            
            $qualifications = $data->qualifications;

            list($titles, $genders, $maritalstatuses, $countries, $languages, $ethnicGroups,
                 $immigrationStatuses, $taxstatuses, $departments, $teams, $employeeStatuses,
                 $jobTitles, $divisions, $branches, $skills, $disabilities) = $this->getDropdownsData();

        }

        $employeeSkills = $data->skills->pluck('id');
        $employeeDisabilities = $data->disabilities->pluck('id');

        return view($this->baseViewPath .'.edit',
            compact('_mode','fullPageEdit','data','titles','genders','maritalstatuses',
                    'countries','languages','ethnicGroups',
                    'immigrationStatuses','taxstatuses','departments',
                    'teams','employeeStatuses','jobTitles',
                    'divisions','branches','skills','disabilities','lineManagers',
                    'employeeSkills','employeeDisabilities','qualifications','acceptedFiles'));
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
        try {
            $this->validator($request);

            $this->saveEmployee($request);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            dd($exception);
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

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
        try {

            $this->validator($request);
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));

            $this->saveEmployee($request, $id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
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

    public function qualifications(Request $request)
    {
        $id = intval(Route::current()->parameter('employee'));
        $result = Qualification::where('employee_id', $id)->get();

        return Response()->json($result);
    }
    public function checkEmployee(Request $request) 
    {
        $result = false;
        $id = intval(Route::current()->parameter('employee'));

        $firstName = trim(request('firstName', false));
        $surname = trim(request('surname', false));

        $query = Employee::select(['id','first_name','surname','employee_no'])
                           ->whereNotNull('date_terminated');
        $query->when(request('idNumber', false), function ($q, $idNumber) { 
            return $q->where('id_number', $idNumber);
        });
        $query->when(request('firstName', false), function ($q, $firstName) { 
            return $q->where('first_name', 'like', '%'.$firstName.'%');
        });
        $query->when(request('surName', false), function ($q, $surName) { 
            return $q->where('surname', 'like', '%'.$surName.'%');
        });

        if ($id != 0) {
            $query = $query->where('id', '!=', $id);
        }

        return Response()->json($result); 
    }
    public function checkId(Request $request) 
    {
        $result = true;
        $id = intval(Route::current()->parameter('employee'));

        $firstName = trim(request('firstName', false));
        $surname = trim(request('surname', false));

        $query = Employee::select(['id','first_name','surname']);
        // From Laravel 5.4 you can pass the same condition value as a parameter
        // https://laraveldaily.com/less-know-way-conditional-queries/
        $query->when(request('idNumber', false), function ($q, $idNumber) { 
            return $q->where('id_number', $idNumber);
        });

        if ($id != 0) {
            $query = $query->where('id', '!=', $id);
        }

        $array = $query->get();
        $filtered = $array->filter(function ($employee, $key) use($firstName,$surname) {
            return ($employee->first_name != $firstName && $employee->surname != $surname);
        });
        //dump($query->toSql());
        //dump($query->getBindings());

        $result = $filtered->count() == 0;
        return Response()->json($result); 
    }
    public function checkEmployeeNo(Request $request)
    {
        $result = true;
        $id = intval(Route::current()->parameter('employee'));

        $query = Employee::select(['id','first_name','surname','employee_no']);
        $query->when(request('employeeNo', false), function ($q, $employeeNo) { 
            return $q->where('employee_no', $employeeNo);
        });

        if ($id != 0) {
            $query = $query->where('id', '!=', $id);
        }
        
        $array = $query->get();
        $result = $array->count() == 0;

        return Response()->json($result);
    }
    public function checkPassport(Request $request)
    {
        $result = true;
        $id = intval(Route::current()->parameter('employee'));
        $firstName = trim(request('firstName', false));
        $surname = trim(request('surname', false));

        $query = Employee::select(['id','first_name','surname']);
        $query->when(request('passportNo', false), function ($q, $passportNo) { 
            return $q->where('passport_no', $passportNo);
        });
        $query->when(request('passportCountryId', false), function ($q, $passportCountryId) { 
            return $q->where('passport_country_id', $passportCountryId);
        });

        if ($id != 0) {
            $query = $query->where('id', '!=', $id);
        }
        
        $array = $query->get();
        $filtered = $array->filter(function ($employee, $key) use($firstName,$surname) {
            return ($employee->first_name != $firstName && $employee->surname != $surname);
        });

        $result = $filtered->count() == 0;
        return Response()->json($result);
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
            'title_id' => 'required',
            'initials' => 'nullable|string|min:0|max:10',
            'first_name' => 'required|string|min:0|max:50',
            'surname' => 'required|string|min:0|max:50',
            'known_as' => 'nullable|string|min:0|max:50',
            'birth_date' => 'required|date_format:Y-m-d',
            'marital_status_id' => 'nullable',
            'id_number' => 'required|string|min:1|max:50',
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
            'employee_code' => 'nullable|string|min:1|max:50',
            'tax_status_id' => 'nullable',
            'tax_number' => 'required_with:tax_status_id|string|min:0|max:50',
            'date_joined' => 'nullable|string|min:0',
            'date_terminated' => 'nullable|string|min:0',
            'department_id' => 'required',
            'team_id' => 'required',
            'employee_status_id' => 'nullable',
            'physical_file_no' => 'nullable|string|min:0|max:50',
            'job_title_id' => 'nullable',
            'division_id' => 'nullable',
            'branch_id' => 'nullable',
            'picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'line_manager_id' => 'nullable|numeric|min:0|max:4294967295'
        ];
        
        $this->validate($request, $validateFields);
    }

    private function getDropdownsData() 
    {
        $titles = Title::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $genders = Gender::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $maritalstatuses = Maritalstatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $countries = Country::pluck('description','id')->all();
        $languages = Language::pluck('description','id')->all();
        $ethnicGroups = EthnicGroup::pluck('description','id')->all();
        $immigrationStatuses = ImmigrationStatus::pluck('description','id')->all();
        $taxstatuses = TaxStatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $departments = Department::pluck('description','id')->all();
        $teams = Team::pluck('description','id')->all();
        $employeeStatuses = EmployeeStatus::pluck('description','id')->all();
        $jobTitles = JobTitle::jobReportingLines();

        $divisions = Division::pluck('description','id')->all();
        $branches = Branch::pluck('description','id')->all();
        $skills = Skill::pluck('description','id')->all();
        $disabilities = DisabilityCategory::with('disabilities')->get();

        $results = array($titles, $genders, $maritalstatuses, $countries, $languages, $ethnicGroups, 
                         $immigrationStatuses, $taxstatuses, $departments, $teams, $employeeStatuses, 
                         $jobTitles, $divisions, $branches, $skills, $disabilities
        );

        return $results;
    }

    protected function increment($string) { 
        return preg_replace_callback('/^([^0-9]*)([0-9]+)([^0-9]*)$/', array($this, "subfunc"), $string); 
    }

    protected function subfunc($m) { 
        return $m[1].str_pad($m[2]+1, strlen($m[2]), '0', STR_PAD_LEFT).$m[3]; 
    }

    protected function saveEmployee($request, $id = null) {

        $otherFields = ['_token','_method','redirectsTo','picture','profile_pic','homeAddress','postalAddress','homePhone','mobilePhone','workPhone','privateEmail','workEmail','skills','disabilities','qualifications'];
        foreach($otherFields as $field){
            ${$field} = array_get($request->all(), $field);
        }

        $input = array_except($request->all(), $otherFields);
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $contents = 'data:' . $image->getMimeType() .';base64,' .base64_encode(file_get_contents($image->getRealPath()));
            $input['picture'] = $contents;
        }

        if ($id == null) { // Create
            $data = $this->contextObj->addData($input);
        } else { // Update
            $this->contextObj->updateData($id, $input);
            $data = Employee::find($id);
        }

        $this->attach($request, $data->id);

        if(empty($homePhone['tel_number'] || empty($mobilePhone['tel_number']) || 
           empty($workPhone['tel_number']))) {
            TelephoneNumber::where('employee_id', '=', $data->id)->delete();
        }
        if(!empty($homePhone['tel_number'])){
            $data->phones()
            ->updateOrCreate(['employee_id'=>$data->id, 'telephone_number_type_id'=>1], 
                               $homePhone);
        }
        $data->phones()
             ->updateOrCreate(['employee_id'=>$data->id, 'telephone_number_type_id'=>2], 
                                $mobilePhone);

        $data->phones()
             ->updateOrCreate(['employee_id'=>$data->id, 'telephone_number_type_id'=>3], 
                                $workPhone);

        if(!isset($privateEmail['email_address']) || !isset($workEmail['email_address'])) {
            EmailAddress::where('employee_id', '=', $data->id)->delete();
        }
        if(!empty($privateEmail['email_address'])) {
            $data->emails()
                 ->updateOrCreate(['employee_id'=>$data->id, 'email_address_type_id'=>1],
                                  $privateEmail);
        }
        if(!empty($workEmail['email_address'])) {
            $data->emails()
                 ->updateOrCreate(['employee_id'=>$data->id, 'email_address_type_id'=>2],
                                  $workEmail);
        }

        $data->addresses()
             ->updateOrCreate(['employee_id'=>$data->id, 'address_type_id'=>1],
                                $homeAddress);
        $data->addresses()
             ->updateOrCreate(['employee_id'=>$data->id, 'address_type_id'=>2],
                                $postalAddress);

        foreach($qualifications as $qual){
            $data->qualifications()
                 ->updateOrCreate(['employee_id'=>$data->id], $qual);
        }

        $data->skills()->sync($skills);
        $data->disabilities()->sync($disabilities);
        
    }
}
