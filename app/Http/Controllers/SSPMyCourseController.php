<?php

namespace App\Http\Controllers;

use App\Course;
use App\Employee;
use App\Enums\CourseParticipantStatusType;
use App\Http\Requests;
use App\Module;
use App\ModuleAssessment;
use App\Topic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
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
        return View::make($this->baseViewPath .'.available', compact('coursesAvailable', 'warnings'));
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

        //TODO HistoryTraining

        $courseModTopics = $this->contextObj::where('id',$course_id)->with(['modules.topics','employees'])->get()->all();

        $course_employee_module_topic_pivot = [];

        if($courseModTopics != null){
            $module_count = 0;
            foreach ($courseModTopics[0]->modules as $module) {
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
                $topics_completed = 0;
                $modules_count = 0;
                foreach ($course->modules as $module) {
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
                        $modules[$modules_count]['Topics'] = [];
                    }
                }

                foreach ($course->employeeProgress as $employeeProgress){
                    if($employeeProgress->employee_id == $employee_id) {
                        if ($employeeProgress->is_completed > 0) {
                            $topics_completed++;
                        }

                        if ($employeeProgress->courseparticipantstatus_id == 2) {
                            if ($myCourses[$courses_count]['ProgressPercentage'] == 100) {
                                $myCourses[$courses_count]['ProgressPercentage'] = 90;
                            }
                        }
                    }
                }

                foreach ($course->employees as $employee){
                    if($employee->employee_id == $employee_id){
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
                    $myCourses[$courses_count]['ProgressPercentage'] = ($topics_completed/$topics_count) * 100;
                    $courses_count++;
                }
            }
        }

        return View::make($this->baseViewPath .'.mycourse', compact('myCourses'));
    }

    /**
     * @param $course_id
     */
    public function renderTopic($course_id) {
        $topic = null;
        $assessmentData = null;
        $assessmentId = 0;
        $topics = null;
        $assessment_list = [];

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $course = $this->contextObj::with(['modules.topics','employees', 'employeeProgress'])
            ->whereHas('employees', function($query) use ($employee_id, $course_id) {
                $query->where('employee_id',$employee_id);
                $query->where('course_id',$course_id);
            })
            ->whereHas('employeeProgress', function($query){
                $query->where('is_completed',0);
            })
            ->get()->first();

        if ($course != null){
            //dd($course);
            $isFirst = true;
            $prev_module_id = 0;
            $all_topic_counter = 0;

            foreach ($course->modules as $module) {
                //count no of topics in modules
                $topics_count = $module->topics->count();
                //dump($topics_count);
                //check if topics is not empty in modules i.e. present in pivot module_topic
                if($topics_count != 0) {
                    // Detect a change in moduleid...
                    $current_module_id = $module->id;
                    $topics_counter = 0;

                    foreach ($module->topics as $topic) {
                        //dd($topic->pivot->module_id);
                        $topic_assessments = [];
                        $topic_assessments1 = [];

                        if(!$isFirst && $current_module_id != $prev_module_id)
                        {
                            self::extractModuleAssessmentDetails($employee_id, $topic->pivot->module_id, $assessment_list, $topic_assessments, $course_id);
                            //dd($topic);
                            $topic->assessments = $topic_assessments;
                        }

                        $topics_counter++;

                        //dump($topics_count);
                        //dump($topics_counter);

                        if($topics_count == $topics_counter)
                        {
                            // Check if module has assemment and get ModuleAssessmentId and AssessmentData
                            // This check is being done on last topic of courses.
                            self::extractModuleAssessmentDetails($employee_id, $topic->pivot->module_id, $assessment_list, $topic_assessments1, $course_id);
                            $topic->assessments =  $topic_assessments1;
                            $topic->LastTopic = true;
                        }
                        else
                        {
                            $topic->LastTopic = false;
                            $topic->assessments =  $topic_assessments1;
                        }


                        $prev_module_id = $topic->pivot->module_id;
                        $isFirst = false;

                        // Add forward slash  before closing tag of img and source html tag.
                        // The missing forward slash was raising an error when invoking the simplexml_load_string method.

                        if(is_null($topic->data) || empty($topic->data) || $topic->data == "")
                        {
                            $topic->data = "<section><p>No content to display.</p></section>";
                        }else {

                            $topic_data = preg_replace("/<img([^>]+)\>/is", "<img $1 />", $topic->data);
                            $topic_data = preg_replace("/<source([^>]+)\>/is", "<source $1 />", $topic_data);
                            $topic_data = preg_replace('/&nbsp/', '&amp;nbsp', $topic_data);
                            $topic_data = str_replace("fragment", " ", $topic_data);
                            $xml = simplexml_load_string("<main>" . $topic_data . "</main>");
                            $topic->sections = [];

                            //dump($xml);

                            $sectioncount = count($xml);
                            $counter = 1;
                        }

                        //dump($topic);
                        //dump($all_topic_counter);
                        //dump($course->employeeProgress[$all_topic_counter]->is_completed);

                        //to prevent loop again on course_progress, making use of a counter
                        if(!$course->employeeProgress[$all_topic_counter]->is_completed)
                        {
                            $displayText = self::getDisplayText($course_id, $topic->pivot->module_id, $topic->id);
                            //dump($displayText);
                        }

                        $all_topic_counter++;
                    }
                    //die();
                    //dump($topics);
                    //dump($topics_counter);
                }
            }

        }
    }

    /**
     * @param $employee_id
     * @param $module_id
     * @param $assessment_list
     * @param $topic_assessments
     * @param $course_id
     */
    private function extractModuleAssessmentDetails($employee_id, $module_id, &$assessment_list,&$topic_assessments,$course_id)
    {
        $module_assessment = ModuleAssessment::find($module_id);

        //dd($module_assessment);

    }

    private function getDisplayText($courseId,$moduleId,$topicId)
    {
        //dump($courseId);
        //dump($moduleId);
        //dump($topicId);
        //die();
        $retDisplayText = "";
        $course = Course::find($courseId);
        $module = Module::find($moduleId);
        $topic = Topic::find($topicId);
        $retDisplayText = 'Course: '.$course->description.' | '."Module: ".$module->description.' | '."Topic: ".$topic->header;

        //dump($retDisplayText);
        return $retDisplayText;
    }
}