<?php

namespace App\Http\Controllers;

use App\Module;
use App\AssessmentType;
use App\ModuleAssessment;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;

class ModuleAssessmentsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new ModuleAssessment();
        $this->baseViewPath = 'module_assessments';
        $this->baseFlash = 'Module Assessment details ';
    }

    /**
     * Display a listing of the module assessments.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $moduleAssessments = $this->contextObj::with(['module','assessmentType'])->filtered()->paginate(10);

        // handle empty result bug
        if ($moduleAssessments->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('moduleAssessments'));
    }

    /**
     * Store a new module assessment in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $input = array_except($request->all(),array('_token'));

            $this->contextObj->addData($input);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Update the specified module assessment in the storage.
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
     * Remove the specified module assessment from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('module_assessment');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    
}