<?php

namespace App\LeaveRules;

use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;
use Carbon\Carbon;

class Rule000 extends LeaveBaseClass
{
    public $ret;

    protected $carbonProbationEndDate;

    public function __construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd) {

        parent::__construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd);

    }

    private function getEmployeeEligibilityDates($start_date) {

        switch($this->absenceTypeObj->accrue_period) {
            case LeaveAccruePeriodType::months_12:
            case LeaveAccruePeriodType::months_24:
            case LeaveAccruePeriodType::months_36:
                $leaveStartDate = $this->getEmployeeLeaveStartDate($this->employeeObj->date_joined);
                $ret["start_date"] = $leaveStartDate;
                $ret["end_date"] = $this->workYearEnd; 
            break;

            case LeaveAccruePeriodType::month_1:
            
                $leaveStartDate = $this->getEmployeeLeaveStartDate($this->employeeObj->date_joined);
                $carbonLeaveStartDate = Carbon::parse($leaveStartDate);

                $carbonP = CarbonPeriod($leaveStartDate, '1 month', $this->workYearEnd);
                foreach($carbonP as $key => $date) {
                    $carbonDStart = $date->copy()->startOfMonth();
                    $carbonDEnd = $carbonDStart->copy()->endOfMonth();
                }
                
            break;

        }

    }
}