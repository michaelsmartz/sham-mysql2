<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomController;

use App\DateHelper;
use App\Employee;
use App\Http\Requests;
use App\TimeGroup;
use Carbon\Carbon;
use DateInterval;

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
        $employee_id  = \Auth::user()->id;
        $employeeObject = Employee::find($employee_id);

        $warnings = array();

        if (empty($employeeObject)) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }

        $workingHours = $this->getWorkingHours($employee_id);

        // load the view and pass the parameters
        return View::make('selfservice-portal.index')
            ->with('workingHours', $workingHours);
    }

    private function getWorkingHours($employee_id){
        $timeGroup = [];

        //dd($employee_id);

        $employee = Employee::find($employee_id);
        $team = $employee->team()->get(['description'])->first();
        $timeGroups = $employee->timeGroup()->get(['id','name'])->all();

        //dd($employee);
        //dd($team->description);
        //dd($timeGroups);

        if ($employee != null && $team != null && $timeGroups != null) {
            foreach ($timeGroups as $tg) {
                $timeGroup['team'] = $team->description;
                $timeGroup['id'] = $tg->id;
                $timeGroup['description'] = $tg->name;
            }
        }

        //dd($timeGroup['id']);

        if(sizeof($timeGroup) > 0){
            $tg = TimeGroup::find($timeGroup['id']);
            //dd($tg);

            $tgDays = $tg->days()->get(['name', 'day_id', 'day_number'])->all();
            $tgTimePeriods = $tg->timePeriods()->where('time_period_type',1)->get(['description', 'start_time', 'end_time'])->all();


            dd($tgDays);
            dd($tgTimePeriods);


//             if ($tgDays != null && $tgTimePeriods != null) {
//                $counter = 0;
//                $counter_days = 0;
//                foreach($tgDays as $tgDay) {
//
//                    $day = $tgDay->name;
//                    $timeDesc = $tmpTimePeriod->TimePeriod->Description;
//
//                    //if TimePeriodType 1:  is for working hours
//                    if($tmpTimePeriod->TimePeriod->TimePeriodType == 1) {
//                        $timeGroup = self::getOfficeHours($timeGroup, $tmpTimePeriod, $counter_days);
//                        $counter_days ++;
//                    }
//                    //if TimePeriodType 2: add lunch hours to array
//                    else if($tmpTimePeriod->TimePeriod->TimePeriodType == 2) {
//                        $timeGroup['time_period'][$day]['breaks'][$timeDesc]
//                            = self::getLunchHours($tmpTimePeriod);
//                    }
//
//                    $counter ++;
//                }
//            }
        }

//        return $timeGroup;
    }

    private static function timeIntervalReadable($value) {
        if ($value != null) {
            $interval = new DateInterval($value);
            return $interval->format('%H:%I');
        }
        return '00:00';
    }

    private function getOfficeHours($timeGroup, $tmpTimePeriod, $counter_days){
        if (!empty($tmpTimePeriod->TimePeriod->StartTime)) {
            $objStartTime = self::timeIntervalReadable($tmpTimePeriod->TimePeriod->StartTime);
            $timeGroup['time_period'][$tmpTimePeriod->Day->Name]['start_time'] = $objStartTime;
        }

        if (!empty($tmpTimePeriod->TimePeriod->StartTime)) {
            $objEndTime = self::timeIntervalReadable($tmpTimePeriod->TimePeriod->EndTime);
            $timeGroup['time_period'][$tmpTimePeriod->Day->Name]['end_time'] = $objEndTime;
        }

        $timeGroup['time_period'][$tmpTimePeriod->Day->Name]['day_count'] =  $counter_days;

        return $timeGroup;
    }

    private function getLunchHours($tmpTimePeriod){
        $lunchTime = [];
        if (!empty($tmpTimePeriod->TimePeriod->StartTime)) {
            $objStartTime = self::timeIntervalReadable($tmpTimePeriod->TimePeriod->StartTime);
            $lunchTime['start_time'] = $objStartTime;
        }

        if (!empty($tmpTimePeriod->TimePeriod->StartTime)) {
            $objEndTime = self::timeIntervalReadable($tmpTimePeriod->TimePeriod->EndTime);
            $lunchTime['end_time'] = $objEndTime;
        }

        return $lunchTime;
    }
}

