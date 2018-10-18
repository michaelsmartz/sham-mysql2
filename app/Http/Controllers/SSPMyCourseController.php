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
        $this->contextObj = new Employee();
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
            $course = new Course();
            $coursesAvailable = $course->with(['modules.topics','employees'])->where('is_public',1)->get()->all();

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
}