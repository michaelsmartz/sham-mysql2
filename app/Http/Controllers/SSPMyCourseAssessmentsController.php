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
            }
        }

        return View::make($this->baseViewPath .'.myassessments')
            ->with('myCourses',$crs);
    }

    public function getCoursesAndModules()
    {

        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $myCourses = Course::with(['employees', 'modules'])
            ->whereHas('employees', function ($query) use ($employee_id) {
                $query->where('employee_id', $employee_id);
            })
            ->get()->all();

        if ($myCourses != null) {
            if (!empty($myCourses) && sizeof($myCourses) > 0) {
                foreach ($myCourses as $course) {
                    if (!empty($course)) {

                        foreach ($course->employees as $employee) {
                            if ($employee->employee_id == $employee_id) {
                                $course_participant_description = CourseParticipantStatusType::getDescription($employee->courseparticipantstatus_id);
                                $course->courseParticipantStatus = ['id' => $employee->courseparticipantstatus_id,
                                    'description' => $course_participant_description,
                                ];
                            }
                        }

                        foreach ($course->modules as $module) {
                            $course->data = ModuleAssessmentResponseDetail::assessmentResponseSheet()
                                ->with('moduleAssessmentResponse', 'moduleQuestion', 'moduleAssessment')
                                ->where('module_id', $module->id)
                                ->get()->all();
                        }

                        $course['assessment_total_possible_points'] = 0;
                        $course['assessment_overall_points'] = 0;

                        foreach ($course->data as $assessment) {
                            $choices = explode('|', $assessment->question_choices);
                            $choicePoints = explode('|', $assessment->question_choices_points);
                            $course['assessment_total_possible_points'] += $assessment->question_points;
                            $course['assessment_overall_points'] +=$choicePoints[array_search($assessment->response, $choices)];
                            $course['assessment_date_completed'] = $assessment->moduleAssessmentResponse->date_completed;
                            $course['assessment_description'] = $assessment->moduleAssessment->description;
                            $course['assessment_pass_mark'] = $assessment->moduleAssessment->pass_mark;
                        }
                    }
                }
            }
        }
        return $myCourses;
    }
}

