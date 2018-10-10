<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Asset;
use App\AssetEmployee;
use App\Department;

use App\DateHelper;
use App\Employee;
use App\Http\Requests;
use App\TimeGroup;
use Carbon\Carbon;
use DateTime;

use View;

class SSPController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $employee_id  = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $employeeObject = Employee::find($employee_id);

        $warnings = array();

        if (empty($employeeObject)) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }

        $workingHours = $this->getWorkingHours($employeeObject);
        $announcements = $this->getAnnouncements($employeeObject);
        $assets = $this->getAllocatedAssets($employeeObject);

        // load the view and pass the parameters
        return View::make('selfservice-portal.portal.index',
            compact('warnings', 'announcements', 'assets','workingHours'));
    }

    private function getWorkingHours($employee){
        $timeGroup = [];

        if (empty($employee)) {
            return $timeGroup;
        }

        if ($employee != null && $employee->team() != null && $employee->timeGroup() != null) {
            $team = $employee->team()->get(['description'])->first();
            $timeGroups = $employee->timeGroup()->get(['id','name'])->all();

            foreach ($timeGroups as $tg) {
                $timeGroup['team'] = $team->description;
                $timeGroup['id'] = $tg->id;
                $timeGroup['description'] = $tg->name;
            }
        }

        if(sizeof($timeGroup) > 0) {
            $tg = TimeGroup::find($timeGroup['id']);

            $tgDays = $tg->days()->get(['name', 'day_id', 'day_number'])->all();
            $tgTimePeriods = $tg->timePeriods()->get(['description', 'start_time', 'end_time', 'time_period_type'])->all();

            if (!empty($timeGroup) && $tgTimePeriods != null && $tgDays != null) {
                foreach ($tgTimePeriods as $tgTimePeriod) {
                    $counter_days = 0;
                    foreach ($tgDays as $tgDay) {
                        //if TimePeriodType 1:  is for working hours
                        if ($tgTimePeriod->time_period_type == 1) {
                        $timeGroup['time_period'][$tgDay->name]['description'] = $tgTimePeriod->description;
                        $timeGroup['time_period'][$tgDay->name]['start_time'] = $tgTimePeriod->start_time;
                        $timeGroup['time_period'][$tgDay->name]['end_time'] = $tgTimePeriod->end_time;
                        $timeGroup['time_period'][$tgDay->name]['day_count'] = $counter_days;
                        }
                        //if TimePeriodType 2: add lunch hours to array
                        else if ($tgTimePeriod->time_period_type == 2) {
                            $timeGroup['time_period'][$tgDay->name]['breaks'][$tgTimePeriod->description]
                                = self::getLunchHours($tgTimePeriod);
                        }
                        $counter_days++;
                    }
                }
            }
        }

        return $timeGroup;
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


        if ($employee != null && $employee->department() != null) {
            $department = $employee->department()->get(['id','description'])->first();

            if($department != null) {
                $temp = $department->announcements()->where('announcement_status_id', 1)
                    ->orderBy('priority', 'ASC')
                    ->get(['announcement_id', 'title', 'description', 'start_date', 'end_date', 'priority'])
                    ->all();

                $count = 0;
                foreach ($temp as $t){
                    if(DateHelper::todayInRangeIncluded($t->start_date, $t->end_date)) {
                        $announcements[$count]['Id'] = $t->announcement_id;
                        $announcements[$count]['Title'] = $t->title;
                        $announcements[$count]['Description'] = $t->description;
                        $count++;
                    }
                }
            }
        }

        return $announcements;
    }

    private function getAllocatedAssets($employee) {

        $assets = [];

        if (empty($employee)) {
            return $assets;
        }

        $temp = $employee->assetEmployee()->get()->all();
        if ($temp != null) {
            $count = 0;
            foreach($temp as $t) {
              $asset = Asset::find($t->asset_id)->first();
                if (empty($t->date_in) ||
                    (!empty($t->date_in) && DateHelper::isTodayIncluded($t->date_in))) {
                    $assets[$count]['WarrantyExpiryDate'] = $asset->warrantyexpires_at;
                    $assets[$count]['DateOut'] = $t->date_out;
                    $assets[$count]['PurchasePrice'] = $asset->purchase_price;
                    $assets[$count]['Name'] = $asset->name;
                    $count++;
                }
            }
        }

        return $assets;
    }
}

