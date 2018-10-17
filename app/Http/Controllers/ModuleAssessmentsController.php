<?php

namespace App\Http\Controllers;

use App\Module;
use App\AssessmentType;
use App\ModuleAssessment;
use App\ModuleAssessmentQuestion;
use App\ModuleQuestion;
use App\ModuleQuestionChoice;
use App\Enums\ModuleQuestionType;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;

class ModuleAssessmentsController extends CustomController
{

    private $jsonQuestionMap = array(
        'label' => 'title',
        'type' => 'module_question_type_id',
        'Points' => 'points'
    );

    private $jsonQuestionChoiceMap = array(
        'label' => 'choice_text',
        'selected' => 'correct_answer',
        'Points' => 'points'
    );

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
        if (Input::has('page') && $moduleAssessments->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('moduleAssessments'));
    }

    public function create() {
        $modules = Module::pluck('description', 'id');
        $assessmentTypes = AssessmentType::pluck('description', 'id');
        $_mode = "create";
        return view($this->baseViewPath . '.create',compact('_mode','modules','assessmentTypes'));
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

            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

            $this->saveAssessment(0, $input);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = $modules = $assessmentTypes = null;
        $id = Route::current()->parameter('module_assessment');
        $fullPageEdit = true;
        $_mode = 'edit';
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $modules = Module::pluck('description', 'id');
            $assessmentTypes = AssessmentType::pluck('description', 'id');
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','modules','assessmentTypes','fullPageEdit','_mode'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','modules','assessmentTypes','fullPageEdit','_mode'));
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

            $this->saveAssessment($id, $input);

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

        /**
     * Validate the given request with the defined rules.
     *
     * @param  Request $request
     *
     * @return boolean
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'description' => 'string|min:5|max:100|required',
            'module_id' => 'required',
            'assessment_type_id' => 'required',
            'pass_mark' => 'numeric|required'
        ];
        
        $this->validate($request, $validateFields);
    }

    protected function saveAssessment($id, $input)
    {
        $response = ['status' => 'OK']; 
        $responseCode = 200;

        try {

            $fd = $input['data'];

            if ($id == 0) {
                $context = $this->contextObj->create($input);
                $id = $context->id;
            } else {
                $temp['id'] = $id;
                $res = $this->contextObj->where('id', $id)->update($input);
            }

            $context = $this->contextObj->find($id);
            $context->load('assessmentQuestions');
            // get Module Questions, their choices and their referenced Assessment questions 

            $questionIds = optional($context->assessmentQuestions)->pluck('module_question_id');
            $maQuestionIds = optional($context->assessmentQuestions)->pluck('id');

            $mqs = ModuleQuestion::with('questionChoices')->whereIn('id', $questionIds)->get();

            $mqChoiceIds = $mqs->pluck('questionChoices')->collapse()->pluck('id');

            ModuleQuestionChoice::whereIn('id', $mqChoiceIds)->delete();
            $context->assessmentQuestions()->delete();
            ModuleQuestion::whereIn('id', $questionIds)->delete();
            
            /*
            $context->load('questions')->toArray();

            $existingModuleAssessmentKeyVal = $context->questions->mapToAssoc(function($assessment) {
                return [$assessment['id'], $assessment['module_question_id']];    
            });
            $moduleAssessmentQuestionIds = $context->questions->pluck('module_question_id');
            */

            // The following string replace is required as the builder returns a null for a deleted choice.
            // This results in an empty choice field when rendered. The replace function removes the null choices.
            $fd = str_replace('null,','',$fd);
            $fd = str_replace(',null','',$fd);
            $fd = str_replace('[null]','[]',$fd);

            $formDataJson = json_decode($fd);

            // map each json model property to a ModuleQuestion object
            $idm = 0;
            $maQuestions = [];
            
            foreach($formDataJson->model as $control => $question) {
                // property correspondence json<->ModuleQuestion
                $dbModuleQuestion = $this->jsonToModuleQuestion($question);
                $dbModuleQuestion->save();
                $question->dbId = $dbModuleQuestion->id;

                // prepare ModuleAssessmentQuestion
                ModuleAssessmentQuestion::create([
                    'module_assessment_id' => $context->id,
                    'module_question_id' => $dbModuleQuestion->id,
                    'sequence' => $question->sortOrder,
                    'is_active' => true
                ]);

                if (property_exists($question, 'choices')) {
                    foreach($question->choices as $qc) {
                        //if($qc->dbId == false){
                            //new item added on form
                            // property correspondence json<->ModuleQuestionChoice
                            $dbModuleQuestionChoice = $this->jsonToModuleQuestionChoice($qc, $dbModuleQuestion->id);
                            $dbModuleQuestionChoice->save();
                            $qc->dbId = $dbModuleQuestionChoice->id; // save id of newly added
                        //} else {
                            // was existing, but is now deleted
                            //unset($question->choices[$idx]);
                        //}
                    }
                }
            }
            
            $context->data = json_encode($formDataJson);
            $employeeId = intval(optional(\Auth::user())->employee_id);
            $context->trainer_id = $employeeId;

            $context->save();

        } catch (Exception $exception) {
            dd($exception);
            $response['status'] = 'KO';
            $responseCode = 500;
        }

    }

    private function jsonToModuleQuestionAssoc($question){
        $toReturn = [];

        foreach ($question as $k => $v) {
            if (isset($this->jsonQuestionMap[$k])) {
                $toReturn[$this->jsonQuestionMap[$k]] = $v;
            }
        }

        // required for plugin compatibility
        // not present in json example, but submitted when using the form builder
        if(!property_exists($question, 'name') ) {
            $toReturn['name'] = $question->fbid;
        }
        
        $questionTypeMap = [
            'radio' => ModuleQuestionType::SingleChoice,
            'checkbox' => ModuleQuestionType::MultipleChoice,
            'textarea' => ModuleQuestionType::OpenText
        ];

        $toReturn['module_question_type_id'] = $questionTypeMap[$question->type];
        $toReturn['is_active'] = true;

        return $toReturn;
    }

    private function jsonToModuleQuestion($question) {

        $objQuestion = new ModuleQuestion();

        foreach ($question as $k => $v) {
            if (isset($this->jsonQuestionMap[$k])) {
                $objQuestion->setAttribute($this->jsonQuestionMap[$k], $v);
            }
        }

        // required for plugin compatibility
        // not present in json example, but submitted when using the form builder
        if(!property_exists($question, 'name') ) {
            $question->name = $question->fbid;
        }
        
        $questionTypeMap = [
            'radio' => ModuleQuestionType::SingleChoice,
            'checkbox' => ModuleQuestionType::MultipleChoice,
            'textarea' => ModuleQuestionType::OpenText
        ];

        $objQuestion->module_question_type_id  = $questionTypeMap[$question->type];
        $objQuestion->is_active = true;

        return $objQuestion;
    }

    private function jsonToModuleQuestionChoice($qc, $moduleQuestionId) {

        $toReturn = new ModuleQuestionChoice();

        foreach ($qc as $k => $v) {
            if (isset($this->jsonQuestionChoiceMap[$k])) {
                $toReturn->setAttribute($this->jsonQuestionChoiceMap[$k], $v);
            }
        }

        $toReturn->module_question_id = $moduleQuestionId;
        $toReturn->is_active = true;

        return $toReturn;
    }    
    
}