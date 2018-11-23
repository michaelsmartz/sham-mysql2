<?php

namespace App\Http\Controllers;

use App\AssessmentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\CategoryQuestion;
use Exception;
use App\SystemSubModule;

class AssessmentCategoriesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new AssessmentCategory();
        $this->baseViewPath = 'assessment_categories';
        $this->baseFlash = 'Assessment Category details ';
    }

    /**
     * Display a listing of the assessment categories.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $name = $request->get('name', null);
        $description = $request->get('description', null);


        $allowedActions = null;
        $modulePermissionsToArray = session('modulePermissions')->toArray();

        if(array_key_exists(SystemSubModule::CONST_ASSESSMENT_CATEGORIES,$modulePermissionsToArray)){
            $allowedActions = session('modulePermissions')[SystemSubModule::CONST_ASSESSMENT_CATEGORIES];
        }
        if ($allowedActions == null || !$allowedActions->contains('List')){
            return View('not-allowed')
                ->with('title', 'Assessment Categories')
                ->with('warnings', array('You do not have permissions to access this page.'));
        }

        if(!empty($name)){
            $request->merge(['name' => '%'.$name.'%']);
        }
        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $assessmentCategories = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page') && $assessmentCategories->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('assessmentCategories','allowedActions'));
    }

    public function create()
    {
        $categoryquestions = CategoryQuestion::pluck('title', 'id');
        return view($this->baseViewPath . '.create',compact('categoryquestions'));
    }

    /**
     * Store a new assessment category in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            //$this->validator($request);

            $accq = array_get($request->all(),'accq');
            $input = array_except($request->all(),array('_token'));

            $data = $this->contextObj->addData($input);
            $data->assessmentCategoryCategoryQuestions()->sync($accq);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            //dump($exception->getMessage());die;
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {

        $data = null;
        $_mode = 'edit';
        $fullPageEdit = true;
        $id = Route::current()->parameter('assessment_category');

        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
        }

        $categoryquestions = CategoryQuestion::pluck('title', 'id');
        $accq = $data->assessmentCategoryCategoryQuestions()->pluck('title', 'assessment_category_category_question.category_question_id');

        return view($this->baseViewPath .'.edit',
            compact('_mode','fullPageEdit','data','categoryquestions','accq'));
    }

    /**
     * Update the specified assessment category in the storage.
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

            $accq = array_get($request->all(),'accq');
            $input = array_except($request->all(),array('_token','_method','redirectsTo','q','accq'));


            $this->contextObj->updateData($id, $input);

            $data = AssessmentCategory::find($id);
            $data->assessmentCategoryCategoryQuestions()
                ->sync($accq); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified assessment category from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('assessment_category');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    
}