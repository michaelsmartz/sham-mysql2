<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Asset;
use App\AssetEmployee;
use App\Department;

use App\DateHelper;
use App\Employee;
use App\Enums\DayType;
use App\Http\Requests;
use App\Support\Helper;
use App\SystemSubModule;
use App\TimeGroup;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

use View;

class SSPController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){
        $this->contextObj = new Employee();
        $this->baseViewPath = 'selfservice-portal.portal';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $employee_id  = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $employeeObject =  $this->contextObj::find($employee_id);

        $warnings = array();

        if (empty($employeeObject)) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }

        $workingHours = $this->getWorkingHours($employeeObject);

        //dd($workingHours);
        $announcements = $this->getAnnouncements($employeeObject);
        $assets = $this->getAllocatedAssets($employeeObject);

        $allowedActions = getAllowedActions(SystemSubModule::CONST_MY_PORTAL);

        if ($allowedActions == null || !$allowedActions->contains('List')){
            return View('not-allowed')
                ->with('title', 'My Portal')
                ->with('warnings', array('You do not have permissions to access this page.'));
        }

        $allowedActionsAnnouncements = getAllowedActions(SystemSubModule::CONST_ANNOUNCEMENTS);
        $allowedActionsAssets = getAllowedActions(SystemSubModule::CONST_ASSETS_MANAGEMENT);
        $leaves = $this->getEmployeeLeaves($employee_id);


        // load the view and pass the parameters
        return view($this->baseViewPath .'.index',
            compact('warnings', 'announcements', 'assets','workingHours', 'allowedActionsAssets', 'allowedActionsAnnouncements','leaves'));
    }

    private function getWorkingHours($employee){
        $timeGroup = [];
        $tg= [];

        if (empty($employee)) {
            return $timeGroup;
        }

        if ($employee != null && $employee->team() != null && $employee->timeGroup() != null) {
            $team = $employee->team()->get(['description','time_group_id'])->first();
            $tg = TimeGroup::find($team['time_group_id']);
            $timeGroup['team'] = $team->description;
            $timeGroup['description'] = $tg->name;
        }else{
            $timeGroup['team'] = [];
        }

        if(sizeof($tg) > 0) {
            $tgTimePeriods = $tg->timePeriods()->get(['description', 'start_time', 'end_time', 'time_period_type'])->all();

            if (!empty($timeGroup) && $tgTimePeriods != null) {
                $counter_days = 0;
                foreach ($tgTimePeriods as $tgTimePeriod) {
                    $day = DayType::getDescription($tgTimePeriods[$counter_days]->pivot->day_id);
                        //if TimePeriodType 1:  is for working hours
                        if ($tgTimePeriod->time_period_type == 1) {
                        $timeGroup['time_period'][$day]['description'] = $tgTimePeriod->description;
                        $timeGroup['time_period'][$day]['start_time'] = $tgTimePeriod->start_time;
                        $timeGroup['time_period'][$day]['end_time'] = $tgTimePeriod->end_time;
                        $timeGroup['time_period'][$day]['day_count'] = $counter_days;
                        }
                        //if TimePeriodType 2: add lunch hours to array
                        else if ($tgTimePeriod->time_period_type == 2) {
                            $timeGroup['time_period'][$day]['breaks'][$tgTimePeriod->description]
                                = self::getLunchHours($tgTimePeriod);
                        }
                        $counter_days++;
                }
            }
        }

        return ['timegroup' => $timeGroup, 'team'=>  $timeGroup['team'] ];
    }

    private static function timeIntervalReadable($value) {
        if ($value != null) {
            $interval = new DateTime($value);
            return $interval->format('G:i');
        }
        return '00:00';
    }

    private function getOfficeHours($timeGroup, $tgTimePeriod, $counter_days){
        if (!empty($tgTimePeriod->start_time)) {
            $objStartTime = self::timeIntervalReadable($tgTimePeriod->start_time);
            $timeGroup['time_period'][$tgTimePeriod->name]['start_time'] = $objStartTime;
        }

        if (!empty($tgTimePeriod->end_time)) {
            $objEndTime = self::timeIntervalReadable($tgTimePeriod->end_time);
            $timeGroup['time_period'][$tgTimePeriod->name]['end_time'] = $objEndTime;
        }

        $timeGroup['time_period'][$tgTimePeriod->name]['day_count'] =  $counter_days;

        return $timeGroup;
    }

    private function getLunchHours($tgTimePeriod){
        $lunchTime = [];
        if (!empty($tgTimePeriod->start_time)) {
            $objStartTime = self::timeIntervalReadable($tgTimePeriod->start_time);
            $lunchTime['start_time'] = $objStartTime;
        }

        if (!empty($tgTimePeriod->end_time)) {
            $objEndTime = self::timeIntervalReadable($tgTimePeriod->end_time);
            $lunchTime['end_time'] = $objEndTime;
        }

        return $lunchTime;
    }

    private function getAnnouncements($employee) {

        $announcements = [];

        if (empty($employee)) {
            return $announcements;
        }

        if ($employee != null) {
            $temp = Announcement::with(['departments'])
                ->where('announcement_status_id', 1)
                ->orderBy('priority', 'ASC')
                ->get()
                ->all();
            $count = 0;
            foreach ($temp as $t){
                /**
                 * TODO add to filter announcement by departments
                 */
                //if(count($t->departments) == 0) {
                    if (DateHelper::todayInRangeIncluded($t->start_date, $t->end_date)) {
                        $announcements[$count]['Id'] = $t->announcement_id;
                        $announcements[$count]['Title'] = $t->title;
                        $announcements[$count]['Description'] = $t->description;
                        $count++;
                    }
                //}else{

                //}
            }
        }

        return $announcements;
    }

    private function getAllocatedAssets($employee) {

        $assets = [];

        if (empty($employee)) {
            return $assets;
        }

        $temp = $employee->assetEmployee()->with('asset')->get()->all();

        if ($temp != null) {
            $count = 0;
            foreach($temp as $t) {
                if (empty($t->date_in) ||
                    (!empty($t->date_in) && DateHelper::isTodayIncluded($t->date_in))) {
                    $assets[$count]['WarrantyExpiryDate'] = $t->asset->warrantyexpires_at;
                    $assets[$count]['DateOut'] = $t->date_out;
                    $assets[$count]['PurchasePrice'] = $t->asset->purchase_price;
                    $assets[$count]['Name'] = $t->asset->name;
                    $count++;
                }
            }
        }

        return $assets;
    }


    private function getEmployeeLeaves($employee_id){

        $employee_leave= DB::select(
            "SELECT abs.description as absence_description,ele.total,ele.taken,(ele.total - ele.taken) as remaining,abe.starts_at,abe.ends_at,abe.status,CONCAT(emp.first_name,\" \",emp.surname) as validator
            FROM absence_type_employee abe
            LEFT JOIN absence_types abs ON abs.id = abe.absence_type_id
            LEFT JOIN eligibility_employee ele ON ele.absence_type_id =abs.id
            LEFT JOIN employees emp ON abe.approved_by_employee_id = emp.id
            WHERE abe.employee_id = $employee_id;"
        );

        return $employee_leave;


    }
}

