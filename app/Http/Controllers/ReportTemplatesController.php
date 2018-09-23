<?php

namespace App\Http\Controllers;

use App\ReportTemplate;
use App\SystemModule;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class ReportTemplatesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new ReportTemplate();
        $this->baseViewPath = 'report_templates';
        $this->baseFlash = 'Report Template details ';
    }

    /**
     * Display a listing of the report templates.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $reportTemplates = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('reportTemplates'));
    }


    public function create() {
        $system_modules = SystemModule::pluck('description', 'id');
        return view($this->baseViewPath . '.create',compact('system_modules'));
    }

    /**
     * Store a new report template in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $input = array_except($request->all(),array('_token'));

            $this->contextObj->addData($input);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {
        $id = Route::current()->parameter('report_template');
        $data = $this->contextObj->findData($id);

        $system_modules = SystemModule::pluck('description', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'system_modules'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data', 'system_modules'));
    }

    /**
     * Update the specified report template in the storage.
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

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified report template from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('report_template');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
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
            'source' => 'required|string|min:0|max:200',
            'title' => 'nullable|string|min:0|max:100',
            'system_module_id' => 'nullable'
        ];

        $this->validate($request, $validateFields);
    }
    
}