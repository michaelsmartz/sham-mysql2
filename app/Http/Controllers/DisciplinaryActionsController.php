<?php

namespace App\Http\Controllers;

use App\User;
use App\Employee;
use App\Violation;
use App\DisciplinaryAction;
use App\DisciplinaryDecision;
use App\TimelineManager;
use Illuminate\Http\Request;
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

        $description = $request->get('description', null);

        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $violation_date = $request->get('violation_date', null);

        if(!empty($violation_date)){
            $request->merge(['violation_date' => '%'.$violation_date.'%']);
        }

        $date_issued = $request->get('date_issued', null);

        if(!empty($date_issued)){
            $request->merge(['date_issued' => '%'.$date_issued.'%']);
        }

        $id = Route::current()->parameter('employee');
        $disciplinaryActions = $this->contextObj::where('employee_id', $id)->filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page') && $disciplinaryActions->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('id','disciplinaryActions'));
    }

    public function create() {
        Session::put('redirectsTo', \URL::previous());
        $id = Route::current()->parameter('employee');
        $updated_by = \Auth::user()->id;
        $disciplinaryDecisions = DisciplinaryDecision::pluck('description', 'id');
        $violations = Violation::pluck('description','id');

        return view($this->baseViewPath . '.create',compact('id','updated_by','disciplinaryDecisions','violations'));
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
       try {
            $this->validator($request);

            $input = array_except($request->all(),array('_token', '_method'));

            $data = $this->contextObj->addData($input);
            TimelineManager::addDisciplinaryActionTimelineHistory($data);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect(Session::get('redirectsTo'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = Route::current()->parameter('disciplinary_action');
        $data = $this->contextObj->findData($id);
        $updated_by = \Auth::user()->id;

        $violations = Violation::pluck('description','id')->all();
        $disciplinaryDecisions = DisciplinaryDecision::pluck('description', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'updated_by', 'violations','disciplinaryDecisions'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data', 'updated_by', 'violations','disciplinaryDecisions'));
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
            
            $redirectsTo = $request->get('redirectsTo', route('disciplinaryactions.index'));
            
            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->back();
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
            $id = Route::current()->parameter('disciplinary_action');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'violation_id' => 'required',
            'violation_date' => 'required|string|min:0',
            'employee_statement' => 'required|string|min:1',
            'employer_statement' => 'required|string|min:1',
            'decision' => 'required|string|min:1',
            'disciplinary_decision_id' => 'required',
            'employee_id' => 'required',
            'updated_by' => 'nullable',
            'date_issued' => 'required|string|min:0',
            'date_expires' => 'required|string|min:0'
        ];

        $validator = Validator::make($request->all(), $validateFields);
        if($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }
    }
}