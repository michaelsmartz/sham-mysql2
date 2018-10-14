<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Reward;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;

class RewardsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Reward();
        $this->baseViewPath = 'rewards';
        $this->baseFlash = 'Reward details ';
    }

    //functions necessary to handle 'resource' type of route
    public function index(Request $request)
    {
        $id = Route::current()->parameter('employee');

        $rewards = $this->contextObj::where('employee_id', $id)->filtered()->paginate(10);

        return view($this->baseViewPath .'.index', compact('id','rewards'));
    }

    public function create() {
        if (!Session::has('redirectsTo'))
        {
            Session::put('redirectsTo', \URL::previous());
        }
        $employees = Employee::pluck('full_name', 'id');
        return view($this->baseViewPath . '.create',compact('employees'));
    }

    /**
     * Store a new reward in the storage.
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
        $id = Route::current()->parameter('reward');
        $data = $this->contextObj->findData($id);

        $employees = Employee::pluck('full_name', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'employees'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data', 'employees'));
    }

    /**
     * Update the specified reward in the storage.
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

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified reward from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('reward');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Validate the given request with the defined rules.
     *
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'description' => 'required|string|min:1|max:50',
            'rewarded_by' => 'required|string|min:1|max:100',
            'date_received' => 'required|string|min:0',
            'employee_id' => 'required'
        ];

        $validator = Validator::make($request->all(), $validateFields);
        if($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }

    }

}