<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AbsenceType;
use App\Employee;
use App\SysConfigValue;
use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;
use Illuminate\Support\Facades\DB;

use App\LeaveRules\Rule0000;

class MiscController extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    public function test(){
        return view('test');
    }
    public function elearningHelper(){
        return view('elearning-helper');
    }
    public function vueTest(){
        return view('vue-test');
    }

    public function testleave(){

        $workYearStartVal = "";
        $workYearEndVal = "";

        $workYearStart = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $workYearEnd = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
        $absenceTypes = AbsenceType::with('jobTitles')->get();
        $employees = Employee::employeesLite()->whereNull('date_terminated')->get();


        if ( !is_null($workYearStart) ) {
            $workYearStartVal = $workYearStart->value;
        }
        if ( !is_null($workYearEnd) ) {
            $workYearEndVal = $workYearEnd->value;
        }

        $retval = [];
        foreach($employees as $employee){
            $retval = [];
            if (!is_null($absenceTypes)){
                foreach($absenceTypes as $absenceType) {

                    $absenceKey =  $absenceType->duration_unit.$absenceType->eligibility_begins.$absenceType->eligibility_ends.$absenceType->accrue_period;

                    if($absenceKey == '0000' || $absenceKey == '0002' || $absenceKey == '0003')
                    {
                        $leaverule = new Rule0000($employee,$absenceType,$workYearStartVal,$workYearEndVal);
                        $retval = $leaverule->getEligibilityValue();
                    }

                    if(!empty($retval)){
                        if($retval['action'] == 'I'){
                            unset($retval['action']);
                            DB::table('eligibility_employee')->insert($retval);
                        }
                    }
                    //die;
                }
            }
        }
    }

}
