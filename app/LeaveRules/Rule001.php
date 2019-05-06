<?php

namespace App\LeaveRules;

use App\Employee;
use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;
use Carbon\Carbon;

class Rule001 extends LeaveBaseClass
{
    public $ret;
    public $retCollection;

    protected $carbonProbationEndDate;

    public function __construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd)
    {

        parent::__construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd);

        $this->retCollection = [];
        
        if (!is_null($this->employeeObj) && optional($this->employeeObj->probation_end_date)) {
            $this->carbonProbationEndDate = Carbon::parse($this->employeeObj->probation_end_date);
        }
    }

    public function shouldAddNew()
    {
        $ret = true;

        if (sizeof($this->employeeObj->eligibilities) == 0 && 
            $this->employeeObj->probation_end_date >= $this->workYearStart) {
            $ret = true;
        } else {
            foreach($this->employeeObj->eligibilities as $eligibility) {
                if ($this->workYearStart >= $eligibility->pivot->start_date &&
                    $this->workYearStart <= $eligibility->pivot->end_date ) {
                        $ret = false;
                        break;
                }
            }
        }

        return $ret;
    }

    public function getEligibilityValue()
    {
        $this->getEmployeeEligibilityDates();

        if (sizeof($this->employeeObj->eligibilities) == 0) {
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

    public function employeesQuery($durations, $classAbsenceKey)
    {
        $ret =  Employee::employeesLite()->with(['eligibilities' => function ($query) use ($durations) {
            $query = $this->applyEligibilityFilter($query, 'probation_end_date');
        }])->whereNull('date_terminated')
           ->where('probation_end_date', '>=', Carbon::now()->toDateString())
           ->where('date_joined', '<=', Carbon::now()->toDateString());

        return $ret;
    }

    private function getEmployeeEligibilityDates()
    {
        // we are in the rule "when probation ends", accrue period is irrelevant
        $leaveStartDate = $this->getEmployeeLeaveStartDate($this->employeeObj->date_joined);
        $this->ret["start_date"] = $leaveStartDate;
        $this->ret["end_date"] = $this->employeeObj->probation_end_date;
        $this->retCollection[] = $this->ret;
    }

    private function applyEligibilityFilter($query, $dateValue)
    {
        $query->where('absence_type_id', '=', $this->absenceTypeObj->id);

        return $query;
    }

}