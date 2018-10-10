<?php

namespace App\Http\Controllers;

use App\Product;
use App\Team;
use App\TimeGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class TeamsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Team();
        $this->baseViewPath = 'teams';
        $this->baseFlash = 'Team details ';
    }

    /**
     * Display a listing of the teams.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $teams = $this->contextObj::with(['products'])->filtered()->paginate(10);

        // handle empty result bug
        if ($teams->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        return view($this->baseViewPath .'.index', compact('teams', 'products'));
    }

    public function create() {
        $time_groups = TimeGroup::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        return view($this->baseViewPath . '.create',compact('time_groups', 'products'));
    }

    /**
     * Store a new team in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
       try {
            $this->validator($request);

            $products = array_get($request->all(),'products.id');
            $input = array_except($request->all(),array('_token', 'products'));

            $data = $this->contextObj->addData($input);
            $data->products()
               ->sync($products); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = Route::current()->parameter('team');
        $data = $this->contextObj->findData($id);

        $time_groups = TimeGroup::pluck('name', 'id');
        $products = Product::pluck('name', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'time_groups', 'products'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data', 'time_groups', 'products'));
    }

    /**
     * Update the specified team in the storage.
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

            $products = array_get($request->all(),'products.id');
            $input = array_except($request->all(),array('_token','_method', 'products'));

            $this->contextObj->updateData($id, $input);
            $data = Team::find($id);
            $data->products()
                ->sync($products); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified team from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('team');
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
            'description' => 'required|string|min:1|max:50',
            'name' => 'string|min:0|max:50|nullable'
        ];

        $this->validate($request, $validateFields);
    }
    
}