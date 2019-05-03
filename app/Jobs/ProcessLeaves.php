<?php

namespace App\Jobs;

use App\AbsenceType;
use App\Employee;
use App\SysConfigValue;
use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class ProcessLeaves implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeId;
    protected $workYearStart;
    protected $workYearEnd;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employeeId = null)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $workYearStart = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $workYearEnd = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
        $absenceTypes = AbsenceType::with('jobTitles')->get();
        $employees = Employee::employeesLite()->whereNull('date_terminated')->get();

        if ( !is_null($workYearStart) ) {
            $this->workYearStart = $workYearStart->value;
        }
        if ( !is_null($workYearEnd) ) {
            $this->workYearEnd = $workYearEnd->value;
        }

        echo $this->employeeId, ' ', $this->workYearStart, ' ', $this->workYearEnd;

        if ( !is_null($absenceTypes) ){
            // looping each AbsenceType
            foreach($absenceTypes as $absenceType) {

                $ret = $this->getEligibilityValues($absenceType);
                // for 1 employee only
                if(!is_null($this->employeeId)) {
                    $employee = Employee::find($this->employeeId);
                    $this->insertEmployee($employee);
                } else {
                    // for all employees
                    foreach($employees as $employee) {
                        $this->insertEmployee($employee);
                    }
                }

            }
        }

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
}
