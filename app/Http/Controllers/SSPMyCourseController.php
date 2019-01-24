<?php

namespace App\Http\Controllers;

use App\Course;
use App\Employee;
use App\Enums\CourseParticipantStatusType;
use App\Http\Requests;
use App\Module;
use App\ModuleAssessment;
use App\ModuleAssessmentResponse;
use App\ModuleAssessmentResponseDetail;
use App\ModuleQuestion;
use App\ModuleQuestionChoice;
use App\Support\Helper;
use App\SystemSubModule;
use App\Topic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Plank\Mediable\Media;
use View;
use Redirect;
use Illuminate\Http\Request;
use Validator;
use Session;
use Log;


class SSPMyCourseController extends CustomController
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){
        $this->contextObj = new Course();
        $this->baseViewPath = 'selfservice-portal.e-learning';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $coursesAvailable = [];
        $warnings = [];

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_MY_COURSES);

        if ($allowedActions == null || !$allowedActions->contains('List')){
            return View('not-allowed')
                ->with('title', 'E-learning')
                ->with('warnings', array('You do not have permissions to access this page.'));
        }

        $id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        if ($id == 0) {
            $warnings[] = 'Please check whether your profile is associated to an employee!';
        }else{
            $coursesAvailable = $this->contextObj->with(['modules.topics','employees'])->where('is_public',1)->get()->all();

            foreach ($coursesAvailable as $index => $course) {
                if($course->modules->count() == 0){
                    unset($coursesAvailable[$index]);
                }

                $courseTopicsCount = 0;
                foreach ($course->modules as $cm) {
                    $courseTopicsCount += $cm->topics->count();
                }

                if($courseTopicsCount == 0) {
                    unset($coursesAvailable[$index]);
                }

                $course->enrolled = false;
                foreach ($course->employees as $participant) {
                    if ($participant->employee_id == $id) {
                        $course->enrolled = true;
                    }
                }
            }
        }

        // load the view and pass the coursesAvailable
        return View::make($this->baseViewPath .'.available', compact('coursesAvailable', 'warnings', 'allowedActions'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enrol(Request $request) {
        $course_id = $request->get('id');

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $course = $this->contextObj::find($course_id);

        $course_employee_pivot[] = [
            'course_id' => $course_id,
            'employee_id' => $employee_id,
            'courseparticipantstatus_id' => 1, //Just Enrolled
        ];

        $course->employees()->sync($course_employee_pivot);

        $courseModTopics = $this->contextObj::where('id',$course_id)->with(['modules.topics','employees'])->get()->first();

        $course_employee_module_topic_pivot = [];

        if($courseModTopics != null){
            $module_count = 0;
            foreach ($courseModTopics->modules as $module) {
                foreach ($module->topics as $topic) {
                    $course_employee_module_topic_pivot[$module_count] = [
                        'employee_id' => $employee_id,
                        'course_id' => $course_id,
                        'module_id' => $module->id,
                        'topic_id' => $topic->id,
                        'is_completed' => false
                    ];
                    $module_count++;
                }
            }

            $course->employeeProgress()->sync($course_employee_module_topic_pivot);

            return response()->json(['response' => 'OK']);
        }
    }

    /**
     * @return mixed
     */
    public function myCourses() {
        $myCourses = [];
        $courseParticipantStatus = [];

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $courses = $this->contextObj->with(['employees','modules.topics','employeeProgress'])
            ->whereHas('employees', function($query) use ($employee_id) {
                $query->where('employee_id',$employee_id);
            })
            ->get()->all();

        if($courses != null) {
            $courses_count = 0;
            foreach ($courses as $course) {
                $modules = [];
                $all_topics_count = 0;
                $topics_completed = 0;
                $modules_count = 0;
                foreach ($course->modules as $module) {
                    $all_topics_count += $module->topics->count();
                    $topics_count = 0;
                    $modules[$modules_count]['Id'] = $module->id;
                    $modules[$modules_count]['Description'] = $module->description;
                    if(!$module->topics->isEmpty()) {
                        foreach ($module->topics as $topic) {
                            $modules[$modules_count]['Topics'][$topics_count]['Id'] = $topic->id;
                            $modules[$modules_count]['Topics'][$topics_count]['Header'] = $topic->header;
                            $topics_count++;
                        }
                    }else{
                        unset($modules[$modules_count]);
                    }
                    $modules_count++;
                }

                foreach ($course->employeeProgress as $employeeProgress){
                    if($employeeProgress->employee_id == $employee_id) {
                        if ($employeeProgress->is_completed > 0) {
                            $topics_completed++;
                        }
                    }
                }

                foreach ($course->employees as $employee){
                    if($employee->employee_id == $employee_id){
                        $myCourses[$courses_count]['ProgressPercentage'] = ($topics_completed/$all_topics_count) * 100;

                        if ($employee->courseparticipantstatus_id == 2) {
                            if ($myCourses[$courses_count]['ProgressPercentage'] == 100) {
                                $myCourses[$courses_count]['ProgressPercentage'] = 90;
                            }
                        }
                        $course_participant_description = CourseParticipantStatusType::getDescription($employee->courseparticipantstatus_id);
                        $courseParticipantStatus['Id'] = $employee->courseparticipantstatus_id;
                        $courseParticipantStatus['Description'] = $course_participant_description;
                    }
                }

                //display course and modules that has topics
                if($topics_count > 0) {
                    $myCourses[$courses_count]['Id'] = $course->id;
                    $myCourses[$courses_count]['Description'] = $course->description;
                    $myCourses[$courses_count]['TopicsCount'] = $topics_count;
                    $myCourses[$courses_count]['TopicsCompleted'] = $topics_completed;
                    $myCourses[$courses_count]['Modules'] = $modules;
                    $myCourses[$courses_count]['CourseParticipantStatus'] = $courseParticipantStatus;
                    $courses_count++;
                }
            }
        }

        return View::make($this->baseViewPath .'.mycourse', compact('myCourses'));
    }

    /**
     * @param $course_id
     * @return mixed
     */
    public function renderTopic($course_id) {
        $topic = null;
        $assessmentData = null;
        $assessmentId = 0;
        $all_topics = [];
        $assessment_list = [];

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $course = $this->contextObj::with(['modules.topics','employees', 'employeeProgress'])
            ->whereHas('employees', function($query) use ($employee_id, $course_id) {
                $query->where('employee_id',$employee_id);
                $query->where('course_id',$course_id);
            })
//            ->whereHas('employeeProgress', function($query){
//                $query->where('is_completed',0);
//            })
            ->get()->first();

        if ($course != null) {
            $isFirst = true;
            $prev_module_id = 0;
            $all_topic_counter = 0;
            $all_topics_count = 0;

            foreach ($course->modules as $module) {
                $all_topics_count += $module->topics->count();
            }

            foreach ($course->modules as $module) {
                //count no of topics in modules
                $topics_count = $module->topics->count();
                $topics_counter = 0;
                //check if topics is not empty in modules i.e. present in pivot module_topic
                if ($topics_count != 0) {
                    // Detect a change in moduleid...
                    $current_module_id = $module->id;

                    $topics = $module->topics;

                    foreach ($topics as $topic) {
                        $topic_assessments = [];
                        $topic_assessments1 = [];

                        if (!$isFirst && $current_module_id != $prev_module_id) {
                            self::extractModuleAssessmentDetails($employee_id, $module->id, $assessment_list, $topic_assessments, $course_id);
                            $topic->assessments = $topic_assessments;
                        }


                        $topics_counter++;
                        //dump($topics_counter);
                        //dump($topics_count);

                        self::extractModuleAssessmentDetails($employee_id, $module->id, $assessment_list, $topic_assessments1, $course_id);

                        if ($topics_counter == $topics_count) {
                            // Check if module has assemment and get ModuleAssessmentId and AssessmentData
                            // This check is being done on last topic of courses.
                            $topic->assessments = $topic_assessments1;
                            $topic->LastTopic = true;
                        } else {
                            $topic->LastTopic = false;
                            $topic->assessments = $topic_assessments1;
                        }

                        $prev_module_id = $topic->pivot->module_id;
                        $isFirst = false;

                        // Add forward slash  before closing tag of img and source html tag.
                        // The missing forward slash was raising an error when invoking the simplexml_load_string method.

                        if (is_null($topic->data) || empty($topic->data) || $topic->data == "") {
                            $topic->data = "<section><p>No content to display.</p></section>";
                        }

                        $topic_data = preg_replace("/<img([^>]+)\>/is", "<img $1 />", $topic->data);
                        $topic_data = preg_replace("/<source([^>]+)\>/is", "<source $1 />", $topic_data);
                        $topic_data = preg_replace('/&nbsp/', '&amp;nbsp', $topic_data);
                        $topic_data = str_replace("fragment", " ", $topic_data);
                        $xml = simplexml_load_string("<main>" . $topic_data . "</main>");
                        $sections = [];

                        $sectioncount = count($xml);
                        $counter = 1;

                        //to prevent loop again on course_progress, making use of a counter
                        if ($all_topic_counter < $course->employeeProgress->count()) {
                            if (!$course->employeeProgress[$all_topic_counter]->is_completed) {
                                $displayText = self::getDisplayText($course_id, $topic->pivot->module_id, $topic->id);

                                foreach ($xml as $key=>$item) {
                                    //$item['data-last'] = "0";
                                    $item['data-state'] = "";
                                    $item['data-course'] = $course_id;
                                    $item['data-assessment'] = "false";
                                    $item['data-assessmentid'] = "";
                                    $item['data-topic'] = $topic->id;
                                    $item['data-module'] = $topic->pivot->module_id;
                                    //$item['data-audio-advance'] = "-1";
                                    //$item['data-audio-text'] = "";
                                    $item['class'] = "topicsection scrollable";
                                    $item['data-topichasassessment'] = "false";
                                    $item['data-islasttopic'] = $topic->LastTopic;
                                    $item['data-displaynavtext'] = $displayText;

                                    if ($topic->LastTopic && $counter == $sectioncount) {
                                        if (count($topic->assessments) > 0) {
                                            $item['data-lastslideofcourse'] = "0";
                                        } else {
                                            $item['data-lastslideofcourse'] = "1";
                                        }
                                    } else {
                                        $item['data-lastslideofcourse'] = "0";
                                    }

                                    if ($counter == $sectioncount) {
                                        $item['data-lastslideoftopic'] = "1";
                                        if (count($topic->assessments) > 0) {
                                            $item['data-topichasassessment'] = "true";
                                        } else {
                                            $item['data-topichasassessment'] = "false";
                                        }
                                    } else {
                                        $item['data-lastslideoftopic'] = "0";
                                        $item['data-topichasassessment'] = "false";
                                    }

                                    $innerSection = substr($item->asXML(), 8);
                                    $innerSection = substr($innerSection, 0, strlen($innerSection) - 10);
                                    $innerSection = str_replace("<section", "<div", $innerSection);
                                    $innerSection = str_replace("</section", "</div", $innerSection);
                                    $innerSection = "<section" . $innerSection . "</section>";
                                    $innerSection = str_replace('&amp;nbsp', '&nbsp', $innerSection);
                                    $sections[] = $innerSection;

                                    //$topic->sections[] = $item->asXML();
                                    $counter++;
                                }
                            }
                        }
                        $topic->sections = $sections;
                        $all_topic_counter++;
                    }
                    $all_topics[] = $topics;
                }
            }
        }

        // TODO: detect if this topic is an assessment

        $returnHTML = view($this->baseViewPath.'.partials.view-topic')
            ->with('topic', $topic)
            ->with('assessmentId',$assessmentId)
            ->with('courseId',$course_id)
            ->with('topics', $all_topics)
            //->with('assessmentlist',$assessment_list)
            ->render();

        // show the view and pass the Model to it
        return View::make($this->baseViewPath.'.myelearningtopicprototype')
            ->with('assessmentData', $assessmentData)
            ->with('assessmentId',$assessmentId)
            ->with('dyn', $returnHTML)
            ->with('topics', $all_topics)
            //->with('assessmentlist',$assessmentlist)
            ->with('courseId',$course_id);
    }

    /**
     * @param $employee_id
     * @param $module_id
     * @param $assessment_list
     * @param $topic_assessments
     * @param $course_id
     * @return mixed
     */
    function extractModuleAssessmentDetails($employee_id, $module_id, &$assessment_list, &$topic_assessments,$course_id)
    {
        $module_assessments = ModuleAssessment::where('module_id',$module_id)->get()->all();
        if ($module_assessments != null) {
            if (is_array($module_assessments) && sizeof($module_assessments) > 0) {
                foreach ($module_assessments as $module_assessment) {
                    $assessmentId = $module_assessment->id;
                    $data =  $module_assessment->data;
                    $assessment_list[$assessmentId] = $data;

                    $moduleAssessmentResp = ModuleAssessmentResponse::where('module_assessment_id',$assessmentId)
                        ->where('employee_id',$employee_id)
                        ->where('course_id',$course_id)
                        ->get()->all();

                    //dd($moduleAssessmentResp);

                    if(empty($moduleAssessmentResp))
                    {
                        $topic_assessments[$assessmentId] = true;
                    }
                    else
                    {
                        $topic_assessments[$assessmentId] = false;
                    }
                }
            }
        }
        //dd($topic_assessments);
        return $topic_assessments;
    }

    /**
     * @param Request $request
     * @param $assessmentid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssessmentData(Request $request,$assessmentid)
    {
        $moduleAssessmentData = ModuleAssessment::select(['id','data'])
            ->where('id',$assessmentid)->get()->first();

        $retValue  = "";

        if ($moduleAssessmentData!=null) {
            $retValue = $moduleAssessmentData->data;
        }

        return response()->json($retValue);
    }

    /**
     * @param Request $request
     * @param $courseId
     * @param $assessmentId
     * @param $status
     * @return mixed
     */
    public function manageAssessment(Request $request, $courseId, $assessmentId, $status) {
        $assessmentObj = ModuleAssessment::find($assessmentId);
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        //dd($assessmentObj);

        if ($request->isMethod('post')) {

            try {

                $formArr = Input::all();
                // remove the token; not needed for processing below
                unset($formArr['_token']);

                $obj = new ModuleAssessmentResponse();
                $input = [
                    'module_id' => $assessmentObj->module_id,
                    'employee_id' => $employee_id,
                    'date_completed' => Carbon::now()->toDateString(),
                    'is_reviewed' => false,
                    'module_assessment_id' => $assessmentObj->id,
                    'course_id' => $courseId
                ];

                $obj = $obj->addData($input);

                foreach ($formArr as $k => $value) {
                    $arrChoice = explode('-', $k);
                    if (is_array($value)) {
                        //choices radio or checkbox
                        foreach ($value as $choiceKey => $label) {
                            //echo $choiceKey, ' ',$label, '<br>';
                            $objQnChoice = ModuleQuestionChoice::find($choiceKey);
                            $this->processResponseDetail($assessmentObj->module_id, $obj->id, $objQnChoice, $label, $assessmentObj->id, $arrChoice[2], $arrChoice[1], $arrChoice[0]);
                        }

                    } else {
                        // textarea or text
                        $objQn = ModuleQuestion::find($arrChoice[1]);
                        // make a virtual property ModuleQuestionId to use the same method
                        $objQn->module_question_type_id = $objQn->id;
                        $this->processResponseDetail($assessmentObj->module_id, $obj->id, $objQn, $value, $assessmentObj->id, $arrChoice[2], $arrChoice[1], $arrChoice[0]);
                    }
                }

                if ($status == "true") {

                    $course = $this->contextObj::find($courseId);

                    if ($course != null) {
                        $course->courseEmployee()
                            ->where('course_id', $courseId)
                            ->where('employee_id', $employee_id)
                            ->update(['courseparticipantstatus_id' => CourseParticipantStatusType::Completed]);
                    }
                }

                Session::flash('success_msg', 'Assessment submitted successfully!');
            }catch (Exception $exception) {
                Session::flash('fail_msg', 'Failed to submit assessment!');
            }

            return Redirect::to('my-courses#mycourse');

        } else {
            return View::make($this->baseViewPath.'.partials.assessment-form')
                ->with('assessmentId',$assessmentId)
                ->with('Data', $assessmentObj->data);
        }

    }

    /**
     * @param $moduleId
     * @param $moduleAssessmentResponseId
     * @param $objQnChoice
     * @param $value
     * @param $moduleAssessmentId
     * @param $sequence
     * @param $questionid
     * @param $questiontype
     * @return ModuleAssessmentResponseDetail
     */
    private function processResponseDetail($moduleId, $moduleAssessmentResponseId, $objQnChoice, $value, $moduleAssessmentId, $sequence,$questionid,$questiontype) {

        if(!isset($objQnChoice))
        {
            $objQnChoice = new ModuleQuestionChoice();
        }

        if($questiontype == "radio" || $questiontype == "checkbox")
        {
            $oldQnChoicePoints = $objQnChoice->points;
            $choicesobj = ModuleQuestionChoice::select(['id','choice_text','points'])
                ->with(['moduleQuestion'])
                ->where('module_question_id', $questionid)
                ->get()->all();

            if ($choicesobj!=null) {
                $objQnChoice->points = 0;
                foreach ($choicesobj as $choicesObjVal) {
                    //$objQnChoice->Points = $choicesobjval[0]->Points;
                    if($choicesObjVal->choice_text == $value)
                    {
                        $objQnChoice->points += $choicesObjVal->points;
                    }
                }
            }
            else
            {
                $objQnChoice->points = 0;
            }
        }
        $objR = new ModuleAssessmentResponseDetail();
        $input = ['module_id' => $moduleId,
                'module_assessment_response_id' => $moduleAssessmentResponseId,
                'module_question_id' => $questionid,
                'content' => $value,
                'points' => $objQnChoice->points,
                'sequence' => $sequence,
                'module_assessment_id' => $moduleAssessmentId
        ];
        $objR = $objR->addData($input);
        return $objR;
    }

    /**
     * @param $courseId
     * @param $moduleId
     * @param $topicId
     * @return string
     */
    private function getDisplayText($courseId,$moduleId,$topicId)
    {
        $course = Course::find($courseId);
        $module = Module::find($moduleId);
        $topic = Topic::find($topicId);
        $retDisplayText = 'Course: '.$course->description.' | '."Module: ".$module->description.' | '."Topic: ".$topic->header;

        return $retDisplayText;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCourseProgress(Request $request) {

        try {
            $courseId = Input::get('courseId');
            $topicId = Input::get('topicId');
            $moduleId= Input::get('moduleId');
            $topicHasAssessment = Input::get('topicHasAssessment');

            $employeeId = (\Auth::check()) ? \Auth::user()->employee_id : 0;

            $course = $this->contextObj::find($courseId);

            if(!empty($course)) {
                $course->employeeProgress()
                    ->where('employee_id', $employeeId)
                    ->where('course_id', $courseId)
                    ->where('module_id', $moduleId)
                    ->where('topic_id', $topicId)
                    ->update(['is_completed' => 1]);

                $courseModTopics = $this->contextObj::where('id', $courseId)->with(['employeeProgress'])->get()->first();

                // Updating Course Progress Status
                $totalCourseProgress = $courseModTopics->employeeProgress->count();
                // check and avoid division by 0 if there are no CourseProgress records
                if ($totalCourseProgress > 0) {
                    $countCompleted = 0;
                    foreach ($courseModTopics->employeeProgress as $employeeProgress) {
                        if ($employeeProgress->is_completed) {
                            $countCompleted++;
                        }
                    }

                    if ($countCompleted / $totalCourseProgress == 1) {
                        if ($topicHasAssessment == "true") {
                            $courseparticipantStatus = CourseParticipantStatusType::In_Progress;
                        } else {
                            $courseparticipantStatus = CourseParticipantStatusType::Completed;
                        }
                    } else {
                        $courseparticipantStatus = CourseParticipantStatusType::In_Progress;
                    }

                     $course->courseEmployee()
                        ->where('course_id', $courseId)
                        ->where('employee_id', $employeeId)
                        ->update(['courseparticipantstatus_id' => $courseparticipantStatus]);
                }
            }
                return response()->json(['response' => 'OK']);
        } catch (Exception $exception) {
            return response()->json(['response' => 'KO'], 500);
        }
    }

    /**
     * @param Request $request
     * @param $courseId
     * @return mixed
     */
    public function restartCourse(Request $request,$courseId)
    {
        $employeeId = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $course = $this->contextObj::find($courseId);

        if(!empty($course)) {
            $course->courseEmployee()
                ->where('course_id', $courseId)
                ->where('employee_id', $employeeId)
                ->update(['courseparticipantstatus_id' => CourseParticipantStatusType::Just_Enrolled]);

            $course->employeeProgress()
                ->where('employee_id', $employeeId)
                ->where('course_id', $courseId)
                ->update(['is_completed' => 0]);

            $moduleAssessmentResponses = ModuleAssessmentResponse::select(['id','course_id','employee_id'])
                ->where('course_id', $courseId)
                ->where('employee_id', $employeeId)
                ->get()->all();

            if ($moduleAssessmentResponses != null) {
                foreach ($moduleAssessmentResponses as $moduleAssessmentResponse) {

                    $moduleAssessmentResponse->delete();
                    $moduleAssessmentResponseDetails = ModuleAssessmentResponseDetail::select(['id', 'module_assessment_response_id'])
                        ->where('module_assessment_response_id', $moduleAssessmentResponse->id)->get()->all();

                    if($moduleAssessmentResponseDetails != null) {
                        foreach ($moduleAssessmentResponseDetails as $moduleAssessmentResponseDetail) {
                            $moduleAssessmentResponseDetail->delete();
                        }
                    }
                }
            }
        }

      return $this->renderTopic($courseId);
    }

    public function getTopicAttachments(Request $request, $topicId)
    {
        $modelClass = 'App\Topic';
        $data = [];

        $relatedMedias = $modelClass::find($topicId);
        if($relatedMedias) {
            $topicAttachments = $relatedMedias->media()->get()->all();

            if ($topicAttachments != null) {
                foreach ($topicAttachments as $index => $topicAttachment) {
                    $data[] = [
                        'Id' => $topicAttachment->id,
                        'TopicId' => $topicAttachment->pivot->mediable_id,
                        'OriginalFileName' => $topicAttachment->filename,
                    ];
                }
            }
        }

        return response()->json($data);

    }

    public function download($mediaId)
    {
        $media = Media::find($mediaId);
        return response()->download($media->getAbsolutePath());
    }
}