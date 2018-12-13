<?php

namespace App\Http\Controllers;

use App\Course;
use App\Module;
use App\Employee;
use App\ModuleAssessment;
use App\ModuleAssessmentResponse;
use App\ModuleAssessmentResponseDetail;
use App\Enums\ModuleQuestionType;
use Illuminate\Http\Request;

use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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

    public function edit(Request $request)
    {
        Session::put('redirectsTo', \URL::previous());
        $id = Route::current()->parameter('response');
        $assessmentId = Route::current()->parameter('module_assessment');

        $moduleAssessment = ModuleAssessment::with('module','assessmentType')->find($assessmentId);
        $moduleAssessmentResponses = ModuleAssessmentResponseDetail::assessmentResponseSheet()
                                     ->with('moduleAssessmentResponse')
                                     ->where('module_assessment_response_id', '=', $id)
                                     ->get();

        if ($moduleAssessmentResponses->count() == 0|| empty($moduleAssessmentResponses)){
            return View('not-allowed')
                ->with('title', 'Module Assessment Responses')
                ->with('warnings', array('There are no responses for this module assessment'));
        }else{
            $data = $moduleAssessmentResponses[0]->moduleAssessmentResponse;
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.show', compact('assessmentId', 'data', 'moduleAssessmentResponses', 'moduleAssessment'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('assessmentId', 'data', 'moduleAssessmentResponses','moduleAssessment'));
    }

    /**
     * Update the specified module assessment response in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id, $responseId)
    {

        try {
            $this->validator($request);

            $input = array_except($request->all(),array('_token','_method','is_reviewed'));
            $reviewed = $request->only('is_reviewed');

            if(!empty($input)) {
                $ids = array_map(function ($value) {
                    return $value['id'];
                }, $input['responseDetail']);
                $revisedPoints = array_map(function ($value) {
                    return $value['points'];
                }, $input['responseDetail']);

                $this->contextObj->updateData($responseId, $reviewed);
                foreach ($ids as $key => $id) {
                    ModuleAssessmentResponseDetail::where('id', $id)->update(['points' => $revisedPoints[$key]]);
                }
            }

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->to(Session::get('redirectsTo'));

    }

    /**
     * Validate the given request with the defined rules.
     *
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [];

        $validator = Validator::make($request->all(), $validateFields);
        if($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }
    }
}