<?php

namespace App\Http\Controllers;

use App\AbsenceType;
use App\Employee;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Request;

class LeavesController extends CustomController
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            //Filter by employee
            if(!empty($request->input('employee')) && $request->input('employee') != 0)
                $employee_id = $request->input('employee');
            elseif ($request->input('employee_id') == 0)
                $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            else
                $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

            //Filter by leave type
            if(!empty($request->input('absence_type')) && $request->input('absence_type') != 0){
                $selected_absence_type = $request->input('absence_type');
            }else{
                $selected_absence_type = null;
            }

            $absence_types = AbsenceType::pluck('description','id');

            //find if connected employee is a manager to display button search other employee's entitlements
            $current_employee = Employee::with('jobTitle')
                ->where('id', '=', (\Auth::check()) ? \Auth::user()->employee_id : 0)
                ->first();

            $from = $request->get('from', null);
            $to = $request->get('to', null);

            $leaves = SSPEmployeeLeavesController::getEmployeeLeavesHistory($employee_id, $from, $to, $selected_absence_type);

            $selected_employee = Employee::where('id', '=', $employee_id)->first();

            $employees = Employee::whereNull('date_terminated')->pluck('full_name', 'id');
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
        return view('leaves.index', compact('leaves','absence_types','employees', 'from', 'to', 'selected_employee', 'current_employee', 'selected_absence_type'));
    }
}
