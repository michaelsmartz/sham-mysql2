<?php

namespace App\Http\Controllers;

use App\CalendarEvent;
use App\Employee;
use App\EmployeeLeave;
use App\EmployeeEligibility;
use App\SysConfigValue;
use App\Enums\DayType;
use App\Enums\LeaveStatusType;
use App\Enums\LeaveDurationUnitType;
use App\TimeGroup;
use Illuminate\Http\Request;
use App\Http\Requests\LeaveRequest;
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
        $manager         = array(
            'id'       => $employee_id,
            'fullname' => EmployeesController::getEmployeeFullName($employee_id)
        );
        $employees       = EmployeesController::getManagerEmployees($employee_id);
        $eligibility     = $this->getEmployeeLeavesStatus($employee_id);
        $calendar        = app('CalendarEventService',[
                                'type'=> EmployeeLeave::class,
                                'view'=> 'data'
                            ]);
        
        if(count($employees) > 0){
            $pending_request = $this->getPendingRequests($employee_id);
        }else{
            $pending_request = null;
        }

        $selected = array(
            'employee' => Employee::find($employee_id)
        );
        
        return view($this->baseViewPath .'.index', compact('calendar','eligibility','employees','manager', 'selected', 'pending_request'));
    }

    /**
     * Display a listing of the employee's leaves within date range.
     *
     * @return Illuminate\View\View
     */
    public function historyLeave()
    {
        $employee_id     = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $manager         = array(
            'id'       => $employee_id,
            'fullname' => EmployeesController::getEmployeeFullName($employee_id)
        );
        $employees       = EmployeesController::getManagerEmployees($employee_id);
        $leaves          = $this->getEmployeeLeavesHistory($employee_id);
        $eligibility     = $this->getEmployeeLeavesStatus($employee_id);

        if(count($employees) > 0){
            $pending_request = $this->getPendingRequests($employee_id);
        }else{
            $pending_request = null;
        }

        $selected = array(
            'employee' => Employee::find($employee_id)
        );

        return view($this->baseViewPath .'.index', compact('leaves','eligibility','employees','manager', 'selected', 'pending_request'));

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
            $manager         = array(
                'id'       => \Auth::user()->employee_id,
                'fullname' => EmployeesController::getEmployeeFullName(\Auth::user()->employee_id)
            );
            $selected    = $employee_id;
        }elseif ($request->input('employee_id') == 0){
            //manager's leave
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            $employees   = EmployeesController::getManagerEmployees(\Auth::user()->employee_id);
            $manager         = array(
                'id'       => $employee_id,
                'fullname' => EmployeesController::getEmployeeFullName($employee_id)
            );
            $selected    = null;
        }else{
            //employee's leave
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            $employees   = null;
            $selected    = null;
            $manager     = null;
        }

        //Filter by leave type
        if(!empty($request->input('absence_type')) && $request->input('absence_type') != 0){
            $absence_type = $request->input('absence_type');
        }else{
            $absence_type = null;
        }

        if(count($employees) > 0){
            $pending_request = $this->getPendingRequests(\Auth::user()->employee_id,$selected);
        }else{
            $pending_request = null;
        }

        $leaves      = $this->getEmployeeLeavesHistory($employee_id,$request->input('from'),$request->input('to'),$absence_type);
        $eligibility = $this->getEmployeeLeavesStatus($employee_id);

        $selected = array(
            'employee'    => Employee::find($employee_id),
            'absence_id'  => $absence_type
        );

        return view($this->baseViewPath .'.index', compact('manager','leaves','eligibility','employees','pending_request','selected'));
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

        $employee           = Employee::find($employee_id);
        $leave_type         = $this->getEligibleAbsencesTypes($employee_id,$leave_id);
        $remaining          = $leave_type[0]->remaining;
        $duration_unit      = $leave_type[0]->duration_unit;
        $non_working        = $leave_type[0]->non_working_days;
        $time_period        = self::getTimePeriod($employee);
        $working_year_start = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $working_year_end   = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
        
        

        //Note if non_working_days flag set to 1 remove non working days from flatpickr
        //non_working_days flag is send in $leave_type array
        $leave_type = $this->getEligibleAbsencesTypes($employee_id);

        $time_period = $this->getTimePeriod($employee);
        //dd($time_period['Monday']['start_time']);
        //dd($time_period);

        $view = view($this->baseViewPath .'.create',compact('remaining', 'non_working','working_year_start','working_year_end', 'duration_unit','leave_id','leave_description', 'employee_id', 'time_period'))->renderSections();
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
    public function store(LeaveRequest $request)
    {
        try {
            //filtered by employee 
            if(!empty($request->input('employee_id'))){
                $employee_id = (int)$request->input('employee_id');
            }else{
                $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            }
           
            $employee    =  Employee::find($employee_id);
            $time_period =  self::getTimePeriod($employee);

            $request_from = date_create($request->input('leave_from'))->format("Y-m-d");
            $request_to   = date_create($request->input('leave_to'))->format("Y-m-d");
            
            if($request_from == $request_to){
                //single day
                $leave_request = new EmployeeLeave();
                $leave_request->absence_type_id = $request->input('absence_type_id');
                $leave_request->employee_id = $employee_id;
                $leave_request->status = LeaveStatusType::status_pending; 
                $leave_request->starts_at = $request->input('leave_from');
                $leave_request->ends_at   = $request->input('leave_to');
                $leave_request->save();
            }else{
                //multiple days
                $start      = new DateTime($request->input('leave_from'));
                $end        = (new DateTime($request->input('leave_to')))->modify('next day');
                $end->setTime(0,0,1);  
             
                
                $interval   = DateInterval::createFromDateString('1 day');
                $period     = new DatePeriod($start,$interval, $end);
                $non_woking = $request->input('non_working');

                foreach ($period as $day) {
                    $curr = $day->format('l');
                    // exclude non working days
                    if ((!isset($time_period[$curr])) && ($non_woking == 0)){
                        continue;
                    }else{
                        $leave_request = new EmployeeLeave();
                        $leave_request->absence_type_id = $request->input('absence_type_id');
                        $leave_request->employee_id = $employee_id;
                        $leave_request->status = LeaveStatusType::status_pending; 
                        
                        if(($non_woking == 1) && (!isset($time_period[$curr]['end_time']) && !isset($time_period[$curr]['start_time']))){
                            $start_time = "08:00";
                            $end_time   = "17:00";
                        }else{
                            $start_time = $time_period[$curr]['start_time'];
                            $end_time   = $time_period[$curr]['end_time'];
                        }

                        //first absence date
                        if($day->format("Y-m-d") == $request_from){
                            $leave_request->starts_at = $request->input('leave_from');
                            $leave_request->ends_at   = $day->format("Y-m-d").' '.$end_time;
                        //last absence date
                        }elseif($day->format("Y-m-d") == $request_to){
                            $leave_request->starts_at = $day->format("Y-m-d").' '.$start_time;
                            $leave_request->ends_at   = $request->input('leave_to');
                        //absence date(s) between
                        }else{
                            $leave_request->starts_at = $day->format("Y-m-d").' '.$start_time;
                            $leave_request->ends_at   = $day->format("Y-m-d").' '.$end_time;
                        }
                    
                        $leave_request->save();
                    }
                    
                }
            }
            
            \Session::put('success', $this->baseFlash . 'updated!!');
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }
       
        return redirect()->back();
    }


    /**
     * Show the form for creating a new employee leave request.
     *
     * @return Illuminate\View\View
     */
    public function edit(Request $request)
    {
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
        $sql_request = "SELECT DISTINCT(abe.id),abs.description as absence_description,abe.employee_id,ele.total,ele.taken,(ele.total - ele.taken) as remaining,abe.starts_at,abe.ends_at,abe.status,CONCAT(emp.first_name,\" \",emp.surname) as validator
            FROM absence_type_employee abe
            LEFT JOIN absence_types abs ON abs.id = abe.absence_type_id
            LEFT JOIN eligibility_employee ele ON ele.absence_type_id =abs.id
            LEFT JOIN employees emp ON abe.approved_by_employee_id = emp.id";

        if(empty($date_from) && empty($date_to)){
            $sql_request .= " WHERE abe.employee_id = $employee_id AND YEAR(abe.starts_at) = YEAR(CURDATE()) AND ele.employee_id = $employee_id";
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
            "SELECT abs.id,abs.description as absence_description,abs.duration_unit,(SELECT COALESCE(SUM(TIMESTAMPDIFF(second,ate.starts_at,ate.ends_at)/3600),0) FROM absence_type_employee ate WHERE ate.employee_id = $employee_id AND abs.id = ate.absence_type_id AND ate.status = ".LeaveStatusType::status_pending.") as pending,ele.taken,ele.total,(ele.total - ele.taken) as remaining,ele.start_date
            FROM eligibility_employee ele
            LEFT JOIN absence_types abs ON abs.id = ele.absence_type_id
            WHERE ele.start_date <= NOW() AND CURDATE() BETWEEN ele.start_date AND ele.end_date AND ele.employee_id = $employee_id ;"
        );

        return $employee_leave;


    }


    public static function getEligibleAbsencesTypes($employee_id,$absence_type_id = null){
        $sql= 
            "SELECT abt.id, 
            abt.non_working_days as non_working_days,abt.duration_unit, 
            abt.description,(ele.total - ele.taken) as remaining 
            FROM eligibility_employee ele
            LEFT JOIN absence_types abt ON abt.id = ele.absence_type_id
            WHERE ele.start_date <= NOW() AND ele.employee_id = $employee_id";
       

        if(!empty($absence_type_id)){
            $sql .= " AND abt.id =".$absence_type_id;
        }

        $eligible_leave = DB::select($sql);
        return $eligible_leave;
    }

    function changeStatus($leave_id,$status,$mode = 'default'){
        try {
            $leave_request = EmployeeLeave::findOrFail($leave_id);
            $duration_unit = $leave_request->AbsenceType->duration_unit;
            if($status != LeaveStatusType::status_cancelled){
                $leave_request->approved_by_employee_id = \Auth::user()->employee_id;
            }
            
            if($status != LeaveStatusType::status_denied){
                //date diff, 1 day = 9 hours
                $date_from = strtotime($leave_request->starts_at);
                $date_to   = strtotime($leave_request->ends_at);
                if($duration_unit == LeaveDurationUnitType::Days){
                    $date_diff = round((($date_to - $date_from) / (60 * 60 * 9)),2);
                }else{
                    $date_diff = round((($date_to - $date_from) / (60 * 60)),2);
                }
                
                $taken = self::getAbsenceTypeTaken($leave_request->employee_id,$leave_request->absence_type_id);
                if(($status == LeaveStatusType::status_cancelled) && ($leave_request->status == LeaveStatusType::status_approved)){
                    $new_taken = $taken - $date_diff;
                }else{
                    $new_taken = $taken + $date_diff;
                }

                $update_taken = EmployeeEligibility::where('employee_id',$leave_request->employee_id)
                                        ->where('absence_type_id',$leave_request->absence_type_id)
                                        ->update(['taken' => ($new_taken)]);

                //insert in leave calendar
                if($status == LeaveStatusType::status_approved){
                    $leave_calendar = new CalendarEvent();
                    $leave_calendar->title           = $leave_request->AbsenceType->description." : ".$leave_request->Employee->first_name." ".$leave_request->Employee->surname;
                    $leave_calendar->start_Date      = $leave_request->starts_at;
                    $leave_calendar->end_date        = $leave_request->ends_at;
                    $leave_calendar->calendable_id   = $leave_id;
                    $leave_calendar->calendable_type = EmployeeLeave::class;
                    $leave_calendar->department_id   = $leave_request->Employee->department_id;
                    $leave_calendar->save();
                }
            }
           
            $leave_request->status = $status;
            $leave_request->save();
            
            if($mode == 'default'){
                \Session::put('success', $this->baseFlash . 'updated!!');
            }
            
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseRoute .'.index');
    }

    function batchChangeStatus($leave_ids,$status){
        try {
            $ids = explode(',',$leave_ids);
            foreach($ids as $id){
                $this->changeStatus($id,$status,'batch');
            }
           
            \Session::put('success', $this->baseFlash . 'updated!!');
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseRoute .'.index');
    }

    public static function getAbsenceTypeTaken($employee_id,$absence_type_id){
        $taken = DB::table('eligibility_employee')
        ->select('taken')
        ->where('employee_id','=',$employee_id)
        ->where('absence_type_id','=',$absence_type_id)
        ->pluck('taken')->toArray();

        return $taken[0];
    }


    private function getPendingRequests($manager_id,$selected = null){
        $employee_ids = EmployeesController::getManagerEmployeeIds($manager_id);

        $sql_request = "SELECT DISTINCT(abe.id),abs.description as absence_description,abe.employee_id,CONCAT(emp.first_name,\" \",emp.surname) as employee,ele.total,ele.taken,(ele.total - ele.taken) as remaining,abe.starts_at,abe.ends_at,abe.status
            FROM absence_type_employee abe
            LEFT JOIN absence_types abs ON abs.id = abe.absence_type_id
            LEFT JOIN eligibility_employee ele ON (ele.absence_type_id =abs.id AND ele.employee_id =abe.employee_id)
            LEFT JOIN employees emp ON abe.employee_id = emp.id";
         
        if(!empty($selected)){
            $sql_request .=" WHERE abe.employee_id = $selected AND abe.status =".LeaveStatusType::status_pending;
        }else{
            $sql_request .=" WHERE abe.employee_id IN (".implode(',',$employee_ids).") AND abe.status =".LeaveStatusType::status_pending;
        }
        $sql_request .= " ORDER BY abe.starts_at DESC;";
        

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

    public static function getTimePeriod($employee){
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

    private static function timeIntervalReadable($value) {
        if ($value != null) {
            $interval = new DateTime($value);
            return $interval->format('G:i');
        }
        return '00:00';
    }


    private static function getOfficeHours($tgTimePeriod){
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
