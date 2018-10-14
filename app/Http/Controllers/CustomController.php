<?php
/**
 * Created by PhpStorm.
 * User: TaroonG
 * Date: 5/8/2018
 * Time: 7:56 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomController extends Controller
{
    protected $contextObj;
    protected $baseFlash;
    protected $baseViewPath;
    protected $request;
    protected $id = false;

    // child class properties
	protected $model = ''; // e.g. 'App\Product'
	protected $fields = [];
	protected $intermediaries = []; // e.g. ['tags' => ['save' => false, 'destroy' => true]]
	protected $objectLang = ''; // e.g. 'product'
	protected $redirectAfter = [
		'store' => '', // e.g. 'products.show'
		'update' => '',
		'destroy' => '',
	];

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (!Session::has('redirectsTo'))
        {
          Session::put('redirectsTo', \URL::previous());
        }
        return view($this->baseViewPath . '.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = null;
        if($request->has('id')) {
            $id = $request->id;
            $data = $this->contextObj->findData($id);
        }
        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data'));
    }

}