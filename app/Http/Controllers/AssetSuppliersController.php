<?php

namespace App\Http\Controllers;

use App\AssetSupplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class AssetSuppliersController extends CustomController
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
        try{
            $this->validator($request);

            $input = array_except($request->all(),array('_token'));

            $this->contextObj->addData($input);

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
        $data = null;
        $id = Route::current()->parameter('asset_supplier');
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data'));
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
        try{
            $this->validator($request);

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch(Exception $exception) {
            \Session::put('error', 'Could not update ' . $this->baseFlash . '!');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {        
        try{
            $id = Route::current()->parameter('asset_supplier');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch(Exception $exception) {
            \Session::put('error', 'Could not delete ' .$this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    protected function validator(Request $request)
    {
        $validateFields = [
            'name' => 'required|string|min:1|max:100',
            'address1' => 'required|string|min:1|max:100',
            'address2' => 'required|string|min:1|max:100',
            'address3' => 'nullable|string|min:1|max:100',
            'address4' => 'nullable|string|min:1|max:100',
            'telephone' => 'required|string|min:1|max:20',
            'email_address' => 'nullable|string|min:1|max:100'
        ];

        $this->validate($request, $validateFields);
    }
}
