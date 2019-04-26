<?php

namespace App\Http\Controllers;

use App\Assessment;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\AssessmentCategory;
use Exception;
use App\SystemSubModule;
use App\Support\Helper;

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
    public function index(Request $request)
    {
        $name = $request->get('name', null);
        $description = $request->get('description', null);

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_ASSESSMENTS);

        if(!empty($name)){
            $request->merge(['name' => '%'.$name.'%']);
        }
        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $assessments = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page') && $assessments->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('assessments','allowedActions'));
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

        $assessmentcategories = AssessmentCategory::pluck('name', 'id');
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

            //dump(count($data->evaluationResultsEvaluations()->get()));die;
            //dump($data::with('evaluationResultsEvaluations')->where('id',1)->get());die;
        }
        $assessmentcategories = AssessmentCategory::pluck('name', 'id');
        $assessmentaAssessmentCategories = $data->assessmentAssessmentCategory()->pluck('name', 'assessments_assessment_category.assessment_category_id');

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

    public function duplicates(Request $request)
    {
        $categoryids = $request->AssessmentCateoryIds;
        $questions = [];

        if(isset($categoryids) && is_array($categoryids))
        {
            $categoriesobj = AssessmentCategory::with('assessmentCategoryCategoryQuestions')
                ->whereIn('id',$categoryids)
                ->get()->all();

            if ($categoriesobj!=null) {
                foreach ($categoriesobj as $categoryItem) {
                    if ($categoryItem)
                    {
                        foreach ($categoryItem['assessmentCategoryCategoryQuestions'] as $question) {
                            if (!array_key_exists($question->id, $questions)) {
                                $questions[$question->id] = new \stdClass();
                                $questions[$question->id]->categories[] = $categoryItem->name;
                                $questions[$question->id]->title = $question->title;
                            }
                            else{
                                $questions[$question->id]->categories[] = $categoryItem->name;
                            }
                        }
                    }
                }
            }
        }

        $hasDuplicates = false;
        if(!empty($questions))
        {
            foreach ($questions as $key => $value) {
                if(count($value->categories) == 1){
                    unset($questions[$key]);
                }
                else{
                    $hasDuplicates = true;
                }
            }
        }
        return response()->json(['success' => true,'duplicates' => $hasDuplicates,'questions' => $questions], 200);
    }

    public function cloneForm(Request $request){

        try {
            $id = Route::current()->parameter('assessment');
            $assessment = $this->contextObj->findData($id);

            $assessmentCategories = $assessment->assessmentAssessmentCategory()->get()->all();

            if ($request->ajax()) {
                $view = view('assessments.clone', compact('assessment', 'assessmentCategories'))->renderSections();
                return response()->json([
                    'title' => $view['modalTitle'],
                    'content' => $view['modalContent'],
                    'footer' => $view['modalFooter'],
                    'url' => $view['postModalUrl']
                ]);
            }

            return view('assessments.clone', compact('assessment', 'assessmentCategories'));
        }catch(Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function clone(Request $request, $id){
        try {
            $input = array_except($request->all(),array('_token','_method'));
            $assessments_assessment_category_pivot = [];
            $assessment_category_category_question_pivot = [];
            $last_id_assessment = null;

            $assessment = $this->contextObj->findData($id);
            $assessmentCategories = $assessment->assessmentAssessmentCategory()->with('assessmentCategoryCategoryQuestions')->get()->toArray();
            $clone_assessment = $assessment->toArray();

            if(!empty($input)) {
                if (!empty($clone_assessment)) {
                    $clone_assessment['name'] = $input['assessment'];
                    unset($clone_assessment['id']);
                    $last_id_assessment = DB::table('assessments')->insertGetId($clone_assessment);
                }

                if (!empty($assessmentCategories)) {
                    foreach ($input['assessmentCategory'] as $key => $cloneAssessmentCategory){
                        $assessmentCategories[$key]['name'] = $cloneAssessmentCategory;
                        $assessmentCategoryCategoryQuestions = $assessmentCategories[$key]['assessment_category_category_questions'];
                        unset($assessmentCategories[$key]['id']);
                        unset($assessmentCategories[$key]['pivot']);
                        unset($assessmentCategories[$key]['assessment_category_category_questions']);

                        $last_id_assessment_category = DB::table('assessment_categories')->insertGetId($assessmentCategories[$key]);

                        $assessments_assessment_category_pivot[$key] = [
                            'assessment_id' => $last_id_assessment ,
                            'assessment_category_id' => $last_id_assessment_category
                        ];

                        foreach($assessmentCategoryCategoryQuestions as  $assessmentCategoryCategoryQuestion){
                            $assessment_category_category_question_pivot[] = [
                                'assessment_category_id' => $last_id_assessment_category,
                                'category_question_id' => $assessmentCategoryCategoryQuestion['id'] ,
                            ];
                        }
                    }
                }

                DB::table('assessments_assessment_category')->insert($assessments_assessment_category_pivot);
                DB::table('assessment_category_category_question')->insert($assessment_category_category_question_pivot);
            }

            \Session::put('success', 'Assessment was cloned Successfully!!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not clone assessment!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function preview(Request $request)
    {
        try {
            $html = "";
            $assessmentId = Route::current()->parameter('assessment');

            $assessment = Assessment::with('assessmentAssessmentCategory.assessmentCategoryCategoryQuestions')
                ->find($assessmentId);

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

                    $html .= "<div class=\"form-group \">";

                    $html .= "<div class=\"col - md - 12\" title=\"" . $categoryquestion->description . "\">" . "<label>" . $questionNo . " " . $categoryquestion->title . "</label>" . "<span class=\"pull-right\">" .  $categoryquestion->points . " Points</span></div>";

                    if ($categoryquestion->category_question_type_id == 1) {
                        $choicetext = '';
                        $html .= "<input class=\"form-control\" id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"text\" value=\"" . $choicetext . "\" readonly=\"readonly\" disabled=\"disabled\"> " . "" . "<br/>";
                    } else {
                        $counter = 0;
                        $html .= "<div class=\"input-group \">";

                        foreach ($categoryquestion->categoryQuestionChoices as $result) {
                            $selectedValue = $result->choice_text . "|" . $result->points;

                            if ($categoryquestion->category_question_type_id == 2) {
                                // Generate radio buttons
                                $html .= "<input id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"radio\" value=\"" . $selectedValue . "\" required  readonly=\"readonly\" disabled=\"disabled\"> " . $result->choice_text . "<br/>";
                            } else {
                                $html .= "<input id=\"" . "ID" . "\" name=\"" . $question_id . "\" type=\"checkbox\" value=\"" . $selectedValue . "\" required readonly=\"readonly\" disabled=\"disabled\"> " . $result->choice_text . "<br/>";
                            }
                            $counter = $counter + 1;
                        }
                        $html .= "</div>";
                    }
                    $html .= " </div>";
                }

                $html .= "</div>";
                $html .= "</div>"; // End of tag for panel
            }

            if ($request->ajax()) {
                $view = view('assessments.preview', compact('assessment', 'html'))->renderSections();
                return response()->json([
                    'title' => $view['modalTitle'],
                    'content' => $view['modalContent'],
                    'footer' => $view['modalFooter'],
                ]);
            }

            return view('assessments.preview', compact('assessment', 'html'));
        }catch(Exception $exception){
            dd($exception->getMessage());
        }
    }
    
}