<?php

namespace App\Http\Controllers;

use App\Assessment;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\AssessmentCategory;
use Exception;

class AssessmentsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Assessment();
        $this->baseViewPath = 'assessments';
        $this->baseFlash = 'Assessment details ';
    }

    /**
     * Display a listing of the assessments.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $assessments = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page') && $assessments->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('assessments'));
    }

    /**
     * Show the form for creating a new assessment.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        /*  $modules = Module::pluck('description', 'id');
        return view($this->baseViewPath . '.create',compact('modules'));*/

        $assessmentcategories = AssessmentCategory::pluck('description', 'id');
        return view('assessments.create',compact('assessmentcategories'));
    }

    /**
     * Store a new assessment in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            //$this->validator($request);

            $assessmentcategories = array_get($request->all(),'assessmentcategories');
            $input = array_except($request->all(),array('_token'));

            $data = $this->contextObj->addData($input);

            $data->assessmentAssessmentCategory()
                ->sync($assessmentcategories); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {

        $data = null;
        $_mode = 'edit';
        $fullPageEdit = true;
        $id = Route::current()->parameter('assessment');
        //dump($id);die;

        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
        }
        $assessmentcategories = AssessmentCategory::pluck('description', 'id');
        $assessmentaAssessmentCategories = $data->assessmentAssessmentCategory()->pluck('description', 'assessments_assessment_category.assessment_category_id');

        return view($this->baseViewPath .'.edit',
            compact('_mode','fullPageEdit','data','assessmentcategories','assessmentaAssessmentCategories'));
    }

    /**
     * Update the specified assessment in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            //$this->validator($request);
            
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));

            $assessmentcategories = array_get($request->all(),'assessmentcategories');
            
            $input = array_except($request->all(),array('_token','_method','redirectsTo','q','assessmentcategories'));

            $this->contextObj->updateData($id, $input);

            $data = Assessment::find($id);
            $data->assessmentAssessmentCategory()
                ->sync($assessmentcategories); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified assessment from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('assessment');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    
}