<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetGroup;
use App\AssetSupplier;
use App\AssetCondition;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
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
        return view($this->baseViewPath .'.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $assetGroups = AssetGroup::pluck('name','id')->all();
        $assetSuppliers = AssetSupplier::pluck('description','id')->all();
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
            $assetSuppliers = AssetSupplier::pluck('description','id')->all();
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

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
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
    
    
}