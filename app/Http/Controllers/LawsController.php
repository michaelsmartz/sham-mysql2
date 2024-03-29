<?php

namespace App\Http\Controllers;

use App\Law;
use App\Country;
use App\LawCategory;
use App\SystemSubModule;
use App\Traits\MediaFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;

class LawsController extends CustomController
{
    use MediaFiles;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Law();
        $this->baseViewPath = 'laws';
        $this->baseFlash = 'Law details ';
    }

    /**
     * Display a listing of the laws.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $laws = $this->contextObj::with(['country','lawCategory'])->filtered()->paginate(10);
        
        $allowedActions = getAllowedActions(SystemSubModule::CONST_COMPLIANCE_MANAGEMENT);

        // handle empty result bug
        if (Input::has('page') && $laws->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('laws','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('description','id')->all();
        $lawCategories = LawCategory::pluck('description','id')->all();
        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload document files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "1.2", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];
        return view($this->baseViewPath . '.create', compact('data','countries','lawCategories','uploader'));
    }

    /**
     * Store a new law in the storage.
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
        return redirect()->route($this->baseViewPath .'.index', ['page' => $request->get('page', 1)]);

        //return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = $countries = $lawCategories = null;
        $id = Route::current()->parameter('law');
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $countries = Country::pluck('description','id')->all();
            $lawCategories = LawCategory::pluck('description','id')->all();
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
            $view = view($this->baseViewPath . '.edit', compact('data','countries','lawCategories','uploader'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','countries','lawCategories'));
    }
    
    /**
     * Update the specified law in the storage.
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
            $input = array_except($request->all(),array('_token','_method','attachment','redirectsTo'));

            $this->contextObj->updateData($id, $input);
            $this->attach($request, $id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch(Exception $exception) {
            \Session::put('error', 'Could not update ' . $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified law from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {

        try{

            $id = Route::current()->parameter('law');
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
            'main_heading' => 'required|string|min:1|max:100',
            'sub_heading' => 'nullable|string|min:0|max:100',
            'country_id' => 'nullable|numeric|min:0|max:4294967295',
            'law_category_id' => 'nullable',
            'content' => 'required|string|min:1|max:4294967295',
            'is_public' => 'nullable|boolean',
            'expires_on' => 'nullable|string|min:0'
        ];

        $this->validate($request, $validateFields);
    }
    
}