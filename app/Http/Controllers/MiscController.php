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
use App\LeaveRules\Rule000;
use App\LeaveRules\Rule001;
use App\LeaveRules\Rule010;

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
            $ret["end_date"] =   Carbon::parse($workYearEnd)->addMonths(12)->toDateString();
        }

        else if($accrue_period == 3){
            $ret["start_date"] = $workYearStart;
            $ret["end_date"] =   Carbon::parse($workYearEnd)->addMonths(24)->toDateString();
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

            $classAbsenceKey = 'App\LeaveRules\Rule'. $absenceKey;

            echo $absenceKey, ' ', $classAbsenceKey, '<br>';

            if($absenceKey == '000')
            {
                $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                    $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, $durations['start_date']);
                }])->whereNull('date_terminated')
                    ->where('employees.id','<',5)->get();
            }

            if($absenceKey == '001')
            {
                $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                    $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, 'probation_end_date');

                }])->whereNull('date_terminated')
                   ->where('probation_end_date', '>=', $durations['start_date'])
                   ->where('employees.id','<',6)->get();
            }

            if($absenceKey == '010')
            {
                $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                    $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, 'probation_end_date');

                }])->whereNull('date_terminated')
                   ->where('probation_end_date', '>=', $durations['start_date'])
                   ->where('employees.id','<',6)->get();
            }

            $insertarray = [];
            //dump($employees);
            foreach($employees as $employee){
                $leaverule = new $classAbsenceKey($employee,$absenceType,$durations['start_date'], $durations['end_date']);
                $fAddNew = $leaverule->shouldAddNew();
                //echo $employee->id, ' ', (bool) $fAddNew, '<br>';

                if ($fAddNew) {

                    $retvals = $leaverule->getEligibilityValue();

                    if(!empty($retvals)) {

                        foreach ($retvals as $item)
                        {
                            if(isset($item['action']) && $item['action'] == 'I') {
                                unset($item['action']);
                                $insertarray[] = $item;
                            }
                        }
                    }
                }
            }

            //dd($insertarray);
            DB::table('eligibility_employee')->insert($insertarray);
            echo("Completed...<br>");
        }

    }
}