<?php

namespace App\Http\Controllers;


use App\AbsenceType;
use App\Employee;
use App\Http\Controllers\CustomController;
use App\Support\Helper;
use App\SystemSubModule;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class EntitlementsController extends CustomController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseFlash = 'Entitlement details ';
    }


    /**
     * @param Request $request
     * @return Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function index(Request $request)
    {
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $employee_name = $request->get('full_name', null);

        if(!empty($employee_name)){
            $request->merge(['full_name' => '%'.$employee_name.'%']);
        }

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_ENTITLEMENTS);

        //if search button is clicked employee will not be null
        $employee_id_entitlement_search = $request->get('employee', null);

        $valid_until = $request->get('valid_until_date', null);

        //Display only employee entitlements for current year
        try {
            if (!is_null($employee_id_entitlement_search) && is_null($valid_until)) {
                $entitlements = Employee::with(['eligibilities'=> function ($query){
                        $query->whereRaw('year(`eligibility_employee`.`end_date`) = ?',[date('Y')]);
                    }])
                    ->where(['id' => $employee_id_entitlement_search])
                    ->filtered()->paginate(10);
            }
            elseif (is_null($employee_id_entitlement_search) && !is_null($valid_until)){
                $entitlements = Employee::with(['eligibilities'=> function ($query) use($valid_until){
                    $query->whereRaw('`eligibility_employee`.`end_date` >= ?',[$valid_until]);
                }])
                    ->where(['id' => $employee_id])
                    ->filtered()->paginate(10);
            }
            elseif (!is_null($employee_id_entitlement_search) && !is_null($valid_until)){
                $entitlements = Employee::with(['eligibilities'=> function ($query) use($valid_until){
                    $query->whereRaw('`eligibility_employee`.`end_date` >= ?',[$valid_until]);
                }])
                    ->where(['id' => $employee_id_entitlement_search])
                    ->filtered()->paginate(10);
            }
            else {
                $entitlements = Employee::with(['eligibilities' => function ($query) {
                    $query->whereRaw('year(`eligibility_employee`.`end_date`) = ?', [date('Y')]);
                }])
                    ->where(['id' => $employee_id])
                    ->filtered()->paginate(10);
            }


            //find if connected employee is a manager to display button search other employee's entitlements
            $current_employee = Employee::with('jobTitle')
                ->where('id', '=', $employee_id)
                ->first();


            if(!is_null($employee_id_entitlement_search))
                $selected_employee = Employee::where('id','=', $employee_id_entitlement_search)->first();
            elseif(!is_null($employee_id))
                $selected_employee = Employee::where('id','=', $employee_id)->first();
            else
                $selected_employee = null;

            //employee list to exclude the employee connected in the list
            $employees = Employee::where('id','!=',$employee_id)->pluck('full_name', 'id');

        }catch (Exception $exception){
            dd($exception->getMessage());
        }

        return view('entitlements.index',
            compact('entitlements', 'selected_employee', 'current_employee', 'employees', 'allowedActions'));
    }

    /**
     * Show the form for creating a new entitlement.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $leave_policies = AbsenceType::pluck('description', 'id');
        return view('entitlements.create', compact('employees', 'leave_policies'));
    }

    /**
     * Store a new entitlement in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $this->validator($request);

            return redirect()->route('entitlements..index')
                             ->with('success_message', 'Entitlement was successfully added.');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * @param Request $request
     * @return Factory|\Illuminate\Http\Response|View
     */
    public function edit(Request $request)
    {
        try{
            $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : null;

            $data = null;
            $id = Route::current()->parameter('entitlement');
            if(!empty($id)) {
                //$data = DB::select('SELECT * FROM eligibility_employee WHERE id = "'.$id.'"');
                $data = DB::table('eligibility_employee')->where(['id' =>$id])->first();

                $leave_policies = AbsenceType::pluck('description', 'id');
            }

//            dump($data->employee_id);
//            dd($employee_id);

            if($request->ajax()) {
                $view = view('entitlements.edit',
                    compact('data','leave_policies', 'employee_id'))
                    ->renderSections();

                return response()->json([
                    'title' => $view['modalTitle'],
                    'content' => $view['modalContent'],
                    'footer' => $view['modalFooter'],
                    'url' => $view['postModalUrl']
                ]);
            }
        } catch (Exception $exception) {
           dd($exception->getMessage());
        }

        return view('entitlements.edit', compact('data','leave_policies', 'employee_id'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $this->validator($request);

            DB::statement('UPDATE eligibility_employee SET total ='. $data['total'].
                ', taken ='.$data['taken'].', is_manually_adjusted=1 WHERE id = '.$id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route('entitlements.index');
    }

    /**
     * Remove the specified entitlement from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            //$entitlement = Entitlement::findOrFail($id);
            //$entitlement->delete();

            return redirect()->route('entitlements.index')
                             ->with('success_message', 'Entitlement was successfully deleted.');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function validator(Request $request)
    {
        $rules = [
            'start_date' => 'date_format:j/n/Y|nullable',
            'end_date' => 'date_format:j/n/Y|nullable',
            'total' => 'numeric|nullable',
            'taken' => 'string|min:1|nullable',
        ];
        
        $data = $request->validate($rules);

        return $data;
    }

}
