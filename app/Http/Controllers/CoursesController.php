<?php

namespace App\Http\Controllers;

use App\Course;
use App\Module;
use App\SystemSubModule;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;

class CoursesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Course();
        $this->baseViewPath = 'courses';
        $this->baseFlash = 'Course details ';
    }

    /**
     * Display a listing of the courses.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $description = $request->get('description', null);

        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $courses = $this->contextObj::filtered()->paginate(10);
        
        $allowedActions = getAllowedActions(SystemSubModule::CONST_COURSES);

        // handle empty result bug
        if (Input::has('page') && $courses->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());
        
        return view($this->baseViewPath .'.index', compact('courses','allowedActions'));
    }

    public function create() {
        $modules = Module::pluck('description', 'id');
        return view($this->baseViewPath . '.create',compact('modules'));
    }
    
    /**
     * Store a new course in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $modules = array_get($request->all(),'modules');

            $input = array_except($request->all(),array('_token', 'q',  'modules'));
            
            $data = $this->contextObj->addData($input);
            $data->modules()
                ->sync($modules); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }
        
        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {

        $id = Route::current()->parameter('course');
        $data = $this->contextObj->findData($id);

        $courseModules = $data->modules()->orderBy('course_module.id','asc')->pluck('description', 'course_module.module_id');
        $modules = Module::pluck('description', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'modules', 'courseModules'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data', 'modules', 'courseModules'));
    }

    /**
     * Update the specified course in the storage.
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
            $modules = array_get($request->all(),'modules');
            $input = array_except($request->all(),array('_token','_method', 'q', 'modules','redirectsTo'));

            $this->contextObj->updateData($id, $input);
            $data = Course::find($id);
            $data->modules()
                 ->sync($modules); //sync what has been selected
            
            \Session::put('success', $this->baseFlash . 'updated Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified course from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $data = Course::find($id);
            $data->modules()->sync([]); //detach all linked course modules
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!');
            
        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
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
            'description' => 'string|min:5|max:100|nullable',
            'is_public' => 'boolean|nullable',
            'overview' => 'string|min:1|nullable',
            'objectives' => 'string|min:1|nullable',
            'passmark_percentage' => 'numeric|nullable',     
        ];
        
        $this->validate($request, $validateFields);
    }

    
}
