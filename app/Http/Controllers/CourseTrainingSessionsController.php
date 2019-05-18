<?php

namespace App\Http\Controllers;

use App\Course;
use App\Employee;
use Illuminate\Http\Request;
use App\TrainingSession;
use App\SystemSubModule;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;
use Validator;
use Illuminate\Support\Facades\DB;

class CourseTrainingSessionsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new TrainingSession();
        $this->baseViewPath = 'course_training_sessions';
        $this->baseFlash = 'Training Session details ';
    }

    /**
     * Display a listing of the course training sessions.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $courseTrainingSessions = $this->contextObj::filtered()->paginate(10);
        
        $allowedActions = getAllowedActions(SystemSubModule::CONST_TRAINING_SESSION_MANAGEMENT);

        // handle empty result bug
        if (Input::has('page') && $courseTrainingSessions->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('courseTrainingSessions','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $selectedParticipants = [];
        list($courses, $employees) = $this->createEditCommon();

        return view($this->baseViewPath . '.create', compact('courses','employees', 'selectedParticipants'));
    }

    /**
     * Store a new course training session in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $employees = array_get($request->all(), 'employees');
            $input = array_except($request->all(), array('_token','employees'));

            $data = $this->contextObj->addData($input);
            // sync employee<--->training_session
            $data->employees()->sync($employees); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = $countries = null;
        $id = Route::current()->parameter('course_training_session');
        if(!empty($id)) {
            $data = $this->contextObj::with('employees')->get()->where('id', $id)->first();
            list($courses, $temp) = $this->createEditCommon($data->is_final);

            $selectedParticipants = $data->employees()
                ->orderBy('employee_training_session.id','asc')
                ->pluck('full_name', 'employee_training_session.employee_id');

            $employees = $temp;
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','courses','participants','employees','selectedParticipants'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','courses','participants','employees', 'selectedParticipants'));
    }

    /**
     * Update the specified course training session in the storage.
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
            $employees = array_get($request->all(), 'employees');
            $input = array_except($request->all(),array('_token','_method','employees','redirectsTo'));

            $this->contextObj->updateData($id, $input);
            $data = TrainingSession::find($id);

            // no syncing if the previous save had already finalised the participants
            if($data->is_final != 1){
                // sync employee<--->training_session
                $data->employees()->sync($employees); //sync what has been selected

                $this->enrolAndSetProgressEmployees($data, $employees, $request);
            }

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified course training session from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('course_training_session');
            $data = TrainingSession::find($id);
            $data->employees()->sync([]); //detach all linked course modules
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    protected function createEditCommon(){
        $selectedParticipants = [];
        $courses = Course::where('is_public', '=', 0)->pluck('description','id')->all();
        $courseIds = implode(',', array_keys($courses));

        if(!empty($courses)) {
            $temp = DB::select("select id, concat(first_name, ' ', surname) as full_name 
                            from employees 
                            where employees.id not in (select employee_id from course_employee where course_id in (" . $courseIds . ")) and 
                                  employees.deleted_at is null 
                            order by full_name");

            $selectedParticipants = collect($temp)->pluck('full_name', 'id')->all();
        }

        $employees = Employee::whereNull('date_terminated')->pluck('first_name, surname as full_name', 'id');

        return array($courses, $employees, $selectedParticipants);
    }

        /**
     * Validate the given request with the defined rules.
     *
     * @param  Request $request
     *
     * @return boolean
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'name' => 'string|min:1|max:100|required',
            'is_final' => 'boolean|nullable',
            'course_id' => 'required',
            'employees.*' => 'required'
        ];
        
        $this->validate($request, $validateFields);
    }

    protected function enrolAndSetProgressEmployees($data, $employees, $request){
        try{
            if($request->is_final == TRUE){
                // user is finalising the participants, enrol them and add progress
                $course = Course::find($request->course_id);
                $tempCourseEmployees = $course->employees;
                
                $previousEnrolled = $sessionEmployees = $courseProgress = [];
                foreach($tempCourseEmployees as $item){
                    $previousEnrolled[$item->employee_id] = [
                        'courseparticipantstatus_id' => $item->courseparticipantstatus_id,
                        'course_id' => $course->id,
                        'employee_id' => $item->employee_id
                    ];
                }
    
                foreach($employees as $v) {
                    $sessionEmployees[$v] = [
                        'courseparticipantstatus_id' => 1,
                        'course_id' => $course->id,
                        'employee_id' => $v
                    ];
                }
                $finalEmployees = array_merge($previousEnrolled, $sessionEmployees);
    
                // sync course<--->employee
                // enrol selected employees and preserve previously enrolled employees
                $course->employees()->sync($finalEmployees);
    
                //prepare to add the course progress
                $cmt = Course::with('modules.topics')->find($request->course_id);
                if(sizeof($cmt)>0){
                    $preCourseProgress = [];
                    foreach($cmt->modules as $module){
                        foreach($module->topics as $topic){
                            $preCourseProgress[] = [
                                'course_id' => $request->course_id,
                                'module_id' => $module->id,
                                'topic_id' => $topic->id
                            ];
                        }
                    }
    
                    $courseProgressToSync = [];
                    foreach($employees as $e){
                        foreach($preCourseProgress as $k => &$v){
                            $v['employee_id'] = $e;
                            $courseProgressToSync[] = $v;
                        }
                    }
                }
    
                //sync course_progress for the final training session participants
                $course->employeeProgress()->sync($courseProgressToSync);
            }
    
        } catch (Exception $exception) {
            dump($exception); die;
        }
    }
}