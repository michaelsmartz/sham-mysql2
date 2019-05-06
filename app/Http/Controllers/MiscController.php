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
use Carbon\Carbon;

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

    protected function getDurationUnitPeriods($accrue_period, $workYearStart, $workYearEnd)
    {
        $ret = [];

        // TODO: accrue_period value to be changed to LeaveAccruePeriodType ennum
        if($accrue_period == 0 || $accrue_period == 1){
            $ret["start_date"] = $workYearStart;
            $ret["end_date"] = $workYearEnd;
        }
        else if($accrue_period == 2){
            $ret["start_date"] = $workYearStart;
            $ret["end_date"] =   Carbon::parse($workYearEnd)->addMonths(12) ;
            //$ret["end_date"] =   $workYearEnd;
        }

        else if($accrue_period == 3){
            $ret["start_date"] = $workYearStart;
            $ret["end_date"] =   Carbon::parse($workYearEnd)->addMonths(36) ;
        }

        return $ret;
    }

    public function testleave(){
        ini_set('max_execution_time', 180);
        $workYearStartVal = "";
        $workYearEndVal = "";

        $workYearStart = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $workYearEnd = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
        $absenceTypes = AbsenceType::with('jobTitles')->get();

        if ( !is_null($workYearStart) ) {
            $workYearStartVal = $workYearStart->value;
        }
        if ( !is_null($workYearEnd) ) {
            $workYearEndVal = $workYearEnd->value;
        }



        foreach($absenceTypes as $absenceType) {
            $durations = $this->getDurationUnitPeriods($absenceType->accrue_period, $workYearStartVal, $workYearEndVal);

            $absenceKey =  $absenceType->duration_unit . $absenceType->eligibility_begins . 
                           $absenceType->eligibility_ends /*.$absenceType->accrue_period*/;

            if($absenceKey == '000' /*|| $absenceKey == '0002' || $absenceKey == '0003'*/)
            {
                //$employees = Employee::employeesEligibility($durations['start_date'], $durations['end_date'])->get();

                $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations) {
                    $query->where('absence_type_id', '=', $absenceType->id)
                        ->where('end_date', '<', $durations['start_date']);
                }])->get();

                $insertarray = [];
                foreach($employees as $employee){
                    $leaverule = new Rule000($employee,$absenceType,$durations['start_date'], $durations['end_date']);
                    $retval = $leaverule->getEligibilityValue();

                    if(!empty($retval)){
                        if($retval['action'] == 'I'){
                            unset($retval['action']);
                            //DB::table('eligibility_employee')->insert($retval);
                            $insertarray[] = $retval;
                        }
                    }
                }

                DB::table('eligibility_employee')->insert($insertarray);

                echo("Completed...");
            }
        }
    }
}