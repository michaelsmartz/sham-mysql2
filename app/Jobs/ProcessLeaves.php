<?php

namespace App\Jobs;

use App\AbsenceType;
use App\Employee;
use App\SysConfigValue;

use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;

use App\LeaveRules\Rule000;
use App\LeaveRules\Rule001;
use App\LeaveRules\Rule010;
use App\LeaveRules\Rule100;
use App\LeaveRules\Rule101;
use App\LeaveRules\Rule110;

use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessLeaves implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $summary;

    protected $employeeId;
    protected $workYearStart;
    protected $workYearEnd;
    protected $absenceTypes;

    /**
     * Create a new job instance.
     * Employee Id is optional. If supplied, job will run for that employee
     *
     * @return void
     */
    public function __construct($employeeId = null)
    {
        $this->employeeId = $employeeId;
        $workYearStart = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $workYearEnd = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
        $this->absenceTypes = AbsenceType::with('jobTitles')->get();

        if ( !is_null($workYearStart) ) {
            $this->workYearStart = $workYearStart->value;
        }
        if ( !is_null($workYearEnd) ) {
            $this->workYearEnd = $workYearEnd->value;
        }

        $this->summary = [];

        //echo $this->employeeId, ' ', $this->workYearStart, ' ', $this->workYearEnd;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        try {

            $employees = [];

            if ( !is_null($this->absenceTypes) ){
                // looping each AbsenceType
    
                foreach($this->absenceTypes as $absenceType) {

                    if(is_null($absenceType->amount_earns)){

                        \DB::table('job_logs')->insert([
                            'loggable_id' => $absenceType->id,
                            'loggable_type' => get_class($absenceType),
                            'message' => 'Missing amount_earns value',
                            'level' => 1000,
                            'context' => $this->displayName(),
                            'extra' => '',
                            'created_at' => date('Y-m-d H:i:s'),
                        ]);
                        
                        $this->summary['absenceType'][$absenceType->id] = [
                            'skipped' => 'yes', 
                            'inserted' => 'no' 
                        ];
                        continue;
                    }
                    // empty at start of each iteration
                    $insertArray = [];

                    $durations = $this->getDurationUnitPeriods($absenceType->accrue_period, $this->workYearStart, $this->workYearEnd);
    
                    $absenceKey =  $absenceType->duration_unit . $absenceType->eligibility_begins . 
                                   $absenceType->eligibility_ends;
    
                    //prepare for dynamic instantiation of the class rule name
                    $classAbsenceKey = 'App\LeaveRules\Rule'. $absenceKey;
    
                    //echo ' ', $absenceKey, ' ', $classAbsenceKey, '<br>';

                    $insertArray = [];

                    // for 1 employee only
                    if(!is_null($this->employeeId)) {
                        $employee = Employee::find($this->employeeId);
                        $employees[] = $employee;
                    } else {

                        // for all employees
                        $leaveRule = new $classAbsenceKey(null,$absenceType,$durations['start_date'], $durations['end_date']);
                        $employees = $leaveRule->employeesQuery($durations, $classAbsenceKey)->get();
                        //dump($leaveRule);
                    }

                    //dump(sizeof($employees));
                    //filter job title
                    if(sizeof($absenceType->jobTitles) > 0) {
                        $jobIds = $absenceType->jobTitles->flatten()->pluck('id');
                        $employees = $employees->whereIn('job_title_id', $jobIds)->all();
                    }
                    //dump(sizeof($employees));

                    // from here, process 1 or all employees
                    foreach($employees as $employee) {
                        $leaverule = new $classAbsenceKey($employee,$absenceType,$durations['start_date'], $durations['end_date']);
                        $fAddNew = $leaverule->shouldAddNew();

                        if ($fAddNew) {
    
                            $retvals = $leaverule->getEligibilityValue();
        
                            if(!empty($retvals)) {
        
                                foreach ($retvals as $item) {
                                    if(isset($item['action']) && $item['action'] == 'I') {
                                        unset($item['action']);
                                        $insertArray[] = $item;
                                    }
                                }
                            }
                        }
                    }

                    //dump($insertArray);
                    try {
                        \DB::table('eligibility_employee')->insert($insertArray);
                        $colInsert = collect($insertArray);

                        $this->summary = [
                            'skipped' => 'no', 
                            'inserted' => $colInsert->implode('employee_id', ', ') 
                        ];

                        $this->logToDb($absenceType->id, get_class($absenceType));

                    } catch(Exception $e) {
                        //var_dump($e);
                    }
                    
                    //echo "Completed...", $absenceType->description, "<br>";
                    var_dump($this->summary);

                    continue;

                    if($absenceKey == '000')
                    {
                        $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                            $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, $durations['start_date']);
                        }])->whereNull('date_terminated')
                           ->get();
                    }
    
                    if($absenceKey == '001')
                    {
                        $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                            $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, 'probation_end_date');
                        }])->whereNull('date_terminated')
                           ->where('probation_end_date', '>=', $durations['start_date'])
                           ->get();
                    }
    
                    if($absenceKey == '010')
                    {
                        $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                            $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, 'probation_end_date');
                        }])->whereNull('date_terminated')
                           ->where('probation_end_date', '>=', $durations['start_date'])
                           ->get();
                    }
        
                    if($absenceKey == '100')
                    {
                        $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                            $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, $durations['start_date']);
                        }])->whereNull('date_terminated')
                           ->get();
                    }
        
                    if($absenceKey == '101')
                    {
                        $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                            $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, 'probation_end_date');
                        }])->whereNull('date_terminated')
                           ->where('probation_end_date', '>=', $durations['start_date'])
                           ->get();
                    }
        
                    if($absenceKey == '110')
                    {
                        $employees = Employee::employeesLite()->with(['eligibilities' => function ($query) use ($absenceType, $durations, $classAbsenceKey) {
                            $query = $classAbsenceKey::applyEligibilityFilter($query, $absenceType->id, 'probation_end_date');
                        }])->whereNull('date_terminated')
                           ->where('probation_end_date', '>=', $durations['start_date'])
                           ->get();
                    }

                    $ret = $this->getEligibilityValues($absenceType);
                    // for 1 employee only
                    if(!is_null($this->employeeId)) {
    
                        $employee = Employee::find($this->employeeId);
                        $leaverule = new $classAbsenceKey($employee,$absenceType,$durations['start_date'], $durations['end_date']);
                        $fAddNew = $leaverule->shouldAddNew();
    
                        if ($fAddNew) {
    
                            $retvals = $leaverule->getEligibilityValue();
        
                            if(!empty($retvals)) {
        
                                foreach ($retvals as $item)
                                {
                                    if(isset($item['action']) && $item['action'] == 'I') {
                                        unset($item['action']);
                                        $insertArray[] = $item;
                                    }
                                }
                            }
                        }
    
                    } else {
                        // for all employees
                        foreach($employees as $employee) {
                            $this->insertEmployee($employee);
                        }
                    }
    
                }
            }

        } catch (Exception $exception) {

        }

    }

    public function displayName()
    {
        return 'App\\Jobs\\ProcessLeaves';
    }

    public function getSummary() 
    {
        return $this->summary;
    }

    private function getDurationUnitPeriods($accrue_period, $workYearStart, $workYearEnd)
    {
        $ret = [];

        // TODO: accrue_period value to be changed to LeaveAccruePeriodType ennum
        if($accrue_period == 0 || $accrue_period == 1 || $accrue_period == -1){
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

    private function getEligibilityValues($absenceType) {

        $ret = [
            'absence_type_id' => $absenceType->id,
            'start_date' => null,
            'end_date' => null,
            'total' => 0,
            'is_manually_adjusted' => 0,
        ];

        switch ($absenceType->accrue_period) {
            case LeaveAccruePeriodType::months_12:
                // handle 12 months
                // in Days
                if($absenceType->duration_unit == LeaveDurationUnitType::Days) {
                    // eligibility begins = first day at work
                    // eligibility ends = last day at work
                    if($absenceType->eligibility_begins == LeaveEmployeeGainEligibilityType::first_working_day && 
                       $absenceType->eligibility_ends == LeaveEmployeeLossEligibilityType::last_working_day) {
                        $ret['start_date'] = $this->workYearStart;
                        $ret['end_date'] = $this->workYearEnd;
                    }

                    $ret['total'] = $absenceType->amount_earns;

                } else {
                    // in Hours
                }
                break;

            case LeaveAccruePeriodType::month_1:
                // handle 1 month
                break;

            case LeaveAccruePeriodType::months_24:
                // handle 24 months
                break;

            default:
                // handle 36 months
                break;
        }

        return $ret;

    }

    private function insertEmployee($employee){
        $toInsert = array_merge($ret, ['employee_id' => $employee->id]);
        DB::table('eligibility_employee')->insert($toInsert);
    }

    private function logToDb($id, $type, $level = 900)
    {
        \DB::table('job_logs')->insert([
            'loggable_id' => $id,
            'loggable_type' => $type,
            'message' => json_encode($this->summary),
            'level' => $level,
            'context' => $this->displayName(),
            'extra' => '',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

}
