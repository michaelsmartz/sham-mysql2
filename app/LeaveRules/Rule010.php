<?php

namespace App\LeaveRules;

use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;
use Carbon\Carbon;

class Rule010 extends LeaveBaseClass
{
    public $ret;
    public $retCollection;

    protected $carbonProbationEndDate;

    public function __construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd) {

        parent::__construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd);

    }

    public function getEligibilityValue()
    {
        $this->getEmployeeEligibilityDates();

        if(sizeof($this->employeeObj->eligibilities) == 0) {
            foreach($this->retCollection as $item){
                $item = [
                    'absence_type_id' => $this->absenceTypeObj->id,
                    'total' => $this->absenceTypeObj->amount_earns,
                    'taken' => 0,
                    'employee_id' => $this->employeeObj->id,
                    'is_manually_adjusted' => 0,
                    'action' => "I"
                ];
            }
        }
        return $this->retCollection;
    }

    private function getEmployeeEligibilityDates() {

        switch($this->absenceTypeObj->accrue_period) {
            case LeaveAccruePeriodType::months_12:
            case LeaveAccruePeriodType::months_24:
            case LeaveAccruePeriodType::months_36:
                $leaveStartDate = $this->getEmployeeLeaveStartDate($this->employeeObj->probation_end_date);
                $this->ret["start_date"] = $leaveStartDate;
                $this->ret["end_date"] = $this->workYearEnd;
                $this->retCollection[] = $this->ret;
            break;

            case LeaveAccruePeriodType::month_1:
            
                $leaveStartDate = $this->getEmployeeLeaveStartDate($this->employeeObj->probation_end_date);
                $carbonLeaveStartDate = Carbon::parse($leaveStartDate);

                $carbonP = CarbonPeriod($leaveStartDate, '1 month', $this->workYearEnd);
                foreach($carbonP as $key => $date) {
                    $carbonDStart = $date->copy()->startOfMonth();
                    $carbonDEnd = $carbonDStart->copy()->endOfMonth();
                    $this->retCollection[] = ["start_date" => $carbonDStart->toDateString(), 
                                              "end_date" => $carbonDEnd->toDateString()];
                }
            break;
        }
    }
}