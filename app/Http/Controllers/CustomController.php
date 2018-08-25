<?php
/**
 * Created by PhpStorm.
 * User: TaroonG
 * Date: 5/8/2018
 * Time: 7:56 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomController extends Controller
{
    public $contextObj;
    public $baseFlash;
    public $baseViewPath;

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
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
            $data = $this->contextObj->findData($id);
            $id = $request->id;
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