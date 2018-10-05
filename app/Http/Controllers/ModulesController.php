<?php

namespace App\Http\Controllers;

use App\Module;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;

class ModulesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Module();
        $this->baseViewPath = 'modules';
        $this->baseFlash = 'Module details ';
    }

    /**
     * Display a listing of the modules.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $modules = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if ($modules->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('modules'));
    }

    public function create() {
        $topics = Topic::pluck('header', 'id');
        return view($this->baseViewPath . '.create',compact('topics'));
    }

    /**
     * Store a new module in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $topics = array_get($request->all(),'topics');
            $input = array_except($request->all(),array('_token', 'q', 'topics'));

            $data = $this->contextObj->addData($input);
            $data->topics()
                ->sync($topics); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {
        $id = Route::current()->parameter('module');
        $data = $this->contextObj->findData($id);

        $moduleTopics = $data->topics()->orderBy('module_topic.id','asc')->pluck('header','module_topic.topic_id');
        $topics = Topic::pluck('header', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'topics', 'moduleTopics'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data', 'topics', 'moduleTopics'));
    }

    /**
     * Update the specified module in the storage.
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
            $topics = array_get($request->all(),'topics');
            $input = array_except($request->all(),array('_token','_method', 'q', 'topics','redirectsTo'));

            $this->contextObj->updateData($id, $input);
            $data = Module::find($id);
            $data->topics()
                ->sync($topics); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified module from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $data = Module::find($id);
            $data->topics()->sync([]); //detach all linked module topics
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

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
            'description' => 'required|string|min:5|max:256',
            'overview' => 'string|min:1|max:999|nullable',
            'objectives' => 'string|min:1|nullable',
            'passmark_percentage' => 'numeric|nullable',
        ];

        $this->validate($request, $validateFields);
    }

    
}
