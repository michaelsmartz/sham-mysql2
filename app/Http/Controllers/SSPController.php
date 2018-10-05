<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CustomController;

use App\DateHelper;
use App\Employee;
use App\Http\Requests;
use App\TimeGroup;
use Carbon\Carbon;
use DateTime;

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
        return \View::make('selfservice-portal.index')
            ->with('workingHours', $workingHours);
    }

    private function getWorkingHours($employee_id){
        $timeGroup = [];

        $employee = Employee::find($employee_id);
        $team = $employee->team()->get(['description'])->first();
        $timeGroups = $employee->timeGroup()->get(['id','name'])->all();

        if ($employee != null && $team != null && $timeGroups != null) {
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
}

