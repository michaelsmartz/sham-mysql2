<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetGroup;
use App\AssetSupplier;
use App\AssetCondition;
use App\SystemSubModule;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Exception;

class AssetsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Asset();
        $this->baseViewPath = 'assets';
        $this->baseFlash = 'Asset details ';
    }

    /**
     * Display a listing of the assets.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $assets = $this->contextObj::filtered()->paginate(10);

        $allowedActions = session('modulePermissions')[SystemSubModule::CONST_ASSETS_MANAGEMENT];

        // handle empty result bug
        if (Input::has('page') && $assets->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('assets','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assetGroups = AssetGroup::pluck('name','id')->all();
        $assetSuppliers = AssetSupplier::pluck('name','id')->all();
        $assetConditions = AssetCondition::pluck('description','id')->all();

        return view($this->baseViewPath . '.create', compact('data','assetGroups','assetSuppliers','assetConditions'));
    }

    /**
     * Store a new asset in the storage.
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = $assetGroups = $assetSuppliers = $assetConditions = null;
        $id = Route::current()->parameter('asset');
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $assetGroups = AssetGroup::pluck('name','id')->all();
            $assetSuppliers = AssetSupplier::pluck('name','id')->all();
            $assetConditions = AssetCondition::pluck('description','id')->all();
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','assetGroups','assetSuppliers','assetConditions'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','assetGroups','assetSuppliers','assetConditions'));
    }

    /**
     * Update the specified asset in the storage.
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

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception);
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified asset from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('asset');
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
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'asset_supplier_id' => 'required',
            'asset_group_id' => 'required',
            'name' => 'required|string|min:1|max:100',
            'tag' => 'required|string|min:1|max:50',
            'po_number' => 'required|string|min:1|max:20',
            'serial_no' => 'required|string|min:1|max:20',
            'warranty_expiry_date' => 'required',
            'asset_condition_id' => 'required',
            'comments' => 'required|string|min:1|max:256'
        ];

        $validator = Validator::make($request->all(), $validateFields);
        if($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }
    }
}