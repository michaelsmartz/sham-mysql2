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

        $ret = [];

        if(sizeof($this->employeeObj->eligibilities) == 0){
            $ret = [
                'absence_type_id' => $this->absenceTypeObj->id,
                'start_date' => $this->getEmployeeLeaveStartDate($this->workYearStart),
                'end_date' => $this->workYearEnd,
                'total' => $this->absenceTypeObj->amount_earns,
                'taken' => 0,
                'employee_id' => $this->employeeObj->id,
                'is_manually_adjusted' => 0,
                'action' => "I"
            ];
        }
        //dd($ret);
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