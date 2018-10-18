<?php

namespace App\Http\Controllers;

use App\AssetGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;

class AssetGroupsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new AssetGroup();
        $this->baseViewPath = 'asset_groups';
        $this->baseFlash = 'Asset Group details ';
    }

    /**
     * Display a listing of the asset groups.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $assetGroups = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page') && $assetGroups->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }        
        return view($this->baseViewPath .'.index', compact('assetGroups'));
    }

    /**
     * Store a new asset group in the storage.
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
        $id = Route::current()->parameter('asset_group');
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
     * Update the specified asset group in the storage.
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
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));
            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch(Exception $exception) {
            \Session::put('error', 'Could not update ' . $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified asset group from the storage.
     *
     * @param  Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try{
            $id = Route::current()->parameter('asset_group');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');
        } catch(Exception $exception) {
            \Session::put('error', 'Could not delete ' .$this->baseFlash . '!');
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
            'name' => 'string|min:1|max:50|required',
            'description' => 'string|min:1|max:100|required'     
        ];        

        $this->validate($request, $validateFields);
    }

    
}
