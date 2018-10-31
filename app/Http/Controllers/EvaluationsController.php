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
        $evaluations = $this->contextObj::filtered()->where('is_active',1)->paginate(10);
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
        $evaluations = $this->contextObj::filtered()->where('is_active',1)->paginate(10);
        //$this->contextObj::with('users.employee')->filtered()->paginate(10);
        return view($this->baseViewPath .'.instancesindex', compact('evaluations'));
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
            $overallscore =  ($workingscore/$assessmentTotalScores)*100;

            $assessor->overall_score = round($overallscore,0);
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
        return view($this->baseViewPath .'.assess-assessment', compact('employeeDetails', 'urlpath', 'usecontent', 'content','Id','EvaluationId','startDateTime'));
    }

    public function submitAssessment(Request $request,$Id,$EvaluationId){

        $messages = array();
        $errors= array();
        $uniquequestionids = array();
        $containsDuplicateQuestion = false;
        $html = "";

        //dd($Id);

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
            $evaluationDetails = $this->contextObj->findData($Id);

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
        //die;
        /*$evaluationAssessorObj = new EvaluationAssessor();
        $evaluationAssessorObj->Id = $Id;
        $evaluationAssessorObj->Comments = $request['Comments'];
        $evaluationAssessorObj->Summary = $request['Summary'];
        $evaluationAssessorObj->Completed = true;
        $evaluationAssessorObj->StartTime = $startdatetime;
        $evaluationAssessorObj->EndTime = $enddatetime;

        $evaluationAssessorObj = EvaluationAssessor::patch($Id,$evaluationAssessorObj);*/

        $evaluationDetails->assessors()->sync([$assessorEmployeeId => [
            'comments' => $request['Comments'],
            'summary' => $request['Summary'],
            'start_time' => $startdatetime,
            'end_time' => $enddatetime,
            'is_completed' => 1,
        ]]);

        return Redirect::to('instances');

    }
}