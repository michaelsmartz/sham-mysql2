<?php

namespace App\Http\Controllers;

use App\Policy;
use App\PolicyCategory;
use App\SystemSubModule;
use App\Traits\MediaFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;

class PoliciesController extends CustomController
{
    use MediaFiles;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Policy();
        $this->baseViewPath = 'policies';
        $this->baseFlash = 'Policy details ';
    }

    /**
     * Display a listing of the policies.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $policies = $this->contextObj::with('policyCategory')->filtered()->paginate(10);
        
        $allowedActions = getAllowedActions(SystemSubModule::CONST_COMPLIANCE_MANAGEMENT);

        // handle empty result bug
        if (Input::has('page') && $policies->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }        
        return view($this->baseViewPath .'.index', compact('policies','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $policyCategories = PolicyCategory::pluck('description','id')->all();
        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload document files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "1.2", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];
        return view($this->baseViewPath . '.create', compact('data','policyCategories','uploader'));
    }

    /**
     * Store a new policy in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try{
            $this->validator($request);

            $input = array_except($request->all(),array('_token'));

            $context = $this->contextObj->addData($input);

            $this->attach($request, $context->id);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch(Exception $exception) {
            \Session::put('error', 'Could not create '. $this->baseFlash . '!');
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
        $data = $policyCategories = null;
        $id = Route::current()->parameter('policy');
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $policyCategories = PolicyCategory::pluck('description','id')->all();
        }
        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload document files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "1.2", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];
        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','countries','policyCategories','uploader'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','countries','policyCategories'));
    }

    /**
     * Update the specified policy in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try{
            $this->validator($request);

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);
            $this->attach($request, $id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch(Exception $exception) {
            \Session::put('error', 'Could not update ' . $this->baseFlash . '!');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified policy from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try{
            $id = Route::current()->parameter('policy');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch(Exception $exception) {
            \Session::put('error', 'Could not delete ' .$this->baseFlash . '!');
        }

        return redirect()->back();
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
            'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:4294967295',
            'policy_category_id' => 'nullable',
            'expires_on' => 'nullable|string|min:0',
     
        ];
        

        $this->validate($request, $validateFields);
    }

    
}
