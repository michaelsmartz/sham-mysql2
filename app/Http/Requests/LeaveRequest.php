<?php

namespace App\Http\Requests;

use App\Employee;
use App\EmployeeLeave;
use App\EmployeeEligibility;
use App\Http\Controllers\SSPEmployeeLeavesController;
use App\Enums\DayType;
use App\Enums\LeaveDurationUnitType;
use App\TimeGroup;
use App\Http\Requests\LeaveRequest;
use Illuminate\Support\Facades\Route;
use DateInterval;
use DateTime;
use DatePeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class LeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $remaining     = Input::get('remaining_balance');
        //$monthly_allowance    = Input::get('monthly_allowance');
        $duration_unit = Input::get('duration_unit');
        $employee      = Employee::find(Input::get('employee_id'));
        $absence_type_id    = Input::get('absence_type_id');

        $request_from = date_create(Input::get('leave_from'))->format("Y-m-d");
        $request_to   = date_create(Input::get('leave_to'))->format("Y-m-d");

        $count = 0;

        if($request_from == $request_to){
            //single day
            $date_from = strtotime(Input::get('leave_from'));
            $date_to   = strtotime(Input::get('leave_to'));
            if($duration_unit == LeaveDurationUnitType::Days){
                $date_diff = round((($date_to - $date_from) / (60 * 60 * 8)),2);
            }else{
                $date_diff = round((($date_to - $date_from) / (60 * 60)),2);
            }
            $count += $date_diff;
        }else{
            //multiple days
            $time_period = SSPEmployeeLeavesController::getTimePeriod($employee);
            $start    = (new DateTime(Input::get('leave_from')));
            $end      = (new DateTime(Input::get('leave_to')));
            $interval = DateInterval::createFromDateString('1 day');
            $period   = new DatePeriod($start,$interval, $end);

            foreach ($period as $day) {
                $curr = $day->format('l');
                // exclude non working days
                if (!isset($time_period[$curr])) {
                    continue;
                }else{
                    //first absence date
                    if($day->format("Y-m-d") == $request_from){
                        $date_from = strtotime(Input::get('leave_from'));
                        $date_to   = strtotime($day->format("Y-m-d").' '.$time_period[$curr]['end_time']);
                    //last absence date
                    }elseif($day->format("Y-m-d") == $request_to){
                        $date_from = strtotime($day->format("Y-m-d").' '.$time_period[$curr]['start_time']);
                        $date_to   = strtotime(Input::get('leave_to'));
                    //absence date(s) between
                    }else{
                        $date_from = strtotime($day->format("Y-m-d").' '.$time_period[$curr]['start_time']);
                        $date_to   = strtotime($day->format("Y-m-d").' '.$time_period[$curr]['end_time']);
                    }
                }
                if($duration_unit == LeaveDurationUnitType::Days){
                    $date_diff = round((($date_to - $date_from) / (60 * 60 * 8)),2);
                }else{
                    $date_diff = round((($date_to - $date_from) / (60 * 60)),2);
                }
                $count += $date_diff;
            }
        }

        //if apply count greater than monthly_allowance to return an error message

        return [
            'remaining_balance' => 'greater_or_equal:'.$count,
            //'monthly_allowance' => 'less_or_equal:'. $count,
            'leave_to'          => 'after:'.Input::get('leave_from')
        ];
    }

    public function messages()
    {
        return [
            'remaining_balance.greater_or_equal' => 'Amount of leave(s) requested exceeds remaining!',
            //'monthly_allowance.less_or_equal'    => 'Amount of leave(s) requested exceeds monthly allowance!',
            'leave_to.after'                     => "'Date to' must be after 'Date from'"
        ];
    }

    public function withValidator($validator) {
        if ($validator->fails() && (\Auth::user()->employee_id !== (int)Input::get('employee_id'))) {
            $errors = $validator->errors();
            $alerts = array();
            foreach ($errors->messages() as $message) {
                array_push($alerts,$message);
            }
            \Session::put('error', $alerts);
        }
    }
}
