<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Request;

class HistoryLeavesController extends CustomController
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
            $leaves = EmployeeLeavesController::getEmployeeLeavesHistory($employee_id);
            $eligibility = EmployeeLeavesController::getEmployeeLeavesStatus($employee_id);

            //find if connected employee is a manager to display button search other employee's entitlements
            $current_employee = Employee::with('jobTitle')
                ->where('id', '=', $employee_id)
                ->first();

            //if search button is clicked employee will not be null
            $employee_id_search = $request->get('employee', null);

            if (!is_null($employee_id_search))
                $selected_employee = Employee::where('id', '=', $employee_id_search)->first();
            elseif (!is_null($employee_id))
                $selected_employee = Employee::where('id', '=', $employee_id)->first();
            else
                $selected_employee = null;

            //employee list to exclude the employee connected in the list
            $employees = Employee::where('id', '!=', $employee_id)->pluck('full_name', 'id');

//        dump($employees);
//        dump($leaves);
//        dd($eligibility);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
        return view('history_leaves.index', compact('leaves','eligibility','employees', 'selected_employee', 'current_employee'));
    }
}
