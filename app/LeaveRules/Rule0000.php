<?php
namespace App\LeaveRules;

use App\Employee;
use Illuminate\Support\Facades\DB;
use App\Enums\LeaveAccruePeriodType;

class Rule0000 extends LeaveBaseClass implements ILeaveRules
{

    public function getEligibilityValue()
    {
        //dump($this->employeeObj);
        //dump($this->absenceTypeObj);

        // get an array of start date as start working year and enddate as end of working year base on accrue period.
        // E.g if Accrue period is 24 month and start date is 2019-01-01, will return array('start_date' => '2019-01-01', 'end_date' => '2020-12-31')
        $duration_periods = $this->getDurationUnitPeriods();

        //Check if record is present in eligibility_employee table base on employee_id, absence_type_id, >= start_date and <= end_date
        $hasAbsenseTypeForEmployee = $this->checkIfEmployeeHasAbsenceType($duration_periods["start_date"],$duration_periods["end_date"]);

        $ret = [];

        if(!$hasAbsenseTypeForEmployee){

            $ret = [
                'absence_type_id' => $this->absenceTypeObj->id,
                'start_date' => $this->getEmployeeLeaveStartDate($duration_periods["start_date"]),
                'end_date' => $duration_periods["end_date"],
                'total' => $this->absenceTypeObj->amount_earns,
                'taken' => 0,
                'employee_id' => $this->employeeObj->id,
                'is_manually_adjusted' => 0,
                'action' => "I"
            ];
        }
        return $ret;

    }

    private function getEmployeeLeaveStartDate($start_date){

        // TODO: accrue_period value to be changed to LeaveAccruePeriodType ennum
        if($this->absenceTypeObj->eligibility_begin == 0 ){
            if($this->employeeObj->date_joined >= $start_date){
                return $this->employeeObj->date_joined;
            }
            else{
                return $start_date;
            }
        }
    }



}