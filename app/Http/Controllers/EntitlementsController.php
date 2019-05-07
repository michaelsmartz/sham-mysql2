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
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;

class EntitlementsController extends CustomController
{

    /**
     * @param Request $request
     * @return Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function index(Request $request)
    {

        $employee_name = $request->get('full_name', null);

        if(!empty($employee_name)){
            $request->merge(['full_name' => '%'.$employee_name.'%']);
        }

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_ENTITLEMENTS);

        $entitlements = Employee::with('absenceTypes')->filtered()->paginate(10);

        return view('entitlements.index', compact('entitlements','allowedActions'));
    }

    /**
     * Show the form for creating a new entitlement.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $leave_policies = AbsenceType::pluck('description', 'id');
        $employees = Employee::pluck('full_name', 'id');
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

            $departments = array_get($request->all(),'departments');

            $input = array_except($request->all(),array('_token', 'departments'));
            
            //Entitlement::create($data);

            return redirect()->route('entitlements.entitlement.index')
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
        //$entitlement = Entitlement::findOrFail($id);
        $entitlement = [];
        

        return view('entitlements.edit', compact('entitlement'));
    }

    /**
     * Update the specified entitlement in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            
            $data = $this->getData($request);
            
            //$entitlement = Entitlement::findOrFail($id);
            $entitlement = [];
            $entitlement->update($data);

            return redirect()->route('entitlements.entitlement.index')
                             ->with('success_message', 'Entitlement was successfully updated.');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }        
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

            return redirect()->route('entitlements.entitlement.index')
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
    protected function getData(Request $request)
    {
        $rules = [
            'start_date' => 'date_format:j/n/Y|nullable',
            'end_date' => 'date_format:j/n/Y|nullable',
            'total' => 'numeric|nullable',
            'taken' => 'string|min:1|nullable',
            'is_manually_adjusted' => 'boolean|nullable', 
        ];
        
        $data = $request->validate($rules);

        return $data;
    }

}
