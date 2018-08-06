<?php

namespace App\Http\Controllers;

use App\Module;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;

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
        $this->validator($request);

        $topics = array_get($request->all(),'topics.id');
        $input = array_except($request->all(),array('_token', 'topics'));
        
        $data = $this->contextObj->addData($input);
        $data->topics()
             ->sync($topics); //sync what has been selected

        \Session::put('success', $this->baseFlash . 'created Successfully!');

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit($id)
    {
        $data = $this->contextObj->findData($id);
        $moduleTopics = $data->topics->pluck('id');
        $topics = Topic::pluck('header', 'id');

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
        $this->validator($request);

        $topics = array_get($request->all(),'topics.id');
        $input = array_except($request->all(),array('_token','_method', 'topics'));

        $this->contextObj->updateData($id, $input);
        $data = Module::find($id);
        $data->topics()
             ->sync($topics); //sync what has been selected

        \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');
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
        $data = Course::find($id);
        $data->topics()->sync([]); //detach all linked module topics
        $this->contextObj->destroyData($id);

        \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

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
