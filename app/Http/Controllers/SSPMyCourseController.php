<?php

namespace App\Http\Controllers;

use App\Course;
use App\Employee;
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
        return response()->json(['response' => 'KO'], 500);
    }
}