<?php

namespace App\Http\Controllers;

use App\AssetSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class AssetSupplierController extends CustomController
{

    public function __construct(){
        $this->contextObj = new AssetSupplier();
        $this->baseViewPath = 'asset_suppliers';
        $this->baseFlash = 'Asset Supplier details ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /*$assetSuppliers = $this->contextObj->getData();
        $this->contextObj::filter($request->all())->paginate(10);*/

        // /jedrzej/searchable
        $assetSuppliers =  $this->contextObj::filtered()->paginate(10);

        //san4io/eloquent-filter (php 7.1)
        //$assetSuppliers =  $this->contextObj->filter($request->all())->paginate(10);
        return view($this->baseViewPath .'.index', compact('assetSuppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contextObj->destroyData($id);

        \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');
    }

    protected function validator(Request $request)
    {
        $validateFields = [
            'fieldname' => 'required|max:45'
        ];

        $this->validate($request, $validateFields);
    }
}
