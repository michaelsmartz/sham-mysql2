<?php

namespace App\Http\Controllers;
use App\MaritalStatus;
use App\Employee;

use App\Timeline;
use App\Violation;
use Illuminate\Http\Request;
use App\Libs\Extensions\Input;

use Auth;
use View;
use Redirect;
use Validator;
use Session;

class SSPMyDetailsController extends CustomController
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){
        $this->contextObj = new Employee();
        $this->baseViewPath = 'selfservice-portal.profile';
    }

    //functions necessary to handle 'resource' type of route
    public function index()
    {
        $warnings = [];
        $id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        if ($id == 0) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }

        // get the employee
        $employee = $this->contextObj::find($id);

        $attachments = [];

        $maritalStatus = MaritalStatus::pluck('description', 'id');

        // show the view and pass the nerd to it
        return view($this->baseViewPath .'.index', compact('employee', 'warnings','attachments', 'maritalStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $warnings = [];

        // get the employee

        $id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $employee = $this->contextObj->fill(Input::all());

        dd($employee);

    }

//    public function show(Request $request){
//        self::getProfile($request);
//    }

    public function show(Request $request) {
        $employee = [];
        $id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $tmp = $this->contextObj::with(['jobTitle',
                                        'department',
                                        'branch',
                                        'division',
                                        'team',
                                        'addresses',
                                        'emails',
                                        'phones',
                                        'timelines.timelineEventType',
                                        'historyDepartments.department',
                                        'historyRewards.reward',
                                        'historyDisciplinaryActions.disciplinaryAction',
                                        'historyJoinsTerminations',
                                        'historyJobTitles.jobTitle',
                                        'historyQualification.qualification',
                                ])
                                ->where('id',$id)
                                ->get()
                                ->first();

        if(!empty($tmp)){
            $employee = self::getAdditionalFields($tmp);
        }
        
        $timelineData = self::getTimeline($employee);

        //$filesData = self::getFiles($employee);

        return response()->json(['data' => $employee,
                                 'timeline' => $timelineData,
                                 //'files' => $filesData
                            ], 200);
    }

    private static function getAdditionalFields($employeeObject)
    {
        if(!empty($employeeObject->known_as)) {
            $employeeObject->full_name .= " (" . $employeeObject->known_as. ")";
        }
        if(!empty($employeeObject->date_joined)) {
            $employeeObject->formatted_date_joined = date("d-m-Y", strtotime($employeeObject->date_joined));
        }

        if(empty($employeeObject->picture) || strlen($employeeObject->picture) < 10){
            $employeeObject->picture = "/img/avatar.png";
        }

        if (isset($employeeObject->jobTitle)) {
            $employeeObject->job = $employeeObject->jobTitle->description;
        }

        if (isset($employeeObject->team)) {
            $employeeObject->team = $employeeObject->team->description;
        }

        if (isset($employeeObject->department)) {
            $employeeObject->department = $employeeObject->department->description;
        }

        if (isset($employeeObject->branch)) {
            $employeeObject->branch = $employeeObject->branch->description;
        }

        if (isset($employeeObject->division)) {
            $employeeObject->division = $employeeObject->division->description;
        }

        if ($employeeObject != null) {
            if (isset($employeeObject->addresses)) {
                foreach ($employeeObject->addresses as $address) {

                    switch ($address->address_type_id) {
                        case 1://Home:
                            $employeeObject->HomeAddressUnitNo = $address->unit_no;
                            $employeeObject->HomeAddressComplex = $address->complex;
                            $employeeObject->HomeAddressLine1 = $address->addr_line_1;
                            $employeeObject->HomeAddressLine2 = $address->addr_line_2;
                            $employeeObject->HomeAddressLine3 = $address->addr_line_3;
                            $employeeObject->HomeAddressLine4 = $address->addr_line_4;
                            $employeeObject->HomeAddressCity = $address->city;
                            $employeeObject->HomeAddressProvince = $address->province;
                            $employeeObject->HomeAddressCountryId = $address->country_id;
                            $employeeObject->HomeAddressZipCode = $address->zip_code;
                            break;
                        case 2://Postal
                            $employeeObject->PostalAddressUnitNo = $address->unit_no;
                            $employeeObject->PostalAddressComplex = $address->complex;
                            $employeeObject->PostalAddressLine1 = $address->addr_line_1;
                            $employeeObject->PostalAddressLine2 = $address->addr_line_2;
                            $employeeObject->PostalAddressLine3 = $address->addr_line_3;
                            $employeeObject->PostalAddressLine4 = $address->addr_line_4;
                            $employeeObject->PostalAddressCity = $address->city;
                            $employeeObject->PostalAddressProvince = $address->province;
                            $employeeObject->PostalAddressCountryId = $address->country_id;
                            $employeeObject->PostalAddressZipCode = $address->zip_code;
                            break;
                    }

                }
                unset($employeeObject->addresses);

            }

            //Adjust Tel Numbers
            if (isset($employeeObject->phones)) {
                foreach ($employeeObject->phones as $tel) {

                    switch ($tel->telephone_number_type_id) {
                        case 1://Home:
                            $employeeObject->HomeTel = $tel->tel_number;

                            break;
                        case 2://Mobile
                            $employeeObject->Mobile = $tel->tel_number;

                            break;
                        case 3://work
                            $employeeObject->WorkTel = $tel->tel_number;
                            break;
                    }

                }
                unset($employeeObject->phones);

            }

            //Adjust Email Addresses
            if (isset($employeeObject->emails)) {
                foreach ($employeeObject->emails as $email) {

                    switch ($email->email_address_type_id) {
                        case 1://Private:
                            $employeeObject->HomeEmailAddress = $email->email_address;
                            break;
                        case 2://Work
                            $employeeObject->WorkEmailAddress = $email->email_address;
                            break;
                    }
                }
                unset($employeeObject->emails);
            }
        }

        return $employeeObject;
    }


    private static function getTimeline($employee) {

        $timeCompileResults = [];

        foreach($employee->timelines as $timeline) {
            $timelineEventType = $timeline->timelineEventType->name;
            $readableDesc = $timeline->timelineEventType->description;
            $eventid = trim($timeline->event_id);

            switch ($timelineEventType) {
                case "Departments":
                    $historyDepartments =  $employee->historyDepartments->where('id', $timeline->event_id);

                    if(count($historyDepartments) > 0)
                    {
                        //dd($historyDepartments);
                        foreach ($historyDepartments as $historyDepartment) {
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 1;
                            $timeline->MainClass = 'info';
                            $timeline->Description = "Joined Department: " . $historyDepartment->department->description;
                            $timeline->EventType = $timelineEventType;
                            //$timelineresultObj->Date = "Date: ".$historyDepartments[0]->Date;
                            $timeline->formattedDate = date("d-m-Y", strtotime($historyDepartment->date));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Rewards":
                    $historyRewards =  $employee->historyRewards->where('id', $timeline->event_id);

                    if(count($historyRewards) > 0)
                    {
                        foreach ($historyRewards as $historyReward) {
                            //dd($timeline);
                            //dump($historyReward);
                            $timeline = new $timeline();
                            $timeline->ShortcutType = 2;
                            $timeline->MainClass = 'success';
                            $timeline->Description = "Reward: " . $historyReward->reward->description;
                            $timeline->EventType = $timelineEventType;
                            $timeline->formattedDate = date("d-m-Y", strtotime($historyReward->date_occurred));
                            $timeline->icon = 'fa fa-certificate';
                            $timeCompileResults[] = $timeline;
                        }
                        //die();
                    }
                    break;
                case "Disciplinary":
                    $historyDisciplinaries =  $employee->historyDisciplinaryActions->where('id', $timeline->event_id);

                    if (count($historyDisciplinaries) > 0) {
                        foreach ($historyDisciplinaries as $historyDisciplinary) {
                            //dd($historyDisciplinary);
                            $timeline = new $timeline();
                            $timeline->ShortcutType = 3;
                            $timeline->MainClass = 'danger';
                            $violation = Violation::find($historyDisciplinary->disciplinaryAction->violation_id);
                            $timeline->DisciplinaryActionId = $historyDisciplinary->disciplinary_action_id;
                            $timeline->Description = "Discriplinary Action: " . $violation->description;
                            $timeline->EventType = "Discriplinary Action";//$timelineeventype;
                            //$timelineresultObj->Date = "Date: " . $timeline->EventDate;
                            $timeline->formattedDate = date("d-m-Y", strtotime($historyDisciplinary->date_occurred));
                            $timeCompileResults[] = $timeline;
                            If ($violation->id == 3) {
                                $timeline->icon = 'vs vs-no-smoking-alt';
                            } else {
                                $timeline->icon = 'fa fa-ban';
                            }
                        }
                    }
                    break;
                case "JoinTerminationDate":
                    $historyJoinTerminations = $employee->historyJoinsTerminations->where('id', $timeline->event_id);

                    if (count($historyJoinTerminations) > 0) {
                        foreach ($historyJoinTerminations as $historyJoinTermination) {
                            $timeline = new $timeline();
                            $timeline->ShortcutType = 4;

                            if ($historyJoinTermination->is_joined == true) {
                                $timeline->Description = "Joined Date";
                                $timeline->MainClass = 'success';
                                $timeline->formattedDate =  date("d-m-Y", strtotime($employee->date_joined));
                            } else {
                                $timeline->Description = "Termination";
                                $timeline->formattedDate = date("d-m-Y", strtotime($historyJoinTermination->date_occurred));
                                $timeline->MainClass = 'warning';
                                $timeline->icon = 'fa fa-sign-out';
                            }

                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "JobTitles":
                    $historyJobTitles = $employee->historyJobTitles->where('id', $timeline->event_id);

                    if(count($historyJobTitles) > 0)
                    {
                        foreach ($historyJobTitles as $historyJobTitle) {
                            $timeline = new $timeline();
                            $timeline->ShortcutType = 5;
                            $timeline->MainClass = 'info';
                            $timeline->Description = "Started as: " . $historyJobTitle->jobTitle->description;
                            $timeline->formattedDate = date("d-m-Y", strtotime($historyJobTitle->date_occurred));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Qualifications":

                    $historyQualifications = $employee->historyQualification->where('id', $timeline->event_id)->get();

                    if(count($historyQualifications) > 0)
                    {
                        foreach ($historyQualifications as $historyQualification) {
                            $timeline = new $timeline();
                            $timeline->ShortcutType = 6;
                            $timeline->MainClass = 'success';
                            $timeline->Description = "Obtained: " . $historyQualification->qualification->description;
                            $timeline->formattedDate = date("d-m-Y", strtotime($historyQualification->date));
                            $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        return $timeCompileResults;

    }
}

