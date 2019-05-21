<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeLeave;
use App\Enums\DayType;
use App\Enums\LeaveStatusType;
use App\TimeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use DateInterval;
use DateTime;
use DatePeriod;

class SSPEmployeeLeavesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new EmployeeLeave();
        $this->baseViewPath = 'selfservice-portal.leaves';
        $this->baseRoute = "leaves";
        $this->baseFlash = "Employee's leave(s) ";
    }
    /**
     * Display a listing of the employee's leaves.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        $employee_id     = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $employees       = EmployeesController::getManagerEmployees($employee_id);
        $leaves          = $this->getEmployeeLeavesHistory($employee_id);
        $eligibility     = $this->getEmployeeLeavesStatus($employee_id);
        
        if(count($employees) > 0){
            $pending_request = $this->getPendingRequests($employee_id);
        }else{
            $pending_request = null;
        }

        $selected = array(
            'employee_id' => $employee_id
        );
        
        return view($this->baseViewPath .'.index', compact('leaves','eligibility','employees', 'selected', 'pending_request'));
    }

    /**
     * Display a listing of the employee's leaves within date range.
     *
     * @return Illuminate\View\View
     */
    public function filterLeave(Request $request)
    {
        //Filter by employee
        if(!empty($request->input('employee_id')) && $request->input('employee_id') != 0){
            //employee's leave viewed from manager
            $employee_id = $request->input('employee_id');
            $employees   = EmployeesController::getManagerEmployees(\Auth::user()->employee_id);
        }elseif ($request->input('employee_id') == 0){
            //manager's leave
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            $employees   = EmployeesController::getManagerEmployees(\Auth::user()->employee_id);
        }else{
            //employee's leave
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            $employees   = null;
        }

        //Filter by leave type
        if(!empty($request->input('absence_type')) && $request->input('absence_type') != 0){
            $absence_type = $request->input('absence_type');
        }else{
            $absence_type = null;
        }

        if(count($employees) > 0){
            $pending_request = $this->getPendingRequests(\Auth::user()->employee_id);
        }else{
            $pending_request = null;
        }

        $leaves      = $this->getEmployeeLeavesHistory($employee_id,$request->input('from'),$request->input('to'),$absence_type);
        $eligibility = $this->getEmployeeLeavesStatus($employee_id);

        $selected = array(
            'employee_id' => $employee_id,
            'absence_id'  => $absence_type
        );

        return view($this->baseViewPath .'.index', compact('leaves','eligibility','employees','pending_request','selected'));
    }


    /**
     * Show the form for creating a new employee leave request.
     *
     * @param $leave_id
     * @param $employee_id
     * @param $leave_description
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $leave_id = Route::current()->parameter('leave_id');
        $employee_id = Route::current()->parameter('employee_id');
        $leave_description = Route::current()->parameter('leave_desc');

        if($employee_id)
            $employee =  Employee::find($employee_id);
        else
            $employee = null;

        $leave_type = $this->getEligibleAbsencesTypes($employee_id);

        $time_period = $this->getTimePeriod($employee);
        //dd($time_period['Monday']['start_time']);
        //dd($time_period);

        $view = view($this->baseViewPath .'.create',compact('leave_type', 'leave_id','leave_description', 'employee_id', 'time_period'))->renderSections();
        return response()->json([
            'title' => $view['modalTitle'],
            'content' => $view['modalContent'],
            'footer' => $view['modalFooter'],
            'url' => $view['postModalUrl']
        ]);

    }


    /**
     * Store a new employee leave request in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

            $start    = (new DateTime($request->input('leave_from')));
            $end      = (new DateTime($request->input('leave_to')))->modify('next day');
            $interval = DateInterval::createFromDateString('1 day');
            $period   = new DatePeriod($start,$interval, $end);

            foreach ($period as $day) {
                $curr = $day->format('D');

                // exclude if Saturday or Sunday
                if ($curr == 'Sat' || $curr == 'Sun') {
                    continue;
                }else{
                    $leave_request = new EmployeeLeave();
                    $leave_request->absence_type_id = $request->input('absence_type_id');
                    $leave_request->employee_id = $employee_id;
                    $leave_request->status = 0;
                    $leave_request->starts_at = $day->format("Y-m-d h:i");
                    $leave_request->ends_at = $day->format("Y-m-d h:i");
                    $leave_request->save();
                }

            }
            \Session::put('success', $this->baseFlash . 'updated!!');
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseRoute .'.index');
    }


    /**
     * Show the form for creating a new employee leave request.
     *
     * @return Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $id = Route::current()->parameter('leaf');
        $leave = $this->getPendingRequest($id);

        if($request->ajax()) {
            $view = view($this->baseViewPath .'.edit',compact('leave','id'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter']
            ]);
        }

        return view($this->baseViewPath .'.edit',compact('leave','id'));
    }

    public function show(){
        return redirect()->route($this->baseRoute .'.index');
    }

    public static function getEmployeeLeavesHistory($employee_id,$date_from = null,$date_to = null,$absence_type = null){
        $sql_request = "SELECT abe.id,abs.description as absence_description,abe.employee_id,ele.total,ele.taken,(ele.total - ele.taken) as remaining,abe.starts_at,abe.ends_at,abe.status,CONCAT(emp.first_name,\" \",emp.surname) as validator
            FROM absence_type_employee abe
            LEFT JOIN absence_types abs ON abs.id = abe.absence_type_id
            LEFT JOIN eligibility_employee ele ON ele.absence_type_id =abs.id
            LEFT JOIN employees emp ON abe.approved_by_employee_id = emp.id";

        if(empty($date_from) && empty($date_to)){
            $sql_request .= " WHERE abe.employee_id = $employee_id AND ele.employee_id = $employee_id";
        }else{
            $sql_request .= " WHERE abe.employee_id = $employee_id AND ele.employee_id = $employee_id AND abe.starts_at BETWEEN '$date_from' AND '$date_to'";;
        }

        if(!empty($absence_type)){
            $sql_request .= " AND abs.id = $absence_type";
        }

        $sql_request .= " ORDER BY abe.starts_at DESC;";
        $employee_leave= DB::select($sql_request);

        return $employee_leave;


    }


    public static function getEmployeeLeavesStatus($employee_id){

        $employee_leave= DB::select(
            "SELECT abs.id,abs.description as absence_description,(SELECT COUNT(id) FROM absence_type_employee ate WHERE ate.employee_id = 2126 AND abs.id = ate.absence_type_id) as pending,ele.taken,ele.total,(ele.total - ele.taken) as remaining,ele.start_date
            FROM eligibility_employee ele
            LEFT JOIN absence_types abs ON abs.id = ele.absence_type_id
            WHERE ele.start_date <= NOW() AND ele.employee_id = $employee_id ;"
        );

        return $employee_leave;


    }


    public static function getEligibleAbsencesTypes($employee_id){
        $eligible_leave= DB::select(
            "SELECT abt.id,abt.description,(ele.total - ele.taken) as remaining 
            FROM eligibility_employee ele
            LEFT JOIN absence_types abt ON abt.id = ele.absence_type_id
            WHERE ele.start_date <= NOW() AND ele.employee_id = $employee_id;"
        );

        return $eligible_leave;
    }

    function changeStatus($leave_id,$status){
        try {
            $leave_request = EmployeeLeave::findOrFail($leave_id);
            $leave_request->status = $status;
            $leave_request->save();

            \Session::put('success', $this->baseFlash . 'updated!!');
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseRoute .'.index');
    }

    function batchChangeStatus($leave_ids,$status){
        try {
            $ids = explode(',',$leave_ids);
            $leave_request = EmployeeLeave::whereIn('id',$ids)->update(['status' => $status]);

            \Session::put('success', $this->baseFlash . 'updated!!');
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseRoute .'.index');
    }


    private function getPendingRequests($manager_id){
        $employee_ids = EmployeesController::getManagerEmployeeIds($manager_id);

        $sql_request = "SELECT abe.id,abs.description as absence_description,abe.employee_id,CONCAT(emp.first_name,\" \",emp.surname) as employee,ele.total,ele.taken,(ele.total - ele.taken) as remaining,abe.starts_at,abe.ends_at,abe.status
            FROM absence_type_employee abe
            LEFT JOIN absence_types abs ON abs.id = abe.absence_type_id
            LEFT JOIN eligibility_employee ele ON (ele.absence_type_id =abs.id AND ele.employee_id =abe.employee_id)
            LEFT JOIN employees emp ON abe.employee_id = emp.id
            WHERE abe.employee_id IN (".implode(',',$employee_ids).") AND abe.status =".LeaveStatusType::status_pending."
            ORDER BY abe.starts_at DESC;";

        $pending_requests = DB::select($sql_request);

        return $pending_requests;
    }

    private function getPendingRequest($id){
        $sql_request = "SELECT abe.id,abs.description as absence_description,abe.employee_id,CONCAT(emp.first_name,\" \",emp.surname) as employee,ele.total,ele.taken,(ele.total - ele.taken) as remaining,abe.starts_at,abe.ends_at,abe.status
            FROM absence_type_employee abe
            LEFT JOIN absence_types abs ON abs.id = abe.absence_type_id
            LEFT JOIN eligibility_employee ele ON (ele.absence_type_id =abs.id AND ele.employee_id =abe.employee_id)
            LEFT JOIN employees emp ON abe.employee_id = emp.id
            WHERE abe.id = $id;";

        $pending_request = DB::select($sql_request);

        return $pending_request[0];
    }

    private function getTimePeriod($employee){
        $time_period = [];
        $tg= [];

        if (empty($employee)) {
            return $time_period;
        }

        if ($employee != null && $employee->team() != null && $employee->timeGroup() != null) {
            $team = $employee->team()->get(['description','time_group_id'])->first();
            $tg = TimeGroup::find($team['time_group_id']);
        }

        if(sizeof($tg) > 0) {
            $tgTimePeriods = $tg->timePeriods()->get(['description', 'start_time', 'end_time', 'time_period_type'])->all();

            if ($tgTimePeriods != null) {
                $counter_days = 0;
                foreach ($tgTimePeriods as $tgTimePeriod) {
                    $day = DayType::getDescription($tgTimePeriods[$counter_days]->pivot->day_id);
                    //if TimePeriodType 1:  is for working hours
                    if ($tgTimePeriod->time_period_type == 1) {
                        $time_period[$day]['start_time']
                            = self::getOfficeHours($tgTimePeriod)['start_time'];

                        $time_period[$day]['end_time']
                            = self::getOfficeHours($tgTimePeriod)['end_time'];
                    }
                    $counter_days++;
                }
            }
        }

        return $time_period;
    }

    private function timeIntervalReadable($value) {
        if ($value != null) {
            $interval = new DateTime($value);
            return $interval->format('G:i');
        }
        return '00:00';
    }


    private function getOfficeHours($tgTimePeriod){
        $officeTime = [];
        if (!empty($tgTimePeriod->start_time)) {
            $objStartTime = self::timeIntervalReadable($tgTimePeriod->start_time);
            $officeTime['start_time'] = $objStartTime;
        }

        if (!empty($tgTimePeriod->end_time)) {
            $objEndTime = self::timeIntervalReadable($tgTimePeriod->end_time);
            $officeTime['end_time'] = $objEndTime;
        }

        return $officeTime;
    }
}
