<?php

namespace App\Http\Controllers;
use App\Address;
use App\EmailAddress;
use App\Enums\TimelineEventType;
use App\MaritalStatus;
use App\Employee;

use App\Support\Helper;
use App\SystemSubModule;
use App\TelephoneNumber;
use App\Timeline;
use App\Violation;
use Illuminate\Http\Request;

use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Plank\Mediable\Media;
use Plank\Mediable\Mediable;
use View;
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

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_MY_DETAILS);

        if ($allowedActions == null || !$allowedActions->contains('List')){
            return View('not-allowed')
                ->with('title', 'Profile')
                ->with('warnings', array('You do not have permissions to access this page.'));
        }

        // get the employee
        $employee = $this->contextObj::find($id);

        $warnings = array();

        if (empty($employee)) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }

        if (empty($employee)) {
            return View('not-allowed')
                ->with('title', 'My Details')
                ->with('warnings', array('Please check whether your profile is associated to an employee!'));
        }

        $attachments = [];

        $maritalStatus = MaritalStatus::pluck('description', 'id');

        // show the view and pass the nerd to it
        return view($this->baseViewPath .'.index', compact('employee', 'warnings','attachments', 'maritalStatus'));
    }

    /**
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $warnings = [];
        $input = array_except($request->all(), ['_token', '_method']);

        $employee = array_only($input, ['marital_status_id', 'spouse_full_name']);

        $res =  $this->contextObj->updateData($id, $employee);
        $data = Employee::find($id);

        if($res){
            //handle the Home Address
            $homeAddress = [];

            $homeAddressInputs = array_only($input, [
                'HomeAddressUnitNo',
                'HomeAddressComplex',
                'HomeAddressLine1',
                'HomeAddressLine2',
                'HomeAddressLine3',
                'HomeAddressLine4',
                'HomeAddressCity',
                'HomeAddressProvince',
                'HomeAddressZipCode'
            ]);

            if(is_null($homeAddressInputs['HomeAddressUnitNo']) || is_null($homeAddressInputs['HomeAddressComplex']) ||
                is_null($homeAddressInputs['HomeAddressLine1']) || is_null($homeAddressInputs['HomeAddressLine2']) ||
                is_null($homeAddressInputs['HomeAddressLine3']) || is_null($homeAddressInputs['HomeAddressLine4']) ||
                is_null($homeAddressInputs['HomeAddressCity']) || is_null($homeAddressInputs['HomeAddressProvince']) ||
                is_null($homeAddressInputs['HomeAddressZipCode'])
            ) {
                Address::where('employee_id', '=', $data->id)->where('address_type_id',1)->delete();
            }

            $homeAddress['unit_no']= $homeAddressInputs['HomeAddressUnitNo'];
            $homeAddress['complex']= $homeAddressInputs['HomeAddressComplex'];
            $homeAddress['addr_line_1']= $homeAddressInputs['HomeAddressLine1'];
            $homeAddress['addr_line_2']= $homeAddressInputs['HomeAddressLine2'];
            $homeAddress['addr_line_3']= $homeAddressInputs['HomeAddressLine3'];
            $homeAddress['addr_line_4']= $homeAddressInputs['HomeAddressLine4'];
            $homeAddress['city']= $homeAddressInputs['HomeAddressCity'];
            $homeAddress['province']= $homeAddressInputs['HomeAddressProvince'];
            $homeAddress['zip_code']= $homeAddressInputs['HomeAddressZipCode'];

            if(!empty($homeAddress)){
                $data->addresses()
                    ->updateOrCreate(['employee_id'=>$data->id, 'address_type_id'=>1],
                        $homeAddress);
            }

            //handle the Postal Address
            $postalAddress = [];

            $postalAddressInputs = array_only($input, [
                'PostalAddressUnitNo',
                'PostalAddressComplex',
                'PostalAddressLine1',
                'PostalAddressLine2',
                'PostalAddressLine3',
                'PostalAddressLine4',
                'PostalAddressCity',
                'PostalAddressProvince',
                'PostalAddressZipCode'
            ]);

            if(is_null($postalAddressInputs['PostalAddressUnitNo']) || is_null($postalAddressInputs['PostalAddressComplex']) ||
                is_null($postalAddressInputs['PostalAddressLine1']) || is_null($postalAddressInputs['PostalAddressLine2']) ||
                is_null($postalAddressInputs['PostalAddressLine3']) || is_null($postalAddressInputs['PostalAddressLine4']) ||
                is_null($postalAddressInputs['PostalAddressCity']) || is_null($postalAddressInputs['PostalAddressProvince']) ||
                is_null($postalAddressInputs['PostalAddressZipCode'])
            ) {
                Address::where('employee_id', '=', $data->id)->where('address_type_id',2)->delete();
            }

            $postalAddress['unit_no']= $postalAddressInputs['PostalAddressUnitNo'];
            $postalAddress['complex']= $postalAddressInputs['PostalAddressComplex'];
            $postalAddress['addr_line_1']= $postalAddressInputs['PostalAddressLine1'];
            $postalAddress['addr_line_2']= $postalAddressInputs['PostalAddressLine2'];
            $postalAddress['addr_line_3']= $postalAddressInputs['PostalAddressLine3'];
            $postalAddress['addr_line_4']= $postalAddressInputs['PostalAddressLine4'];
            $postalAddress['city']= $postalAddressInputs['PostalAddressCity'];
            $postalAddress['province']= $postalAddressInputs['PostalAddressProvince'];
            $postalAddress['zip_code']= $postalAddressInputs['PostalAddressZipCode'];

            if(!empty($postalAddress)){
                $data->addresses()
                    ->updateOrCreate(['employee_id'=>$data->id, 'address_type_id'=>2],
                        $postalAddress);
            }

            $phone = array_only($input, [
                'HomeTel',
                'Mobile',
                'WorkTel'
            ]);

            if(is_null($phone['HomeTel']) || is_null($phone['HomeTel']) ||
                is_null($phone['WorkTel'])) {
                TelephoneNumber::where('employee_id', '=', $data->id)->delete();
            }

           //Home
            if(!is_null($phone['HomeTel'])){
                $homePhone = ['tel_number' => $phone['HomeTel']];
                $data->phones()
                    ->updateOrCreate(['employee_id'=>$data->id, 'telephone_number_type_id'=>1],
                        $homePhone);
            }

            //Mobile
            if(!is_null($phone['Mobile'])){
                $mobilePhone = ['tel_number' => $phone['Mobile']];
                $data->phones()
                    ->updateOrCreate(['employee_id'=>$data->id, 'telephone_number_type_id'=>2],
                        $mobilePhone);
            }

            //Work
            if(!is_null($phone['WorkTel'])){
                $workPhone = ['tel_number' => $phone['WorkTel']];
                $data->phones()
                    ->updateOrCreate(['employee_id'=>$data->id, 'telephone_number_type_id'=>3],
                        $workPhone);
            }

            //email
            $email = array_only($input, [
                'HomeEmailAddress'
            ]);

            if(is_null($email['HomeEmailAddress'])) {
                EmailAddress::where('employee_id', '=', $data->id)->delete();
            }

            if(!is_null($email['HomeEmailAddress'])){
                $homeEmail = ['email_address' => $email['HomeEmailAddress']];
                $data->emails()
                    ->updateOrCreate(['employee_id'=>$data->id, 'email_address_type_id'=>1],
                        $homeEmail);
            }

            return response()->json(['msg' => 'success', 'status' =>200]);
        }else{
            return response()->json(['msg' => 'failure', 'status' =>500]);
        }
    }

    public function getProfile(Request $request) {
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
            'timelines'])
        ->with([
            'historyDepartments.department'=> function ($query) {
                $query->withTrashed();
            }
        ])
        ->with([
            'historyRewards.reward'=> function ($query) {
                $query->withTrashed();
            }
        ])
        ->with([
            'historyDisciplinaryActions.disciplinaryAction'=> function ($query) {
                $query->withTrashed();
            }
        ])
        ->with([
            'historyJoinTermination'
        ])
        ->with([
            'historyJobTitles.jobTitle'=> function ($query) {
                $query->withTrashed();
            }
        ])
        ->with([
            'historyQualification.qualification'=> function ($query) {
                $query->withTrashed();
            }
        ])
        ->where('employees.id',$id)
        ->get()
        ->first();

        if(!empty($tmp)){
            $employee = self::getAdditionalFields($tmp);
        }
        
        $timelineData = self::getTimeline($employee);

        $filesData = self::getFiles($employee);

        return response()->json(['data' => $employee,
                                 'timeline' => $timelineData,
                                 'files' => $filesData
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

        if(!isset($employeeObject->picture)){
            $employeeObject->picture = "/img/avatar.png";
        }

        if (isset($employeeObject->jobTitle)) {
            $employeeObject->job = optional($employeeObject->jobTitle)->description;
        }

        if (isset($employeeObject->team)) {
            $employeeObject->team = optional($employeeObject->team)->description;
        }

        if (isset($employeeObject->department)) {
            $employeeObject->department = optional($employeeObject->department)->description;
        }

        if (isset($employeeObject->branch)) {
            $employeeObject->branch = optional($employeeObject->branch)->description;
        }

        if (isset($employeeObject->division)) {
            $employeeObject->division = optional($employeeObject->division)->description;
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
                            $employeeObject->address_type_id = $address->address_type_id;
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
                            $employeeObject->address_type_id = $address->address_type_id;
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

        foreach( $employee->timelines as $timeline) {
            $timelineEventType = TimelineEventType::getDescription($timeline->timeline_event_type_id);
            $event_id = trim($timeline->event_id);

            switch ($timelineEventType) {
                case "Department":
                    $historyDepartments =  $employee->historyDepartments->where('id', $event_id);

                    if(count($historyDepartments) > 0)
                    {
                        foreach ($historyDepartments as $historyDepartment) {
                                $timeline = new Timeline();
                                $timeline->ShortcutType = 1;
                                $timeline->MainClass = 'info';
                                $timeline->Description = "Joined Department: " . optional($historyDepartment->department)->description;
                                $timeline->EventType = $timelineEventType;
                                $timeline->formattedDate = date("Y-m-d", strtotime($historyDepartment->date_occurred));
                                $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Reward":
                    $historyRewards =  $employee->historyRewards->where('id', $event_id);

                    if(count($historyRewards) > 0)
                    {
                        foreach ($historyRewards as $historyReward) {
                                $timeline = new Timeline();
                                $timeline->ShortcutType = 2;
                                $timeline->MainClass = 'success';
                                $timeline->Description = "Reward: " . optional($historyReward->reward)->description;
                                $timeline->EventType = $timelineEventType;
                                $timeline->formattedDate = date("Y-m-d", strtotime($historyReward->date_occurred));
                                $timeline->icon = 'fa fa-certificate';
                                $timeCompileResults[] = $timeline;
                        }
                    }
                    break;
                case "Disciplinary Action":
                    $historyDisciplinaries =  $employee->historyDisciplinaryActions->where('id', $event_id);

                    if (count($historyDisciplinaries) > 0) {
                        foreach ($historyDisciplinaries as $historyDisciplinary) {
                                $timeline = new Timeline();
                                $timeline->ShortcutType = 3;
                                $timeline->MainClass = 'danger';
                                $violation = Violation::find($historyDisciplinary->disciplinaryAction->violation_id);
                                $timeline->DisciplinaryActionId = $historyDisciplinary->disciplinary_action_id;
                                $timeline->Description = "Discriplinary Action: " . $violation->description;
                                $timeline->EventType = "Discriplinary Action";//$timelineeventype;
                                $timeline->formattedDate = date("Y-m-d", strtotime($historyDisciplinary->date_occurred));
                                $timeCompileResults[] = $timeline;
                                If ($violation->id == 3) {
                                    $timeline->icon = 'vs vs-no-smoking-alt';
                                } else {
                                    $timeline->icon = 'fa fa-ban';
                                }
                        }
                    }
                    break;
                case "Join/Termination Date":
                    $historyJoinTerminations = $employee->historyJoinTermination->where('id', $event_id);

                    if (count($historyJoinTerminations) > 0) {
                        foreach ($historyJoinTerminations as $historyJoinTermination) {
                            $timeline = new Timeline();
                            $timeline->ShortcutType = 4;

                            if ($historyJoinTermination->is_joined == true) {
                                $timeline->Description = "Joined Date";
                                $timeline->MainClass = 'success';
                                $timeline->formattedDate =  date("Y-m-d", strtotime($employee->date_joined));
                            } else {
                                $timeline->Description = "Termination";
                                $timeline->formattedDate = date("Y-m-d", strtotime($historyJoinTermination->date_occurred));
                                $timeline->MainClass = 'warning';
                                $timeline->icon = 'fa fa-sign-out';
                            }

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
                                $timeline->ShortcutType = 5;
                                $timeline->MainClass = 'info';
                                $timeline->Description = "Started as: " . optional($historyJobTitle->jobTitle)->description;
                                $timeline->formattedDate = date("Y-m-d", strtotime($historyJobTitle->date_occurred));
                                $timeCompileResults[] = $timeline;
                        }
                    }
                    break;

                case "Qualification":

                    $historyQualifications = $employee->historyQualification->where('id', $event_id)->get();

                    if(count($historyQualifications) > 0)
                    {
                        foreach ($historyQualifications as $historyQualification) {
                                $timeline = new Timeline();
                                $timeline->ShortcutType = 6;
                                $timeline->MainClass = 'success';
                                $timeline->Description = "Obtained: " . optional($historyQualification->qualification)->description;
                                $timeline->formattedDate = date("Y-m-d", strtotime($historyQualification->date_occurred));
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

    private static function getFiles($employee) {
        $attachments = [];

        if(count($employee->getAllMediaByTag())>0) {
            $medias = $employee->getAllMediaByTag()->get('Employee')->all();

            if ($medias != null) {
                foreach ($medias as $media) {
                    $downloadLink = URL::to('/') .
                        DIRECTORY_SEPARATOR . 'employees' .
                        DIRECTORY_SEPARATOR . $employee->id .
                        DIRECTORY_SEPARATOR . 'attachment' .
                        DIRECTORY_SEPARATOR . $media->id;

                    $attachments[] = array(
                        'Id' => $media->id,
                        'OriginalFileName' => $media->filename . '.' . $media->extension,
                        'Comment' => $media->comment,
                        'EmployeeAttachmentTypeId' => $media->extrable_id,
                        //'EmployeeAttachmentDescription' => $media->EmployeeAttachmentType->Description, //EmployeeAttachmentType
                        'FileExtension' => $media->extension,
                        'Size' => $media->size,
                        'HumanReadableSize' => $media->readableSize(),
                        'ExtendedMime' => $media->mime_type,
                        'DownloadLink' => $downloadLink
                    );
                }
            }
        }

        return $attachments;
    }
}

