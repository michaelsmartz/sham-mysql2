<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Language;
use App\Evaluation;
use App\Assessment;
use App\Department;
use App\ProductCategory;
//use App\EvaluationStatus;
use App\Enums\EvaluationStatusType;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Traits\MediaFiles;
use Exception;
use App\SystemSubModule;
use App\Support\Helper;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\View;
use Storage;

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
    public function index(Request $request)
    {
        $fullName = $request->get('name', null);
        $asssessmentname = $request->get('assessment:name', null);
        $referencesource = $request->get('reference_source', null);
        $department = $request->get('department:description', null);
        $referenceno = $request->get('reference_no', null);

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_EVALUATIONS);

        if( !isset(\Auth::user()->employee->id) || \Auth::user()->employee->id == ''){
            return view('not-allowed')
                ->with('title', 'Evaluations')
                ->with('warnings', array('You account is not associated with an employee.'));
        }

        if(!empty($fullName)){
            $request->merge(['name' => '%'.$fullName.'%']);
        }
        if(!empty($referencesource)){
            $request->merge(['reference_source' => '%'.$referencesource.'%']);
        }
        if(!empty($asssessmentname)){
            $request->merge(['assessment:name' => '%'.$asssessmentname.'%']);
        }
        if(!empty($department)){
            $request->merge(['department:description' => '%'.$department.'%']);
        }
        if(!empty($referenceno)){
            $request->merge(['reference_no' => '%'.$referenceno.'%']);
        }

        $evaluations = $this->contextObj::with('assessment','useremployee','department')->filtered()->where('is_active',1)
            ->where('createdby_employee_id',$employeeid = \Auth::user()->employee->id)
            ->orderBy('feedback_date', 'desc')
            ->paginate(10);

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('evaluations','allowedActions'));
    }

    public function create()
    {
        $assessments = Assessment::pluck('name','id')->all();
        $employees = Employee::pluck('full_name', 'id')->all();
        $departments = Department::pluck('description','id')->all();
        $productCategories = ProductCategory::pluck('description','id')->all();
        $languages = Language::pluck('description','id')->all();
        //$evaluationStatuses = EvaluationStatus::pluck('description','id')->all();
        $evaluationStatuses = EvaluationStatusType::ddList();
        $feedbackdate = \Carbon\Carbon::now()->toDateString();

        return view($this->baseViewPath . '.create', compact('data','assessments','employees','departments','productCategories','languages','evaluationStatuses','feedbackdate'));
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
            //selectedemployee linemanager
            //dump($request->all());die;
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
                //$input['url_path'] = $input['UrlPath'];
            }

            elseif($input['status'] == 'chatsaudio')
            {
                $input['is_usecontent'] = 2;
                $input['url_path'] = $input['filename'];
            }

            $input['evaluation_status_id'] = '1';

            $context = $this->contextObj->addData($input);
            $this->attachSingleFile($request, $context->id,'attachment');

            if($selectedassessors == null){
                $selectedassessors = array();
            }

            // Assign login user and selected employee as assessor
            if($request->has('selectedemployee'))
            {
                //user_employee_id
                if (!in_array($input['user_employee_id'], $selectedassessors))
                {
                    $selectedassessors[] = $input['user_employee_id'];
                }
                if ($employeeid != null && !in_array($employeeid, $selectedassessors))
                {
                    $selectedassessors[] = $employeeid;
                }
            }
            //dump($selectedassessors);
            //die;
            if($request->has('linemanager'))
            {
                $linemanagerid = \Auth::user()->employee->line_manager_id;
                if ($linemanagerid != null && !in_array($linemanagerid, $selectedassessors))
                {
                    $selectedassessors[] = $linemanagerid;
                }
            }

            $context->assessors()
                ->attach($selectedassessors); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            dump($exception->getMessage());
            die;
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        $triggerid = 0;
        if ($employeeid != null && in_array($employeeid, $selectedassessors))
        {
            $triggerid = $employeeid;
        }

        return redirect()->route($this->baseViewPath .'.index')
                    ->with([ 'EvaluationId' => $context->id, 'EvaluationAssessorId' => $triggerid]);
    }

    public function edit(Request $request)
    {

        $data = null;
        $_mode = 'edit';
        $fullPageEdit = true;
        $id = Route::current()->parameter('evaluation');


        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
        }

        $assessments = Assessment::pluck('name','id')->all();
        $employees = Employee::pluck('full_name', 'id')->all();
        $departments = Department::pluck('description','id')->all();
        $productCategories = ProductCategory::pluck('description','id')->all();
        $languages = Language::pluck('description','id')->all();
        //$evaluationStatuses = EvaluationStatus::pluck('description','id')->all();
        $evaluationStatuses = EvaluationStatusType::ddList();
        $selectecAssessors = $data->assessors()->pluck('full_name','employee_evaluation.employee_id');

        return view($this->baseViewPath .'.edit',
            compact('_mode','fullPageEdit','data','assessments','employees','departments','productCategories','languages','evaluationStatuses','selectecAssessors'));
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
            //$this->validator($request);
            
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));

            $selectedassessors = array_get($request->all(),'selectedassessors');
            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

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
                //$input['url_path'] = $input['UrlPath'];
            }
            elseif($input['status'] == 'chatsaudio')
            {
                $input['is_usecontent'] = 2;
                $input['url_path'] = $input['filename'];
            }

            unset($input['status']);
            unset($input['q']);
            unset($input['selectedassessors']);

            $inputtosubmit = $input;
            unset($inputtosubmit['attachment']);

            $context = $this->contextObj->updateData($id, $inputtosubmit);

            $data = Evaluation::find($id);

            if(Input::hasFile('attachment')) {
                $this->syncSingleFile($request, $data->id,'attachment');
            }

            $data->assessors()->sync($selectedassessors);

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

    public function showinstances(Request $request)
    {
        $fullName = $request->get('name', null);
        $asssessmentname = $request->get('assessment:name', null);
        $referencesource = $request->get('reference_source', null);
        $department = $request->get('department:description', null);
        $referenceno = $request->get('reference_no', null);

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_QA_INSTANCES);

        if( !isset(\Auth::user()->employee->id) || \Auth::user()->employee->id == ''){
            return view('not-allowed')
                ->with('title', 'Instances')
                ->with('warnings', array('You account is not associated with an employee.'));
        }

        if(!empty($fullName)){
            $request->merge(['name' => '%'.$fullName.'%']);
        }
        if(!empty($referencesource)){
            $request->merge(['reference_source' => '%'.$referencesource.'%']);
        }
        if(!empty($asssessmentname)){
            $request->merge(['assessment:name' => '%'.$asssessmentname.'%']);
        }
        if(!empty($department)){
            $request->merge(['department:description' => '%'.$department.'%']);
        }
        if(!empty($referenceno)){
            $request->merge(['reference_no' => '%'.$referenceno.'%']);
        }

        $employeeid = \Auth::user()->employee->id;
        //$employeeid  = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $evaluations = $this->contextObj::with('assessment','useremployee','department')->filtered()->where('is_active',1)
                     ->orderBy('feedback_date', 'desc')
                     ->whereHas('assessors', function($q) use($employeeid){
                        $q->where('employee_id',$employeeid);
                    })
                    ->paginate(10);

        //resend the previous search data
        session()->flashInput($request->input());

        //$this->contextObj::with('users.employee')->filtered()->paginate(10);
        // Assessment::with('assessmentAssessmentCategory.assessmentCategoryCategoryQuestions')
        return view($this->baseViewPath .'.instancesindex', compact('evaluations','allowedActions'));
    }

    public function downloadScorePdf(Request $request,$id,$name)
    {
        $evaluations = $this->contextObj::with('assessment','useremployee','department')
            ->where('id', $id)->get()->first();

        // Gettting Header details to display on form
        $HeaderDetails = [];
        if ($evaluations!=null) {
            $HeaderDetails['user'] = $evaluations->useremployee->first_name.' '.$evaluations->useremployee->surname;
            $HeaderDetails['department'] = $evaluations->department->description;
            $HeaderDetails['feedbackdate'] =  date('Y-m-d', strtotime($evaluations->feedback_date));;
            $HeaderDetails['referenceno'] = $evaluations->reference_no;
            $HeaderDetails['referencesource'] = $evaluations->reference_source;
            $HeaderDetails['assessment'] = $evaluations->assessment->name;
        }

        $htmnode = Input::get('htmlnode','');
        $htmlnodescore = Input::get('htmlnodeScore','');
        $data =array(
            'htmlnode' => $htmnode,
            'htmlnodescore' => $htmlnodescore,
            'HeaderDetails' => $HeaderDetails,
            'assessorname' => $name,
        );

        $pdf = PDF::loadView('evaluations.print-scores', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('Scores.pdf');
    }


    public function downloadQuestionairePdf(Request $request,$id,$evaluationId,$assessorId)
    {
        $assessorName = "";
        $assessordetails = Employee::select(['first_name','surname'])->where("id",$assessorId)->get()->first();

        if ($assessordetails!=null) {
            $assessorName = $assessordetails->surname .' '. $assessordetails->first_name;
        }

        $evaluations = $this->contextObj::with('assessment','useremployee','department')
            ->where('id', $evaluationId)->get()->first();

        // Gettting Header details to display on form
        $HeaderDetails = [];
        if ($evaluations!=null) {
            $HeaderDetails['user'] = $evaluations->useremployee->first_name.' '.$evaluations->useremployee->surname;
            $HeaderDetails['department'] = $evaluations->department->description;
            $HeaderDetails['feedbackdate'] =  date('Y-m-d', strtotime($evaluations->feedback_date));;
            $HeaderDetails['referenceno'] = $evaluations->reference_no;
            $HeaderDetails['referencesource'] = $evaluations->reference_source;
            $HeaderDetails['assessment'] = $evaluations->assessment->name;
        }

        $htmnode = Input::get('htmlnode','');
        $htmlnodescore = Input::get('htmlnodeScore','');
        $data =array(
            'htmlnode' => $htmnode,
            'htmlnodescore' => $htmlnodescore,
            'HeaderDetails' =>$HeaderDetails,
            'assessorname' => $assessorName,
        );

        $pdf = PDF::loadView('evaluations.print-questionaire', $data)
            ->setPaper('a4', 'portrait');
        return $pdf->download('Questionaire.pdf');
    }


    public function attachment(Request $request, $Id)
    {
        $data = null;
        $evaluationDetails = $this->contextObj->findData($Id);

        $assessmentTotalScores = $this->getAssessmentTotalScore($evaluationDetails->assessment_id);

        $assessors = $evaluationDetails->assessors;
        foreach($assessors as $assessor){
            $workingscore = $evaluationDetails->evaluationResults->where('assessor_employee_id',$assessor->employee_id)->where('is_active',1)
                            ->sum('pivot.points');

            if($assessmentTotalScores > 0){
                $overallscore =  ($workingscore/$assessmentTotalScores)*100;
                $assessor->overall_score = round($overallscore,0);
            }
            else{
                $assessor->overall_score = "";
            }

        }

        //https://laravel.io/forum/06-23-2014-eager-loading-with-multiple-relations
        return view('partials.evaluationinstances', compact('evaluationDetails'));
    }

    private function getAssessmentTotalScore($assessmentid)
    {
        $assessment = Assessment::find($assessmentid);
        $totalscores = $assessment->assessmentAssessmentCategory->where('is_active',1)
                        ->sum('threshold');
        return $totalscores;
    }

    public function loadAssessment(Request $request,$Id,$EvaluationId){

        $evaluationDetails = $this->contextObj->findData($EvaluationId);

        $assessment = Assessment::with('assessmentAssessmentCategory.assessmentCategoryCategoryQuestions')
            ->find($evaluationDetails->assessment_id);

        $employeeDetails =   $evaluationDetails->useremployee->full_name;
        $urlpath = $evaluationDetails->url_path;
        $usecontent = $evaluationDetails->is_usecontent;
        $assessmentid = $evaluationDetails->assessment_id;
        $content = '';
        $html = "";
        $questionNo = 0;
        $startDateTime = date('Y-m-d H:i:s');

        foreach($assessment->assessmentAssessmentCategory as $assessmetCategory)
        {
            $html .= "<div class = \"panel panel-default\">";
            $html .= "<div class =\"panel-heading\">".$assessmetCategory->name."</div>";
            $html .= "<div class = \"panel-body\">";

            foreach($assessmetCategory->assessmentCategoryCategoryQuestions as $categoryquestion){

                $questionNo++;
                $questionbase = "question_id[".$categoryquestion->id."]";
                $question_id = $questionbase."[Response][]";
                $question_type = "";

                $html.="<div class=\"form-group \">";
                $html.="<div class=\"col - md - 12\" title=\"".$categoryquestion->description."\">"."<label class=\"required\">".$questionNo." ".$categoryquestion->title."</label>"."<span class=\"pull-right\">".$categoryquestion->points." Points</span></div>";

                //Generate Text imput type
                if($categoryquestion->category_question_type_id == 1)
                {
                    $html.= "<input class=\"form-control\" id=\""."ID"."\" name=\"".$question_id."\" type=\"text\" value=\"".""."\"> ".""."<br/>";
                    $question_type = "Open Text";
                }
                else
                {
                        $counter = 0;
                        $html.= "<div class=\"input-group \">";

                        foreach($categoryquestion->categoryQuestionChoices as $choice)
                        {
                            $selectedValue = $choice->choice_text."|".$choice->points;
                            if($categoryquestion->category_question_type_id == 2)
                            {
                                // Generate radio buttons
                                $html.= "<input id=\""."ID"."\" name=\"".$question_id."\" type=\"radio\" value=\"".$selectedValue."\" class=\"required exclude-required-marker\" > ".$choice->choice_text."<br/>";
                                //$html.= "<input id=\""."ID"."\" name=\"".$question_id."\" type=\"radio\" value=\"".$selectedValue."\" required > ".$result->ChoiceText;
                                $question_type = "Select One";
                            }
                            else
                            {
                                // Generate Checkboxes
                                $html.= "<input id=\""."ID"."\" name=\"".$question_id."\" type=\"checkbox\" value=\"".$selectedValue."\" class=\"required exclude-required-marker\" > ".$choice->choice_text."<br/>";
                                $question_type = "Select Many";
                            }
                            $counter = $counter + 1;
                        }
                        $html.= "</div>";
                }

                // Popoulate hidden fields to pass on values on postback
                $html.= "<div class=\"hide\">";
                $html.= "<input id=\""."ID"."\" name=\"".$questionbase."[EvaluationId]"."\" type=\"hidden\" value=\"".$EvaluationId."\"> ".""."<br/>";
                $html.= "<input id=\""."ID"."\" name=\"".$questionbase."[AssessmentId]"."\" type=\"hidden\" value=\"".$assessmentid."\"> ".""."<br/>";
                $html.= "<input id=\""."ID"."\" name=\"".$questionbase."[AssessmentCategoryId]"."\" type=\"hidden\" value=\"".$assessmetCategory->id."\"> ".""."<br/>";
                $html.= "<input id=\""."ID"."\" name=\"".$questionbase."[QuestionType]"."\" type=\"hidden\" value=\"".$question_type."\"> ".""."<br/>";
                $html.= "</div>";
                $html.= " </div>";
            }

            $html .= "</div>";
            $html .= "</div>"; // End of tag for panel
        }

        // Popoulate hidden fields to pass on values on postback
        $html.= "<div class=\"hide\">";
        $html.= "<input id=\""."ID"."\" name=\"EvaluationidTop\" type=\"hidden\" value=\"".$EvaluationId."\"> ".""."<br/>";
        $html.= "<input id=\""."ID"."\" name=\"AssessmentIdTop\" type=\"hidden\" value=\"".$assessmentid."\"> ".""."<br/>";
        $html.= "</div>";

        $content = $html;
        $medias = $evaluationDetails->media()->orderBy('id', 'desc')->get();
        $mediaid = "";

        if(count($medias) > 0){
            $mediaid = $medias[0]->id;
        }

        $audio = '';
        if($evaluationDetails->is_usecontent == 2){
            $request->request->add(['file' => $evaluationDetails->url_path]);
            $audio = $this->getaudio($request);
        }

        //dump($mediaid);die;
        return view($this->baseViewPath .'.assess-assessment', compact('employeeDetails', 'urlpath', 'usecontent', 'content', 'audio', 'Id','EvaluationId','startDateTime','mediaid'));
    }

    public function submitAssessment(Request $request,$Id,$EvaluationId){

        $messages = array();
        $errors= array();
        $uniquequestionids = array();
        $containsDuplicateQuestion = false;
        $html = "";

        //dump($Id);
        //dd($EvaluationId);

        //return $request->all();

        $evaluationid = $request['EvaluationidTop'];
        $assessmentid = $request['AssessmentIdTop'];
        $startdatetime = $request['starttime'];
        //$enddatetime = $request['endtime'];
        $enddatetime = date('Y-m-d H:i:s');

        //dd(\Auth::user());
        $assessorEmployeeId = \Auth::user()->employee->id;
        //die;

        foreach ($request['question_id'] as $questionID => $answerArray)
        {
            //$evaluationresultObj = new EvaluationResult();
            $evaluationDetails = $this->contextObj->findData($EvaluationId);

            if (array_key_exists("QuestionType", $answerArray))
            {
                // Open Text question will pickvalue from a textbox and store value in array Response at position 0 only
                if($answerArray["QuestionType"]=="Open Text" && !empty($answerArray["Response"]))
                {
                    $evaluationDetails->evaluationResults()->attach($assessorEmployeeId,[
                        'assessment_id'=> $answerArray["AssessmentId"],
                        'assessment_category_id' => $answerArray["AssessmentCategoryId"],
                        'category_question_id' => $questionID,
                        'content' => $answerArray["Response"][0],
                        'points' => 0,
                        'is_active' => 1
                    ]);
                }
                else
                {
                    // Pickvalue from Radio Button and Checboxes and store value in array Response.
                    // Response array will store value in format e.g "Response":["Blue|20","Red|10"] where
                    // Blue is the Selected Value and 20 is the selected value Points.
                    // Implementaion below first Loop on array Response, Split on Pipe(|),Define Selected Value and Point,
                    // and insert into EvaluationResults table.
                    $responses = $answerArray["Response"];
                    if(!empty($responses))
                    {
                        foreach ($responses as $response)
                        {
                            if($response)
                            {
                                $splitterposition = strripos($response,"|");
                                $responselength = strlen($response);
                                $selectedValue = substr($response, 0, $splitterposition);
                                $points = substr($response, $splitterposition+1);

                                $evaluationDetails->evaluationResults()->attach($assessorEmployeeId,[
                                    'assessment_id'=> $answerArray["AssessmentId"],
                                    'assessment_category_id' => $answerArray["AssessmentCategoryId"],
                                    'category_question_id' => $questionID,
                                    'content' => $selectedValue,
                                    'points' => $points,
                                    'is_active' => 1
                                ]);
                            }
                        }
                    }
                }
            }
        }

        $evaluationDetails->assessors()->sync([$assessorEmployeeId => [
            'comments' => $request['Comments'],
            'summary' => $request['Summary'],
            'start_time' => $startdatetime,
            'end_time' => $enddatetime,
            'is_completed' => 1,
        ]],false);

        $employee_evaluations = $evaluationDetails->assessors()->where('evaluation_id',$EvaluationId)->get()->all();

        if ($employee_evaluations !=null && !empty($employee_evaluations)) {
            $closed = true;
            foreach ($employee_evaluations as $result)
            {
                if($result->is_completed == false)
                {
                    $closed = false;
                }
            }
            if($closed)
            {
                $this->contextObj::where('id',$evaluationid)
                    ->update(['evaluation_status_id'=>EvaluationStatusType::CLOSED]);
            }
        }
        return Redirect::to('instances')->with('Id', $Id)->with('EvaluationId',$EvaluationId);
    }

    public function scoreCompletedEvaluation($Id,$evaluationid)
    {
        $evaluations = $this->contextObj::where('id',$evaluationid)->first();

        $summary = $evaluations->assessors->where('id',$Id)->first()->pivot->summary.PHP_EOL;
        $comments = $evaluations->assessors->where('id',$Id)->first()->pivot->comments.PHP_EOL;
        $assessorName = $evaluations->assessors->where('id',$Id)->first()->full_name;

        $assessor_employee_id = $evaluations->assessors->where('id',$Id)->first()->employee_id;
        $assessmentTotalScores = $this->getAssessmentTotalScore($evaluations->assessment_id);
        $workingscore = $evaluations->evaluationResults->where('assessor_employee_id',$assessor_employee_id)->where('is_active',1)
            ->sum('pivot.points');

        $overallscore =  ($workingscore/$assessmentTotalScores)*100;
        $assessmentScore = round($overallscore,0);

        $hearderdetails = array();
        $hearderdetails['user'] = $evaluations->useremployee->full_name;
        $hearderdetails['department'] = $evaluations->department->description;
        $hearderdetails['feedbackdate'] = $evaluations->feedback_date;
        $hearderdetails['referenceno'] = $evaluations->reference_no;
        $hearderdetails['referencesource'] = $evaluations->source;
        $hearderdetails['assessment'] = $evaluations->assessment->name;

        $assessmentdetails = array();
        $assessment = Assessment::with('assessmentAssessmentCategory.assessmentCategoryCategoryQuestions')
            ->find($evaluations->assessment_id);

        $totalThreshhold = 0;
        foreach($assessment->assessmentAssessmentCategory as $assessmetCategory)
        {
            //threshold
            $categoryinfodetails = array();
            $categoryinfodetails["Id"]= $assessmetCategory->id;
            $categoryinfodetails["Name"]= $assessmetCategory->name;
            $categoryinfodetails["Threshold"]= $assessmetCategory->threshold;

            $cateogoryscore = $evaluations->evaluationResults->where('assessor_employee_id',$assessor_employee_id)
                ->where('assessment_category_id',$assessmetCategory->id)
                ->where('is_active',1)
                ->sum('pivot.points');

            $categoryinfodetails["TotalScores"]= $cateogoryscore;
            $assessmentdetails[]  = $categoryinfodetails;
        }

        // Working
        $mandatoryPassQuestionsids = array();
        $mandatoryPassQuestionsScore = 0;
        foreach($assessment->assessmentAssessmentCategory as $assessmentcategory)
        {
            foreach($assessmentcategory->assessmentCategoryCategoryQuestions as $categoryQuestion)
            {
                if($categoryQuestion->is_zeromark){
                    $mandatoryPassQuestionsids[] = $categoryQuestion->id;
                    $mandatoryPassQuestionsScore = $mandatoryPassQuestionsScore + $categoryQuestion->points;
                }
            }
        }

        $mandatoryPassQuestionsactualScore = $evaluations->evaluationResults->where('assessor_employee_id',$assessor_employee_id)
            ->where('is_active',1)
            ->whereIn('category_question_id',$mandatoryPassQuestionsids)
            ->sum('pivot.points');

        $mandatoryPassQuestionsComment = 0;
        if(count($mandatoryPassQuestionsids)> 0)
        {
            if($mandatoryPassQuestionsactualScore == $mandatoryPassQuestionsScore){
                $mandatoryPassQuestionsComment = $assessmentScore;
            }
            else
            {
                $mandatoryPassQuestionsComment = 0;
            }
        }
        else
        {
            $mandatoryPassQuestionsComment = $assessmentScore;
        }

        return $view = view($this->baseViewPath .'.scores-instances-completed-evaluation')
            ->with('Summary',$summary)
            ->with('Comments',$comments)
            ->with('AssessorName',$assessorName)
            ->with('AssessmentScore',$assessmentScore)
            ->with('HeaderDetails',$hearderdetails)
            ->with('Evaluationid',$evaluationid)
            ->with('MandatoryQuestionComment',$mandatoryPassQuestionsComment)
            ->with('AssessmentDetails',$assessmentdetails);
    }

    public function score($Id,$evaluationid)
    {
        $evaluations = $this->contextObj::where('id',$evaluationid)->first();

        $summary = $evaluations->assessors->where('id',$Id)->first()->pivot->summary.PHP_EOL;
        $comments = $evaluations->assessors->where('id',$Id)->first()->pivot->comments.PHP_EOL;
        $assessorName = $evaluations->assessors->where('id',$Id)->first()->full_name;

        $assessor_employee_id = $evaluations->assessors->where('id',$Id)->first()->employee_id;
        $assessmentTotalScores = $this->getAssessmentTotalScore($evaluations->assessment_id);
        $workingscore = $evaluations->evaluationResults->where('assessor_employee_id',$assessor_employee_id)->where('is_active',1)
            ->sum('pivot.points');

        $overallscore =  ($workingscore/$assessmentTotalScores)*100;
        $assessmentScore = round($overallscore,0);

        $hearderdetails = array();
        $hearderdetails['user'] = $evaluations->useremployee->full_name;
        $hearderdetails['department'] = $evaluations->department->description;
        $hearderdetails['feedbackdate'] = $evaluations->feedback_date;
        $hearderdetails['referenceno'] = $evaluations->reference_no;
        $hearderdetails['referencesource'] = $evaluations->source;
        $hearderdetails['assessment'] = $evaluations->assessment->name;

        $assessmentdetails = array();
        $assessment = Assessment::with('assessmentAssessmentCategory.assessmentCategoryCategoryQuestions')
            ->find($evaluations->assessment_id);

        $totalThreshhold = 0;
        foreach($assessment->assessmentAssessmentCategory as $assessmetCategory)
        {
            //threshold
            $categoryinfodetails = array();
            $categoryinfodetails["Id"]= $assessmetCategory->id;
            $categoryinfodetails["Name"]= $assessmetCategory->name;
            $categoryinfodetails["Threshold"]= $assessmetCategory->threshold;

            $cateogoryscore = $evaluations->evaluationResults->where('assessor_employee_id',$assessor_employee_id)
                ->where('assessment_category_id',$assessmetCategory->id)
                ->where('is_active',1)
                ->sum('pivot.points');

            $categoryinfodetails["TotalScores"]= $cateogoryscore;
            $assessmentdetails[]  = $categoryinfodetails;
        }

        // Working
        $mandatoryPassQuestionsids = array();
        $mandatoryPassQuestionsScore = 0;
        foreach($assessment->assessmentAssessmentCategory as $assessmentcategory)
        {
            foreach($assessmentcategory->assessmentCategoryCategoryQuestions as $categoryQuestion)
            {
                if($categoryQuestion->is_zeromark){
                    $mandatoryPassQuestionsids[] = $categoryQuestion->id;
                    $mandatoryPassQuestionsScore = $mandatoryPassQuestionsScore + $categoryQuestion->points;
                }
            }
        }

        $mandatoryPassQuestionsactualScore = $evaluations->evaluationResults->where('assessor_employee_id',$assessor_employee_id)
            ->where('is_active',1)
            ->whereIn('category_question_id',$mandatoryPassQuestionsids)
            ->sum('pivot.points');

        $mandatoryPassQuestionsComment = 0;
        if(count($mandatoryPassQuestionsids)> 0)
        {
            if($mandatoryPassQuestionsactualScore == $mandatoryPassQuestionsScore){
                $mandatoryPassQuestionsComment = $assessmentScore;
            }
            else
            {
                $mandatoryPassQuestionsComment = 0;
            }
        }
        else
        {
            $mandatoryPassQuestionsComment = $assessmentScore;
        }

        return view($this->baseViewPath .'.scores-instances')
            ->with('Summary',$summary)
            ->with('Comments',$comments)
            ->with('AssessorName',$assessorName)
            ->with('AssessmentScore',$assessmentScore)
            ->with('HeaderDetails',$hearderdetails)
            ->with('Evaluationid',$evaluationid)
            ->with('MandatoryQuestionComment',$mandatoryPassQuestionsComment)
            ->with('AssessmentDetails',$assessmentdetails);
    }

    public function summary(Request $request,$Id,$EvaluationId,$assessorid)
    {
        $messages = array();
        $errors= array();
        $uniquequestionids = array();
        $containsDuplicateQuestion = false;
        $html = "";
        $mandatoryPassQuestions = array();
        $mandatoryPassQuestionsComment = 'NONE';

        $categoriesid = array();
        $questionsid = array();

        if ($request->isMethod('post'))
        {
            $evaluations = $this->contextObj::with('assessment','useremployee','department')
                ->where('id', $EvaluationId)->get()->first();

            // Gettting Header details to display on form
            $HeaderDetails = [];
            if ($evaluations!=null) {
                $HeaderDetails['user'] = $evaluations->useremployee->first_name.' '.$evaluations->useremployee->surname;
                $HeaderDetails['department'] = $evaluations->department->description;
                $HeaderDetails['feedbackdate'] =  date('Y-m-d', strtotime($evaluations->feedback_date));;
                $HeaderDetails['referenceno'] = $evaluations->reference_no;
                $HeaderDetails['referencesource'] = $evaluations->reference_source;
                $HeaderDetails['assessment'] = $evaluations->assessment->name;
            }

            $htmnode = Input::get('htmlnode','');
            $htmlnodescore = Input::get('htmlnodeScore','');
            $data =array(
                'htmlnode' => $htmnode,
                'htmlnodescore' => $htmlnodescore,
                'HeaderDetails' =>$HeaderDetails,
                'assessorname' => $assessorid,
            );

            $pdf = PDF::loadView('evaluations.print-questionaire', $data)
                ->setPaper('a4', 'portrait');
            return $pdf->download('Questionaire.pdf');
        } else {

            $evaluationObj = $this->contextObj::with('evaluationResults')->where('id', $EvaluationId)->first();

            $assessmentid = $evaluationObj->assessment_id;
            $qasample = $evaluationObj->qa_sample;
            $useremployeeId = $evaluationObj->user_employee_id;
            $useremployeeObj = $evaluationObj->useremployee;
            $evaluationStatusid = $evaluationObj->evaluation_status_id;
            $usecontent = $evaluationObj->is_usecontent;
            $urlpath = $evaluationObj->url_path;

            $assessment = Assessment::with('assessmentAssessmentCategory.assessmentCategoryCategoryQuestions')
                ->find($evaluationObj->assessment_id);

            $questionNo = 0;
            foreach ($assessment->assessmentAssessmentCategory as $assessmetCategory) {
                $html .= "<div class = \"panel panel-default\">";
                $html .= "<div class =\"panel-heading\">" . $assessmetCategory->name . "</div>";
                $html .= "<div class = \"panel-body\">";
                foreach ($assessmetCategory->assessmentCategoryCategoryQuestions as $categoryquestion) {

                    $questionNo++;
                    $questionid = $categoryquestion->id;

                    $questionbase = "question_id[" . $questionid . "]";
                    $question_id = $questionbase . "[Response][]";
                    $question_type = "";

                    $html .= "<div class=\"form-group \">";
                    $totalscores = $evaluationObj->evaluationResults->where('assessor_employee_id', $assessorid)
                        ->where('is_active', 1)
                        ->where('assessment_category_id', $assessmetCategory->id)
                        ->where('category_question_id', $categoryquestion->id)
                        ->sum('pivot.points');

                    $choices = $evaluationObj->evaluationResults->where('assessor_employee_id', $assessorid)
                        ->where('is_active', 1)
                        ->where('assessment_category_id', $assessmetCategory->id)
                        ->where('category_question_id', $categoryquestion->id);

                    $html .= "<div class=\"col - md - 12\" title=\"" . $categoryquestion->description . "\">" . "<label>" . $questionNo . " " . $categoryquestion->title . "</label>" . "<span class=\"pull-right\">" . $totalscores . '/' . $categoryquestion->points . " Points</span></div>";

                    if ($categoryquestion->category_question_type_id == 1) {
                        $choicetext = '';

                        if (count($choices->pluck('content')->toArray()) > 0) {
                            $choicetext = $choices->pluck('content')->toArray()[0];
                        }
                        $html .= "<input class=\"form-control\" id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"text\" value=\"" . $choicetext . "\"> " . "" . "<br/>";
                        $question_type = "Open Text";
                    } else {
                        //dump($categoryquestion->categoryQuestionChoices);
                        $counter = 0;
                        $html .= "<div class=\"input-group \">";

                        foreach ($categoryquestion->categoryQuestionChoices as $result) {
                            $selectedValue = $result->choice_text . "|" . $result->points;

                            if ($categoryquestion->category_question_type_id == 2) {

                                // Generate radio buttons
                                if (in_array($result->choice_text, $choices->pluck('content')->toArray())) {
                                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"radio\" checked=\"checked\"  value=\"" . $selectedValue . "\" required > " . $result->choice_text . "<br/>";
                                } else {
                                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"radio\" value=\"" . $selectedValue . "\" required > " . $result->choice_text . "<br/>";
                                }
                                $question_type = "Select One";
                            } else {
                                if (in_array($result->choice_text, $choices->pluck('content')->toArray())) {
                                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"checkbox\" checked=\"checked\" value=\"" . $selectedValue . "\" required > " . $result->choice_text . "<br/>";
                                } else {
                                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"checkbox\" value=\"" . $selectedValue . "\" required > " . $result->choice_text . "<br/>";
                                }
                                $question_type = "Select Many";
                            }
                            $counter = $counter + 1;
                        }
                        $html .= "</div>";
                    }

                    // Popoulate hidden fields to pass on values on postback
                    $html .= "<div class=\"hide\">";
                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $questionbase . "[EvaluationId]" . "\" type=\"hidden\" value=\"" . $EvaluationId . "\"> " . "" . "<br/>";
                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $questionbase . "[AssessmentId]" . "\" type=\"hidden\" value=\"" . $assessmentid . "\"> " . "" . "<br/>";
                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $questionbase . "[AssessmentCategoryId]" . "\" type=\"hidden\" value=\"" . $assessmetCategory->id . "\"> " . "" . "<br/>";
                    $html .= "<input id=\"" . "ID" . "\" name=\"" . $questionbase . "[QuestionType]" . "\" type=\"hidden\" value=\"" . $question_type . "\"> " . "" . "<br/>";
                    $html .= "</div>";
                    $html .= " </div>";
                }

                $html .= "</div>";
                $html .= "</div>"; // End of tag for panel
            }

            // Popoulate hidden fields to pass on values on postback
            $html .= "<div class=\"hide\">";
            $html .= "<input id=\"" . "ID" . "\" name=\"EvaluationidTop\" type=\"hidden\" value=\"" . $EvaluationId . "\"> " . "" . "<br/>";
            $html .= "<input id=\"" . "ID" . "\" name=\"AssessmentIdTop\" type=\"hidden\" value=\"" . $assessmentid . "\"> " . "" . "<br/>";
            $html .= "</div>";

            $data = "";
            $pathToFile = "";
            $qafilepresent = false;

            if (!empty($qasample)) {
                //$data = base64_decode($qasample);
                $qafilepresent = true;
            }

            $medias = $evaluationObj->media()->orderBy('id', 'desc')->get();
            $mediaid = "";

            if(count($medias) > 0){
                $mediaid = $medias[0]->id;
            }

            $audio = '';
            if($evaluationObj->is_usecontent == 2){
                $request->request->add(['file' => $evaluationObj->url_path]);
                $audio = $this->getaudio($request);
            }

            $evaluationid = $evaluationObj->assessors->where('id', $Id)->first()->evaluation_id;
            $assessorId = $evaluationObj->assessors->where('id', $Id)->first()->employee_id;
            $summary = $evaluationObj->assessors->where('id', $Id)->first()->pivot->summary . PHP_EOL;
            $comments = $evaluationObj->assessors->where('id', $Id)->first()->pivot->comments . PHP_EOL;
            $categoryid = "";
            $totalThreshhold = 0;
            $totalfinalScore = 0;
            $assessorName = $evaluationObj->assessors->where('id', $Id)->first()->full_name;

            $assessmentid = $evaluationObj->assessment_id;


            /****************************/
            $evaluations = $evaluationObj;
            $assessor_employee_id = $evaluations->assessors->where('id', $Id)->first()->employee_id;
            $assessmentTotalScores = $this->getAssessmentTotalScore($evaluations->assessment_id);
            $workingscore = $evaluations->evaluationResults->where('assessor_employee_id', $assessor_employee_id)->where('is_active', 1)
                ->sum('pivot.points');

            $overallscore = ($workingscore / $assessmentTotalScores) * 100;
            $assessmentScore = round($overallscore, 0);

            $hearderdetails = array();
            $hearderdetails['user'] = $evaluations->useremployee->full_name;
            $hearderdetails['department'] = $evaluations->department->description;
            $hearderdetails['feedbackdate'] = $evaluations->feedback_date;
            $hearderdetails['referenceno'] = $evaluations->reference_no;
            $hearderdetails['referencesource'] = $evaluations->source;
            $hearderdetails['assessment'] = $evaluations->assessment->name;

            $assessmentdetails = array();
            $assessment = Assessment::with('assessmentAssessmentCategory.assessmentCategoryCategoryQuestions')
                ->find($evaluations->assessment_id);

            $totalThreshhold = 0;
            foreach ($assessment->assessmentAssessmentCategory as $assessmetCategory) {
                //threshold
                $categoryinfodetails = array();
                $categoryinfodetails["Id"] = $assessmetCategory->id;
                $categoryinfodetails["Name"] = $assessmetCategory->name;
                $categoryinfodetails["Threshold"] = $assessmetCategory->threshold;

                $cateogoryscore = $evaluations->evaluationResults->where('assessor_employee_id', $assessor_employee_id)
                    ->where('assessment_category_id', $assessmetCategory->id)
                    ->where('is_active', 1)
                    ->sum('pivot.points');

                $categoryinfodetails["TotalScores"] = $cateogoryscore;
                $assessmentdetails[] = $categoryinfodetails;
            }

            // Working
            $mandatoryPassQuestionsids = array();
            $mandatoryPassQuestionsScore = 0;
            foreach ($assessment->assessmentAssessmentCategory as $assessmentcategory) {
                foreach ($assessmentcategory->assessmentCategoryCategoryQuestions as $categoryQuestion) {
                    if ($categoryQuestion->is_zeromark) {
                        $mandatoryPassQuestionsids[] = $categoryQuestion->id;
                        $mandatoryPassQuestionsScore = $mandatoryPassQuestionsScore + $categoryQuestion->points;
                    }
                }
            }

            $mandatoryPassQuestionsactualScore = $evaluations->evaluationResults->where('assessor_employee_id', $assessor_employee_id)
                ->where('is_active', 1)
                ->whereIn('category_question_id', $mandatoryPassQuestionsids)
                ->sum('pivot.points');

            $mandatoryPassQuestionsComment = 0;
            if (count($mandatoryPassQuestionsids) > 0) {
                if ($mandatoryPassQuestionsactualScore == $mandatoryPassQuestionsScore) {
                    $mandatoryPassQuestionsComment = $assessmentScore;
                } else {
                    $mandatoryPassQuestionsComment = 0;
                }
            } else {
                $mandatoryPassQuestionsComment = $assessmentScore;
            }

            //dd('done...');
            return view($this->baseViewPath . '.summary-instances')
                ->with('Content', $html)
                ->with('Id', $Id)
                ->with('EvaluationId', $EvaluationId)
                ->with('AssessorId', $assessorid)
                ->with('QaSample', $data)
                ->with('QaFilePresent', $qafilepresent)
                ->with('UseContent', $usecontent)
                ->with('UrlPath', $urlpath)
                ->with('summary', $summary)
                ->with('comments', $comments)
                ->with('evaluationstatusid', $evaluationStatusid)
                ->with('allowsave', 0)
                ->with('ContainsDuplicate', $containsDuplicateQuestion)
                ->with('EmployeeDetails', $useremployeeObj->Surname . " " . $useremployeeObj->FirstName)
                ->with('AssessorName', $assessorName)
                ->with('AssessmentScore', $assessmentScore)
                ->with('HeaderDetails', $hearderdetails)
                ->with('Evaluationid', $evaluationid)
                ->with('MandatoryQuestionComment', $mandatoryPassQuestionsComment)
                ->with('mediaid', $mediaid)
                ->with('audio', $audio)
                ->with('AssessmentDetails', $assessmentdetails);
        }
    }

    public function getaudio(Request $request)
    {

        app('debugbar')->disable();

        //https://laracasts.com/discuss/channels/requests/streaming-audio
        //https://stackoverflow.com/questions/45125656/convert-binary-to-file-using-php
        // Binary file Response

        $file = $request->get('file','');
        $parts = array();
        $calldate = "";
        $recordingfilename = "";

        $url =  env('CHAT_API','');
        $username = env('CHAT_USERNAME','');
        $password = env('CHAT_PASSWORD','');

        $url = $url.'CallRecordByFilename';

        if($file != ''){
            $parts = explode('/', $file);
        }

        if(sizeof($parts) > 0){
            $calldate = $parts[0];
            $recordingfilename = $parts[1];
        }

        $post = [
            "apiUsername"=> $username,
            "apiPassword" => $password,
            "callDate" => $calldate,
            "recordingFilename" => $recordingfilename,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);

        return ('data:audio/wav;base64,'.base64_encode($response));

    }

    public function getaudio1(Request $request)
    {
        $file = $request->get('file','');
        $parts = array();
        $calldate = "";
        $recordingfilename = "";

        $url =  env('CHAT_API','');
        $username = env('CHAT_USERNAME','');
        $password = env('CHAT_PASSWORD','');

        $url = $url.'CallRecordByFilename';

        if($file != ''){
            $parts = explode('/', $file);
        }

        if(sizeof($parts) > 0){
            $calldate = $parts[0];
            $recordingfilename = $parts[1];
        }

        $post = [
            "apiUsername"=> $username,
            "apiPassword" => $password,
            "callDate" => $calldate,
            "recordingFilename" => $recordingfilename,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);



        $stream = fopen('data://text/plain;base64,' . base64_encode($response),'r');
        $stat = fstat($stream);
        $size = $stat['size'];

        $type = "audio/wav";//Storage::mimeType('hi.wav');
        $start = 0;
        $length = $size;
        $status = 200;

        $headers = ['Content-Type' => $type, 'Content-Length' => $size, 'Accept-Ranges' => 'bytes'];

        /*
        return response()->stream(function() use ($stream)  {
            fpassthru($stream);
            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, $headers);
        */

        return response()->stream(
            function() use ($stream, $start, $length) {
                fseek($stream, $start, SEEK_SET);
                echo fread($stream, $length);
                fclose($stream);
            }, $status, $headers
        );

    }

    public function getaudiolist(Request $request)
    {
        $url =  env('CHAT_API','');
        $username = env('CHAT_USERNAME','');
        $password = env('CHAT_PASSWORD','');

        $url = $url.'CallRecords';
        $date = $request->get('date','');

        $post = [
            "apiUsername"=> $username,
            "apiPassword" => $password,
            "dateFrom" => $date.' 00:00:00',
            "dateTo" => $date.' 23:59:59',

        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);

        //var_dump(json_decode($response));die;

        // Load Audio file from controller
        //Start
        /*
        $jsondata = json_decode($response);
        foreach($jsondata as $item)
        {
            $user_id = $item->user_id;
            $item->audio = '';
            $date = explode(' ',$item->call_start_date)[0];
            $request->request->add(['file' => $date.'/'.$item->recording_filename]);
            $audio = $this->getaudio($request);
            $item->audio = $audio;
        }
        $response = json_encode($jsondata);
        */
        //end


        return response()->json($response);
    }
}