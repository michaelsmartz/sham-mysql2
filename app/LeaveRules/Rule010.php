<?php

namespace App\LeaveRules;

use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Rule010 extends LeaveBaseClass
{
    public $ret;
    public $retCollection;

    protected $carbonProbationEndDate;

    public function __construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd) {

        parent::__construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd);

        $this->retCollection = [];

        if (is_null($this->employeeObj->probation_end_date)) {
            $this->carbonProbationEndDate = Carbon::parse($this->employeeObj->probation_end_date);
        }
    }

    public static function applyEligibilityFilter($query, $absenceTypeId, $dateValue)
    {
        $query->where('absence_type_id', '=', $absenceTypeId)
              ->where('end_date', '>=', $dateValue);

        return $query;
    }

    public function getEligibilityValue()
    {
        $this->getEmployeeEligibilityDates();

        if(sizeof($this->employeeObj->eligibilities) == 0) {
            foreach($this->retCollection as &$item){
                $item = array_merge($item, [
                    'absence_type_id' => $this->absenceTypeObj->id,
                    'total' => $this->absenceTypeObj->amount_earns,
                    'taken' => 0,
                    'employee_id' => $this->employeeObj->id,
                    'is_manually_adjusted' => 0,
                    'action' => "I"
                ]);
            }
        }
        return $this->retCollection;
    }

    public function shouldAddNew()
    {
        $ret = true;

        if (sizeof($this->employeeObj->eligibilities) == 0) {
            $ret = true;
        } else {
            foreach($this->employeeObj->eligibilities as $eligibility) {
                if ($eligibility->pivot->end_date <= $this->workYearEnd ) {
                        $ret = true;
                        break;
                }
            }
        }

        return $ret;
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