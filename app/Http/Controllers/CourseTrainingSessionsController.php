<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use App\TrainingSession;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
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
        return view($this->baseViewPath .'.index', compact('courseTrainingSessions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($courses, $participants) = $this->createEditCommon();

        return view($this->baseViewPath . '.create', compact('courses','participants'));
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

            $employees = array_get($request->all(), 'employees.id');
            $input = array_except($request->all(), array('_token','employees'));

            $this->contextObj->addData($input);
            $data->employees()
            ->sync($employees); //sync what has been selected

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
        $id = Route::current()->parameter('training_session');
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $employees = $data->employees->pluck('id');
            list($courses, $participants) = $this->createEditCommon();
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','courses','participants','employees'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','courses','participants'));
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

            $employees = array_get($request->all(), 'employees');
            $input = array_except($request->all(),array('_token','_method','employees'));

            $data = TrainingSession::find($id);
            $this->contextObj->updateData($id, $input);

            // no syncing if the previous save had already finalised the participants
            if($data->is_final != 1){
                $data->employees()->sync($employees); //sync what has been selected
                
                if($request->is_final == TRUE){
                    // user is finalising the participants, enrol them and add progress
                    $course = Course::find($request->course_id);
                    $tempCourseEmployees = $course->employees;
                    
                    $previousEnrolled = $sessionEmployees = [];
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
                    // enrol selected employees and preserve previously enrolled employees
                    $course->employees()->sync($finalEmployees);
                }
            }

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {

            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->back();
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
            $id = Route::current()->parameter('training_session');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    protected function createEditCommon(){
        $courses = Course::where('is_public', '=', 0)->pluck('description','id')->all();
        $courseIds = implode(',', array_keys($courses));

        $temp = DB::select("select id, concat(first_name, ' ', surname) as full_name 
                            from employees 
                            where employees.id not in (select employee_id from course_employee where course_id in (".$courseIds.")) and 
                                  employees.deleted_at is null 
                            order by full_name");
        $participants = collect($temp)->pluck('full_name','id')->all();

        return array($courses, $participants);
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
}