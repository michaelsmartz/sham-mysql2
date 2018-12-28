<?php

namespace App\Http\Controllers;

use App\Support\Helper;
use App\SystemSubModule;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class InterviewsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseViewPath = 'interviews';
        $this->baseFlash = 'Interviews details';
    }

    /**
     * Display a listing of the branches.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $interviews = [];

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('interviews'));
    }
    public function create(){
        $view = view($this->baseViewPath . '.create', [])->renderSections();
        return response()->json([
            'title' => $view['modalTitle'],
            'content' => $view['modalContent'],
            'footer' => $view['modalFooter'],
            'url' => $view['postModalUrl']
        ]);
    }

    /**
     * Store a new branch in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            //$this->validator($request);

            //$input = array_except($request->all(),array('_token'));

            //$this->contextObj->addData($input);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {
        $id = Route::current()->parameter('interview');
        $data = $this->contextObj->findData($id);

        $interviews = [];

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('interviews','data'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('requests','data'));
    }

    /**
     * Update the specified branch in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            //$this->validator($request);

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified branch from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('interview');
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
     * @param  Request $request
     *
     * @return boolean
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'description' => 'required|string|min:0|max:50'
        ];

        $this->validate($request, $validateFields);
    }
}