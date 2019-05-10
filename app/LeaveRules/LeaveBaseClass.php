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
    protected $carbonWorkYearStart;
    protected $carbonWorkYearEnd;
    protected $carbonWorkYearStartBeginOfMonth; // not necessarily defined as 1st January
    protected $carbonFirstDayCurrentMonth;
    protected $carbonLastDayCurrentMonth;

    public function __construct($employeeObj, $absenceTypeObj, $workYearStart, $workYearEnd)
    {
        $this->employeeObj = $employeeObj;
        $this->workYearStart = $workYearStart;
        $this->workYearEnd = $workYearEnd;
        $this->absenceTypeObj = $absenceTypeObj;

        $this->carbonWorkYearStart = Carbon::parse($this->workYearStart);
        $this->carbonWorkYearEnd = Carbon::parse($this->workYearEnd);
        $this->carbonFirstDayCurrentMonth = Carbon::today()->startOfMonth();
        $this->carbonLastDayCurrentMonth = $this->carbonFirstDayCurrentMonth->copy()->endOfMonth();

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

    protected function getEmployeeLeaveStartDate($startDate){

        if( $this->workYearStart >= $startDate){
            return $this->workYearStart;
        }
        else{
            return $startDate;
        }

    }


}