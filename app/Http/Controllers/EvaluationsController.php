<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Language;
use App\Evaluation;
use App\Assessment;
use App\Department;
use App\ProductCategory;
use App\EvaluationStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Traits\MediaFiles;
use Exception;

class EvaluationsController extends CustomController
{
    use MediaFiles;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Evaluation();
        $this->baseViewPath = 'evaluations';
        $this->baseFlash = 'Evaluation details ';
    }

    /**
     * Display a listing of the evaluations.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $evaluations = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('evaluations'));
    }

    public function create()
    {
        $assessments = Assessment::pluck('name','id')->all();
        $employees = Employee::pluck('full_name', 'id')->all();
        $departments = Department::pluck('description','id')->all();
        $productCategories = ProductCategory::pluck('description','id')->all();
        $languages = Language::pluck('description','id')->all();
        $evaluationStatuses = EvaluationStatus::pluck('description','id')->all();

        return view($this->baseViewPath . '.create', compact('data','assessments','employees','departments','productCategories','languages','evaluationStatuses'));
    }

    /**
     * Store a new evaluation in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            $employeeid = \Auth::user()->employee->id;

            $selectedassessors = array_get($request->all(),'selectedassessors');
            $input = array_except($request->all(),array('_token'));

            $input['createdby_employee_id'] = $employeeid;

            if($input['status'] == 'savecontent') {

                $input['is_usecontent'] = 1;
                if (Input::hasFile('attachment') && Input::file('attachment')->isValid()) {
                    $filename = Input::file('attachment')->getClientOriginalName();
                    $input['original_filename'] = $filename;
                }
                else
                {
                    unset($input['QaSample']);
                }
            }
            elseif($input['status'] == 'savepath')
            {
                $input['is_usecontent'] = 0;
                $input['url_path'] = $input['UrlPath'];
            }

            $context = $this->contextObj->addData($input);
            $this->attachSingleFile($request, $context->id,'attachment');

            $context->assessors()
                ->attach($selectedassessors); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            dump($exception->getMessage());
            die;
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Update the specified evaluation in the storage.
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
     * Remove the specified evaluation from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('evaluation');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }

    public function showinstances()
    {
        $evaluations = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.instancesindex', compact('evaluations'));
    }
    
    
}