<?php

namespace App\Http\Controllers;

use App\Course;
use App\Module;
use App\Employee;
use App\ModuleAssessment;
use Illuminate\Http\Request;
use App\ModuleAssessmentResponse;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;

class ModuleAssessmentResponsesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new ModuleAssessmentResponse();
        $this->baseViewPath = 'module_assessment_responses';
        $this->baseFlash = 'Module Assessment Response details ';
    }

    /**
     * Display a listing of the module assessment responses.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $id = Route::current()->parameter('module_assessment');
        $moduleAssessmentResponses = $this->contextObj::whereHas('employee')->where('module_assessment_id', $id)->filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page') && $moduleAssessmentResponses->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('moduleAssessmentResponses'));
    }


    /**
     * Update the specified module assessment response in the storage.
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
     * Validate the given request with the defined rules.
     *
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
        ];

        $validator = Validator::make($request->all(), $validateFields);
        if($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }
    }
}