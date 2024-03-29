<?php

namespace App\Http\Controllers;

use App\AssetEmployee;
use App\Asset;
use App\Employee;
use App\SystemSubModule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class AssetAllocationsController extends CustomController
{

    public function __construct(){
        $this->contextObj = new AssetEmployee();
        $this->baseViewPath = 'asset_allocations';
        $this->baseFlash = 'Asset Allocation details ';
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $name = $request->get('asset:name', null);

        if(!empty($name)){
            $request->merge(['asset:name' => '%'.$name.'%']);
        }

        $tag = $request->get('asset:tag', null);

        if(!empty($tag)){
            $request->merge(['asset:tag' => '%'.$tag.'%']);
        }

        $serialNo = $request->get('asset:serial_no', null);

        if(!empty($serialNo)){
            $request->merge(['asset:serial_no' => '%'.$serialNo.'%']);
        }

        $full_name = $request->get('full_name', null);

        if(!empty($full_name)){
            $request->merge(['name' => '%'.$full_name.'%']);
        }

        $date_out = $request->get('date_out', null);

        if(!empty($date_out)){
            $request->merge(['date_out' => '%'.$date_out.'%']);
        }

        $date_in = $request->get('date_in', null);

        if(!empty($date_in)){
            $request->merge(['date_in' => '%'.$date_in.'%']);
        }

        // /jedrzej/searchable
        $assetEmployees =  $this->contextObj::with(['asset','employee'])->filtered()->paginate(10);

        $allowedActions = getAllowedActions(SystemSubModule::CONST_ASSETS_MANAGEMENT);

        // handle empty result bug
        if (Input::has('page') && $assetEmployees->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('assetEmployees','allowedActions'));
    }

    public function create() {
        list($assets, $employees) = $this->createEditCommon(false);
        return view($this->baseViewPath . '.create',compact('assets','employees'));
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

            $input = array_except($request->all(), array('_token','method'));

            $asset_id = $input['asset_id'];
            
            $this->contextObj->addData($input);

            $asset = Asset::find($asset_id);
            $asset->update(['is_available' => 0]);

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
        $id = Route::current()->parameter('asset_allocation');
        
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $recordComplete = !empty($data->date_out) && !empty($data->date_in);
        }

        if($request->ajax()) {
            if(!$recordComplete) {
                list($assets, $employees) = $this->createEditCommon();
                $view = view($this->baseViewPath . '.edit', compact('data','assets','employees'))
                        ->renderSections();
            } else {
                $data = AssetEmployee::with(['employee','asset'])->find($id);
                $view = view($this->baseViewPath . '.show', compact('data'))
                        ->renderSections();
            }

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','assets','employees'));
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
            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

            $this->contextObj->updateData($id, $input);

            if(!empty($input['date_in']))
            {
                $asset_id = $input['asset_id'];
                $asset = Asset::find($asset_id);
                $asset->update(['is_available' => 1]);
            }

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
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
            'asset_id' => 'required',
            'employee_id' => 'required',
            'date_out' => 'required',
            'date_in' => 'nullable',
            'comment' => 'string|min:1|max:1024|nullable'
        ];
        
        $this->validate($request, $validateFields);
    }

    protected function createEditCommon($listall = true){
        if(!$listall)
        {
            $assets = Asset::where('is_available',1)->pluck('tag','id')->all();
        }
        else{
            $assets = Asset::pluck('tag','id')->all();
        }

        $employees = Employee::pluck('full_name','id')->all();

        return array($assets, $employees);
    }

}