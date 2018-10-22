<?php

namespace App\Http\Controllers;

use App\Course;
use App\Employee;
use App\Enums\CourseParticipantStatusType;
use App\Http\Requests;
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

        //dd($coursesAvailable);

        // load the view and pass the coursesAvailable
        return View::make($this->baseViewPath .'.available', compact('coursesAvailable', 'warnings'));
    }

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
                        $course_participant_description = CourseParticipantStatusType::getKey($employee->courseparticipantstatus_id);
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

        //dd($myCourses);

        return View::make($this->baseViewPath .'.mycourse', compact('myCourses'));
    }
}