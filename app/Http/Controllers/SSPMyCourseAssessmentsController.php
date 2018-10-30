<?php

namespace App\Http\Controllers;

use App\Course;
use App\Enums\CourseParticipantStatusType;
use App\ModuleAssessment;
use App\ModuleAssessmentResponse;
use App\ModuleAssessmentResponseDetail;
use App\ModuleQuestion;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use View;
use Redirect;
use Validator;
use Session;

class SSPMyCourseAssessmentsController extends CustomController
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){
        $this->contextObj = new ModuleAssessmentResponse();
        $this->baseViewPath = 'selfservice-portal.e-learning';
    }

    public function index() {

        $crs = $this->getCoursesAndModules();

        foreach ($crs as $course) {
            $course->HasAssessmentResponses = false;
            if(!empty($course['data'])){
                $course->HasAssessmentResponses = true;
                $course->StudentScore = $this->computeAssessmentLevelPoints($course['data']);
            }
        }

        //dd($crs);

        return View::make($this->baseViewPath .'.myassessments')
            ->with('myCourses',$crs);
    }

    public function getCoursesAndModules() {

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $myCourses = Course::with(['employees','modules'])
            ->whereHas('employees', function($query) use ($employee_id) {
                $query->where('employee_id',$employee_id);
            })
            ->get()->all();

        if ($myCourses != null) {
            if(!empty($myCourses) && sizeof($myCourses) > 0) {
                foreach ($myCourses as $course) {
                    if (!empty($course)) {

                        foreach ($course->employees as $employee){
                            if($employee->employee_id == $employee_id){
                                $course_participant_description = CourseParticipantStatusType::getDescription($employee->courseparticipantstatus_id);
                                $course->courseParticipantStatus = [ 'id'=> $employee->courseparticipantstatus_id,
                                                                     'description' => $course_participant_description,
                                                                     'OverallScore' => 0
                                                                   ];
                            }
                        }

                        foreach ($course->modules as $module) {
                            $module->TotalStudentScore = 0;
                            $course->moduleAssessment = ModuleAssessment::with('module','assessmentType')
                                ->where('module_id',$module->id)
                                ->get()->all();

                            $course->data = ModuleAssessmentResponseDetail::assessmentResponseSheet()
                                ->with('moduleAssessmentResponse')
                                ->where('module_id',$module->id)
                                ->get()->all();

                            if($course->moduleAssessment != null) {
                                $module->TotalStudentScore = $this->computeModuleLevelPoints($course->moduleAssessment);
                            }
                        }
                    }
                    $course->OverallScore = $this->computeCourseLevelPoints($course->modules->toArray());
                }
            }
        }
        return $myCourses;
    }

    public function computeQuestionLevelPoints($arr) {
        foreach ($arr as $r) {
            $sum = array_reduce($r->ResponseDetails, function($i, $obj) {
                //echo $i,' ', $obj->Content, ' ', $obj->Points, '<br>';
                return $i += $obj->Points;
            });
            $r->SumPoints = $sum;
        }
        return $arr;
    }

    public function computeAssessmentLevelPoints($arr) {
        return array_reduce($arr, function($i, $obj) {
            $a = $obj->toArray();
            if(in_array('SumPoints', $a))
                return $i += $a->SumPoints;
            else
                return $i += 0;
        });
    }

    public function computeModuleLevelPoints($arr) {
        return array_reduce($arr, function($i, $obj) {
            $a = $obj->toArray();
            if(in_array('StudentScore', $a))
                return $i += $a->StudentScore;
            else
                return $i += 0;
        });
    }

    public function computeCourseLevelPoints($arr) {
        return array_reduce($arr, function($i, $a) {
            if(in_array('TotalStudentScore', $a)) {
                return $i += $a['TotalStudentScore'];
            }
            else
                return $i += 0;
        });
    }


}

