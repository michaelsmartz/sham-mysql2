<?php

namespace App\Jobs;

use App\AbsenceType;
use App\Employee;
use App\SysConfigValue;

use App\Enums\LeaveAccruePeriodType;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateUnclaimedMonthlyLeaves implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $summary;
    protected $employeeId;
    protected $workYearStart;
    protected $workYearEnd;
    protected $absenceTypes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employeeId = null)
    {
        $this->employeeId = $employeeId;
        $workYearStart = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $workYearEnd = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
        $this->absenceTypes = AbsenceType::where('accrue_period','=',LeaveAccruePeriodType::month_1)->get();

        if ( !is_null($workYearStart) ) {
            $this->workYearStart = $workYearStart->value;
        }
        if ( !is_null($workYearEnd) ) {
            $this->workYearEnd = $workYearEnd->value;
        }
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

                $processedIds = [];
                foreach($this->absenceTypes as $absenceType) {
                    $employees = $this->employeesQuery($absenceType)->where('employees.id', '=',4)->get();
                    if(! is_null($employees)){
                        foreach($employees as $employee){
                            if($this->updateEligibilities($employee)) {
                                $processedIds[] = $employee->id;
                            }
                        }
                    }

                    $this->summary = [
                        'skipped' => 'no', 
                        'inserted' => implode($processedIds, ', ') 
                    ];

                    $this->logToDb($absenceType->id, get_class($absenceType));
                }
            }

        } catch(Exception $e) {

        }
    }

    public function displayName()
    {
        return 'App\\Jobs\\UpdateUnclaimedMonthlyLeaves';
    }

    private function employeesQuery($absenceType)
    {
      $ret =  Employee::employeesLite()->with(['eligibilities' => function ($query) use ( $absenceType) {
                $query = $query->where('absence_type_id', '=', $absenceType->id)
                               ->where('start_date', '>=', $this->workYearStart)
                               ->where('end_date', '<=', Carbon::now()->endOfMonth()->toDateString())
                                ->where('is_processed',0)
                               ->orderBy('start_date');
              }])->whereNull('date_terminated');

      return $ret;
    }

    private function updateEligibilities($employee)
    {
        $unclaimedTotal = 0;
        $ret = false;

        if (sizeof($employee->eligibilities) > 1) {
            $ret = true;

            // all items before last
            $workCol = $employee->eligibilities->slice(0, -1);
            // last item
            $lastColItem = $employee->eligibilities->last();

            foreach($workCol as $eligibility) {
                //echo $eligibility->start_date, ' - ', $eligibility->end_date,' ',($eligibility->pivot->total - $eligibility->pivot->taken), '<br>';
                $unclaimedTotal += ($eligibility->pivot->total - $eligibility->pivot->taken);
                $eligibility->pivot->is_processed = 1;
                $eligibility->pivot->save();
            }

            echo $unclaimedTotal, ' ',$lastColItem->pivot->total,'<br>';

            if(!is_null($lastColItem)) {
                $lastColItem->pivot->total += $unclaimedTotal;
                dump($lastColItem);
                $lastColItem->pivot->save();
            }
        }

        return $ret;
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
