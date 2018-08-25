<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetGroup;
use App\AssetSupplier;
use App\AssetCondition;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;

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
        $this->baseViewPath = 'asset';
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
     * Store a new asset in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validator($request);

        $input = array_except($request->all(),array('_token'));

        $this->contextObj->addData($input);

        \Session::put('success', $this->baseFlash . 'created Successfully!');

        return redirect()->route($this->baseViewPath .'.index');
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
        $this->validator($request);

        $input = array_except($request->all(),array('_token','_method'));

        $this->contextObj->updateData($id, $input);

        \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified asset from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
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
            'name' => 'required|string|min:1|max:100',
            'asset_group_id' => 'required',
            'asset_supplier_id' => 'required',
            'tag' => 'required|string|min:1|max:50',
            'serial_no' => 'required|string|min:1|max:20',
            'purchase_price' => 'required|numeric|min:-1.0E+15|max:1.0E+15',
            'po_number' => 'required|numeric|string|min:1|max:20',
            'warranty_expiry_date' => 'required|date_format:j/n/Y',
            'asset_condition_id' => 'required',
            'comments' => 'required|string|min:1|max:256',
            'is_available' => 'boolean|nullable',
     
        ];
        

        $this->validate($request, $validateFields);
    }

    
}
