<?php

namespace App\Http\Controllers;

use App\Employee;
use App\EmployeeLeave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class EmployeeLeavesController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Employee();
        $this->baseViewPath = 'leaves';
        $this->baseFlash = "Employee's leave details ";
    }
    /**
     * Display a listing of the employee's leaves.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $employees   = EmployeesController::getManagerEmployees($employee_id);
        $leaves      = $this->getEmployeeLeavesHistory($employee_id);
        $eligibility = $this->getEmployeeLeavesStatus($employee_id);

        return view($this->baseViewPath .'.index', compact('leaves','eligibility','employees'));
    }

    /**
     * Display a listing of the employee's leaves within date range.
     *
     * @return Illuminate\View\View
     */
    public function filterLeave(Request $request)
    {
        if(!empty($request->input('employee_id')) && $request->input('employee_id') != 0){
            $employee_id = $request->input('employee_id');
            $employees   = EmployeesController::getManagerEmployees(\Auth::user()->employee_id);
        }elseif ($request->input('employee_id') == 0){
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            $employees   = EmployeesController::getManagerEmployees(\Auth::user()->employee_id);
        }else{
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            $employees   = null;
        }
        $leaves      = $this->getEmployeeLeavesHistory($employee_id,$request->input('from'),$request->input('to'));
        $eligibility = $this->getEmployeeLeavesStatus($employee_id);

        return view($this->baseViewPath .'.index', compact('leaves','eligibility','employees'));
    }


    /**
     * Show the form for creating a new employee leave request.
     *
     * @return Illuminate\View\View
     */
    public function create($leave_id,$leave_description)
    {
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $leave_type = $this->getEligibleAbsencesTypes($employee_id);

        $view = view($this->baseViewPath .'.create',compact('leave_type','leave_id','leave_description'))->renderSections();
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

            $leave_request = new EmployeeLeave();
            $leave_request->absence_type_id = $request->input('absence_type_id');
            $leave_request->employee_id = $employee_id;
            $leave_request->status = 0;
            $leave_request->starts_at = $request->input('leave_from');
            $leave_request->ends_at = $request->input('leave_to');
            $leave_request->save();

            \Session::put('success', $this->baseFlash . 'updated!!');
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }


    /**
     * Show the form for creating a new employee leave request.
     *
     * @return Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $id = Route::current()->parameter('leave_id');
        $leave_type = $this->getEligibleAbsencesTypes($employee_id);

        if($request->ajax()) {
            $view = view($this->baseViewPath .'.edit',compact('leave_type','id'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath .'.edit',compact('leave_type'));
    }

    public static function getEmployeeLeavesHistory($employee_id,$date_from = null,$date_to = null){
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

        $sql_request .= " ORDER BY abe.starts_at DESC;";
        $employee_leave= DB::select($sql_request);

        return $employee_leave;


    }


    public static function getEmployeeLeavesStatus($employee_id){

        $employee_leave= DB::select(
            "SELECT abs.id,abs.description as absence_description,ele.taken,ele.total,(ele.total - ele.taken) as remaining,ele.start_date
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

        return redirect()->route($this->baseViewPath .'.index');
    }
}
