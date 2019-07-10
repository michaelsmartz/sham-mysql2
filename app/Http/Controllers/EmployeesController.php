<?php

namespace App\Http\Controllers;

use App\Address;
use App\Disability;
use App\Enums\TimelineEventType;
use App\HistoryDepartment;
use App\HistoryJobTitle;
use App\HistoryJoinTermination;
use App\Team;
use App\Timeline;
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
use App\TaxStatus;
use App\Department;
use App\LineManager;
use App\EthnicGroup;
use App\MaritalStatus;
use App\EmployeeStatus;
use App\ImmigrationStatus;
use App\Qualification;
use App\Skill;
use App\SystemSubModule;
use App\SysConfigValue;
use App\TimelineManager;
use App\Jobs\FlushDashboardCachedQueries;
use App\Traits\MediaFiles;
use Illuminate\Support\Facades\Session;
use OwenIt\Auditing\Facades\Auditor;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
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
    public function index(Request $request)
    {
        $fullName = $request->get('name', null);
        $department = $request->get('department:description', null);
        $jobTitle = $request->get('jobtitle:description', null);
        $is_terminated = $request->get('is_terminated', null);
        $search_term = $request->get('search-term', null);

        $allowedActions = getAllowedActions(SystemSubModule::CONST_EMPLOYEE_DATABASE);

        if(!empty($fullName)){
            $request->merge(['name' => '%'.$fullName.'%']);
        }
        if(!empty($department)){
            $request->merge(['department:description' => '%'.$department.'%']);
        }
        if(!empty($jobTitle)){
            $request->merge(['jobtitle:description' => '%'.$jobTitle.'%']);
        }

        //$employees = $this->contextObj::with('department','jobTitle')->filtered()->paginate(10);
        $employees = $this->contextObj::employeesList($is_terminated, $search_term)->filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page') && $employees->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('employees', 'is_terminated', 'allowedActions'));
    }

    public function create(){
        list($titles, $genders, $maritalstatuses, $countries, $languages, $ethnicGroups,
        $immigrationStatuses, $taxstatuses, $departments, $teams, $employeeStatuses,
        $jobTitles, $lineManagers, $divisions, $branches, $skills, $disabilities) = $this->getDropdownsData();
        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload document files in the format doc, docx, ppt, pptx, pdf",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "1.2", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];

        $sfeCode = SysConfigValue::where('key','=', 'LATEST_SFE_CODE')->first();

        if($sfeCode !== null) {
            $this->contextObj->employee_code = $this->increment($sfeCode->value);
            $sfeCode->value = $this->contextObj->employee_code;
        }
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
                    'divisions','branches','skills','disabilities','lineManagers','employee','uploader'));        
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
        $uploader = [
            "fieldLabel" => "Attach Files",
            "restrictionMsg" => "Upload document files in the format doc, docx, ppt, pptx, pdf",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "1.2", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];

        $id = Route::current()->parameter('employee');

        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);

            if (!isset($data->picture)) {
                $data->picture = asset('img/avatar.png');
            }
            $data->load(['skills','disabilities']);

            //dd($data);

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
                 $jobTitles, $lineManagers, $divisions, $branches, $skills, $disabilities) = $this->getDropdownsData();

        }

        $employeeSkills = $data->skills->pluck('id');

        $employeeDisabilities = $data->disabilities->pluck('id');

        return view($this->baseViewPath .'.edit',
            compact('_mode','fullPageEdit','data','titles','genders','maritalstatuses',
                    'countries','languages','ethnicGroups',
                    'immigrationStatuses','taxstatuses','departments',
                    'teams','employeeStatuses','jobTitles',
                    'divisions','branches','skills','disabilities','lineManagers',
                    'employeeSkills','employeeDisabilities','qualifications','uploader'));
    }


    public function editEmployeeHistory(Request $request){
        Session::put('redirectsTo', \URL::previous());

        $id = Route::current()->parameter('employee');
        $employee = $this->contextObj::with([
            'historyDepartments.department',
            'historyJobTitles.jobTitle',
        ])->where('employees.id',$id)->get()->first();

        $data = self::getTimeline($employee);

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.history', compact('id','data'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.history', compact('id','data'));
    }

    public function updateEmployeeHistory(Request $request, $id)
    {
        $otherFields = ['_token', '_method'];
        $input = array_except($request->all(), $otherFields);
        $histories = [];

        //update only input field that was changed on submit
        foreach($input as $key => $value){
            $exp_key = explode('_', $key);
            if(isset($exp_key[2]) && $exp_key[2] == 'submit'){
                $histories[$exp_key[0]][$exp_key[1]] = $value;
            }
        }

        if(!empty($histories)) {
            foreach ($histories as $title => $history) {
                switch ($title) {
                    case "Department":
                        foreach ($history as $id => $date_occurred) {
                            HistoryDepartment::where('id', $id)
                                ->update(['date_occurred' => $date_occurred]);
                        }
                        break;

                    case "JobTitle":
                        foreach ($history as $id => $date_occurred) {
                            HistoryJobTitle::where('id', $id)
                                ->update(['date_occurred' => $date_occurred]);
                        }
                        break;
                }
            }
        }

        \Session::put('success', 'Employee Timeline History updated Successfully!!');
        return redirect(Session::get('redirectsTo'));
    }

    private static function getTimeline($employee) {
        $timeCompileResults = [];

        foreach( $employee->timelines as $timeline) {
            $timelineEventType = TimelineEventType::getDescription($timeline->timeline_event_type_id);
            $timelineEventTypeKey = TimelineEventType::getKey($timeline->timeline_event_type_id);
            $event_id = trim($timeline->event_id);

            switch ($timelineEventType) {
                case "Department":
                    $historyDepartments =  $employee->historyDepartments->where('id', $event_id);

                    if(count($historyDepartments) > 0)
                    {
                        //dd($historyDepartments);
                        foreach ($historyDepartments as $historyDepartment) {
                            $timeline = new Timeline();
                            $timeline->Description = optional($historyDepartment->department)->description;
                            $timeline->Id = $historyDepartment->id;
                            $timeline->EventType = $timelineEventType;
                            $timeline->EventTypeKey = $timelineEventTypeKey;
                            $timeline->formattedDate = date("Y-m-d", strtotime($historyDepartment->date_occurred));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Job Title":
                    $historyJobTitles = $employee->historyJobTitles->where('id', $event_id);

                    if(count($historyJobTitles) > 0)
                    {
                        foreach ($historyJobTitles as $historyJobTitle) {
                            $timeline = new Timeline();
                            $timeline->Description = $historyJobTitle->jobTitle->description;
                            $timeline->Id = $historyJobTitle->id;
                            $timeline->EventType = $timelineEventType;
                            $timeline->EventTypeKey = $timelineEventTypeKey;
                            $timeline->formattedDate = date("Y-m-d", strtotime($historyJobTitle->date_occurred));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;
            }
        }

        $timeCompileResults = collect($timeCompileResults)->sortBy('formattedDate');
        return $timeCompileResults;
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
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function show($id)
    {

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
            //$redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));
            $this->saveEmployee($request, $id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

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
        
        //clear the cache for dashboard
        FlushDashboardCachedQueries::dispatch();

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function qualifications(Request $request)
    {

        $id = intval(Route::current()->parameter('employee'));

        $result = [];
        if ($id != 0) {
            $result = Qualification::where('employee_id', $id)->get();
        }
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
        $query->when(trim(request('idNumber', false)) != false, function ($q, $idNumber) { 
            return $q->where('id_number', $idNumber);
        });
        $query->when(trim(request('firstName', false)) != false, function ($q, $firstName) { 
            return $q->where('first_name', 'like', '%'.$firstName.'%');
        });
        $query->when(trim(request('surName', false)) != false, function ($q, $surName) { 
            return $q->where('surname', 'like', '%'.$surName.'%');
        });

        if ($id != 0) {
            $query = $query->where('id', '!=', $id);
        }

        $array = $query->get();
        $result = $array->count() == 0;
        
        return Response()->json($result); 
    }

    public function checkId(Request $request) 
    {
        try {
            $result = true;
            $id = intval(Route::current()->parameter('employee'));

            //return Response()->json($request);
            $firstName = trim(request('firstName', false));
            $surname = trim(request('surname', false));
            $idNumber = trim(request('idNumber', false));

            $query = Employee::select(['id','first_name','surname']);
            // From Laravel 5.4 you can pass the same condition value as a parameter
            // https://laraveldaily.com/less-know-way-conditional-queries/
            $query->when(trim(request('idNumber', false)) != false, function ($q, $idNo) use($idNumber) { 
                return $q->where('id_number', $idNumber);
            });

            if ($id != 0) {
                $query = $query->where('id', '!=', $id);
            }

            $array = $query->get();

            // we found a record while in create mode( id = 0 )
            if ($id == 0 && $array->count() > 0) {
                return Response()->json(!$result);
            }

            $filtered = $array->filter(function ($employee, $key) use($firstName,$surname) {
                return ($employee->first_name != $firstName && $employee->surname != $surname);
            });
            //dump($query->toSql());
            //dump($query->getBindings());

            $result = $filtered->count() == 0;
            return Response()->json($result);

        }  catch (Exception $exception) {

        }
    }
    public function checkEmployeeNo(Request $request)
    {
        $result = true;
        $id = intval(Route::current()->parameter('employee'));

        $employeeNo = trim(request('employeeNo', false));

        $query = Employee::select(['id','first_name','surname','employee_no']);
        $query->when(trim(request('employeeNo', false)) != false, function ($q, $eNo) use($employeeNo) { 
            return $q->where('employee_no', $employeeNo);
        });

        if ($id != 0) {
            $query = $query->where('id', '!=', $id);
        }
        //dump($query->toSql());
        //dump($query->getBindings());

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
        $passportNo = trim(request('passportNo', false));
        $passportCountryId = trim(request('passportCountryId', false));

        if($passportNo == '' && $passportCountryId == ''){
            return Response()->json($result);
        }

        $query = Employee::select(['id','first_name','surname']);
        $query->when(trim(request('passportNo', false)) != false, function ($q, $pNo) use($passportNo) {
            return $q->where('passport_no', $passportNo);
        });
        $query->when(trim(request('passportCountryId', false)) != false, function ($q, $pCountryId) use($passportCountryId) { 
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
            'tax_number' => 'required_if:tax_status_id,3|min:0|max:50',
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

        $messages = [
            'tax_number.required' => 'The tax number is required if the tax status is set to taxable',
            'tax_number.required_if' => 'The tax number is required if the tax status is set to taxable'
        ];
        
        $this->validate($request, $validateFields, $messages);
    }

    private function getDropdownsData() 
    {
        $titles = Title::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $genders = Gender::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $maritalstatuses = MaritalStatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $countries = Country::orderBy('is_preferred','desc')->pluck('description','id')->all();
        $languages = Language::pluck('description','id')->all();
        $ethnicGroups = EthnicGroup::pluck('description','id')->all();
        $immigrationStatuses = ImmigrationStatus::pluck('description','id')->all();
        $taxstatuses = TaxStatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $departments = Department::pluck('description','id')->all();
        $teams = Team::pluck('description','id')->all();
        $employeeStatuses = EmployeeStatus::pluck('description','id')->all();
        $jobTitles = JobTitle::orderBy('description')->pluck('description','id')->all();
        $lineManagers = JobTitle::jobReportingLines()->all();
        $divisions = Division::pluck('description','id')->all();
        $branches = Branch::pluck('description','id')->all();
        $skills = Skill::pluck('description','id')->all();
        $disabilities = DisabilityCategory::with('disabilities')->withGlobalScope('system_predefined',1)->get();

        $results = array($titles, $genders, $maritalstatuses, $countries, $languages, $ethnicGroups, 
                         $immigrationStatuses, $taxstatuses, $departments, $teams, $employeeStatuses, 
                         $jobTitles, $lineManagers, $divisions, $branches, $skills, $disabilities
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

        $otherFields = ['_token','_method','attachment','redirectsTo','picture','profile_pic','homeAddress','postalAddress','homePhone','mobilePhone','workPhone','privateEmail','workEmail','skills','disabilities','qualifications'];
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

            TimelineManager::addEmployeeTimelineHistory($data);

        } else { // Update
            $this->contextObj->updateData($id, $input);
            $data = Employee::find($id);
            TimelineManager::updateEmployeeTimelineHistory($data);
        }

        $this->attach($request, $data->id);

        if(empty($homePhone['tel_number']) || empty($mobilePhone['tel_number']) || 
           empty($workPhone['tel_number'])) {
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

        $data->qualifications()->delete();
        if(isset($qualifications)){
            foreach($qualifications as $qual){
                $data->qualifications()->withTrashed()
                     ->updateOrCreate(['employee_id'=>$data->id, 'reference'=>$qual['reference']], $qual);
            }
        }

        $data->skills()->sync($skills);
        $data->disabilities()->sync($disabilities);

        //clear the cache for dashboard
        FlushDashboardCachedQueries::dispatch();
        
    }

    public function getEmployeeDepartmentId(Request $request)
    {
        $id = intval(Route::current()->parameter('employee'));
        $employee = Employee::select(['id','department_id'])->find($id);
        return Response()->json($employee);
    }


    public static function getManagerEmployees($manager_id){
        $employees_ids  = DB::table('employees')->select('employees.id','employees.first_name','employees.surname','employees.picture','genders.description as gender','job_titles.description as job_title','users.id as user_id')
        ->leftjoin('job_titles','job_titles.id','=','employees.job_title_id')
        ->leftjoin('genders','genders.id','=','employees.gender_id')
        ->leftjoin('users','users.employee_id','=','employees.id')
        ->where(function($q){
            $q->where('employees.date_terminated','<=','NOW()')
              ->orWhereNull('date_terminated');
        })
        ->where('employees.line_manager_id', $manager_id)
        ->get();
        return $employees_ids;
    }

    public static function getEmployeeFullName($employee_id){
        $fullname = Employee::select(DB::raw("CONCAT(first_name,' ',surname) as fullname"))
            ->where('id', $employee_id)
            ->pluck('fullname')
            ->first();
        return $fullname;
    }

    public static function getManagerEmployeeIds($manager_id){
        $employees_ids  = Employee::where('line_manager_id', $manager_id)
        ->where(function($q){
            $q->where('date_terminated','<=','NOW()')
              ->orWhereNull('date_terminated');
        })
        ->pluck('id')
        ->toArray();
        return $employees_ids;
    }

    public static function getDepartmentEmployees($department_id,$manager_id = null){
       if(empty($manager_id)){
           $employees_ids  = DB::table('employees')->select('id','first_name','surname')
               ->where(function($q){
                   $q->where('date_terminated','<=','NOW()')
                     ->orWhereNull('date_terminated');
               })
               ->where('department_id', $department_id)
               ->get();
       }else{
           $employees_ids  = DB::table('employees')->select('id','first_name','surname')
               ->where(function($q){
                   $q->where('date_terminated','<=','NOW()')
                       ->orWhereNull('date_terminated');
               })
               ->where('department_id', $department_id)
               ->where('id','!=',$manager_id)
               ->get();
       }
        return $employees_ids;
    }

}
