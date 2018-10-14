<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Violation;
use App\DisciplinaryAction;
use Illuminate\Http\Request;
use App\DisciplinaryDecision;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;

class DisciplinaryActionsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new DisciplinaryAction();
        $this->baseViewPath = 'disciplinary_actions';
        $this->baseFlash = 'Disciplinary Action details ';
    }

    /**
     * Display a listing of the disciplinary actions.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {

        $id = Route::current()->parameter('employee');

        $disciplinaryActions = $this->contextObj::where('employee_id', $id)->filtered()->paginate(10);

        return view($this->baseViewPath .'.index', compact('id','disciplinaryActions'));
    }

    public function create() {
        if (!Session::has('redirectsTo'))
        {
            Session::put('redirectsTo', \URL::previous());
        }
        $violations = Violation::pluck('description','id')->all();
        $employees = Employee::pluck('full_name', 'id');
        $disciplinaryDecisions = DisciplinaryDecision::pluck('description', 'id');
        $updaters = $employees;

        return view($this->baseViewPath . '.create',compact('employees','violations','disciplinaryDecisions','updaters'));
    }

    /**
     * Store a new disciplinary action in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

       if (!Session::has('redirectsTo'))
       {
         Session::put('redirectsTo', URL::previous());
       }
       try {
            $this->validator($request);
            $input = array_except($request->all(),array('_token', '_method'));

            $data = $this->contextObj->addData($input);
            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = Route::current()->parameter('disciplinaryaction');
        $data = $this->contextObj->findData($id);

        $violations = Violation::pluck('description','id')->all();
        $employees = Employee::pluck('full_name', 'id');
        $disciplinaryDecisions = DisciplinaryDecision::pluck('description', 'id');
        $updaters = $employees;

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'employees','violations','disciplinaryDecisions','updaters'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data', 'employees','violations','disciplinaryDecisions','updaters'));
    }

    /**
     * Update the specified disciplinary action in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validator($request);
            
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));
            
            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified disciplinary action from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('disciplinaryaction');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    

    /**
     * Validate the given request with the defined rules.
     *
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'violation_id' => 'required',
            'violation_date' => 'required|string|min:0',
            'employee_statement' => 'required|string|min:1',
            'employer_statement' => 'required|string|min:1',
            'decision' => 'required|string|min:1',
            'updated_by' => 'required|string|min:1|max:100',
            'date_issued' => 'nullable|string|min:0',
            'date_expires' => 'nullable|string|min:0'
        ];

        $validator = Validator::make($request->all(), $validateFields);
        if($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }
    }
}