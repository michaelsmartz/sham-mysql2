<?php
namespace App\LeaveRules;
use Illuminate\Support\Facades\DB;
use App\Enums\LeaveAccruePeriodType;
use Carbon\Carbon;

class LeaveBaseClass
{

    protected $employeeObj;
    protected $workYearStart;
    protected $workYearEnd;
    protected $absenceTypeObj;

    public function __construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd)
    {
        $this->employeeObj = $employeeObj;
        $this->workYearStart = $workYearStart;
        $this->workYearEnd = $workYearEnd;
        $this->absenceTypeObj = $absenceTypeObj;
    }

    protected function checkIfEmployeeHasAbsenceType($start_date, $end_date)
    {
        $record = DB::table('eligibility_employee')->where('employee_id','=',$this->employeeObj->id)
            ->where('absence_type_id','=',$this->absenceTypeObj->id)
            ->where('start_date','>=',$start_date)
            ->where('end_date','<=',$end_date)
            ->first();

        if (is_null($record)) {
            return false;
        }
        else {
            return true;
        }
    }

    protected function getDurationUnitPeriods()
    {
        $ret = [];

        // TODO: accrue_period value to be changed to LeaveAccruePeriodType ennum
        if($this->absenceTypeObj->accrue_period == 0 || $this->absenceTypeObj->accrue_period == 1){
            $ret["start_date"] = $this->workYearStart;
            $ret["end_date"] = $this->workYearEnd;
        }
        else if($this->absenceTypeObj->accrue_period == 2){
            $ret["start_date"] = $this->workYearStart;
            $ret["end_date"] =   Carbon::parse($this->workYearEnd)->addMonths(12) ;
            //$ret["end_date"] =   $this->workYearEnd;
        }

        else if($this->absenceTypeObj->accrue_period == 3){
            $ret["start_date"] = $this->workYearStart;
            $ret["end_date"] =   Carbon::parse($this->workYearEnd)->addMonths(36) ;
        }

        return $ret;
    }

}