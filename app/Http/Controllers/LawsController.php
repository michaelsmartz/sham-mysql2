<?php

namespace App\Http\Controllers;

use App\Law;
use App\Country;
use App\LawCategory;
use App\Traits\MediaFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Exception;

class LawsController extends CustomController
{
    use MediaFiles;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Law();
        $this->baseViewPath = 'laws';
        $this->baseFlash = 'Law details ';
    }

    /**
     * Display a listing of the laws.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $laws = $this->contextObj::with(['country','lawCategory'])->filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('laws'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('description','id')->all();
        $lawCategories = LawCategory::pluck('description','id')->all();

        return view($this->baseViewPath . '.create', compact('data','countries','lawCategories'));
    }

    /**
     * Store a new law in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validator($request);

        $input = array_except($request->all(),array('_token'));

        $context = $this->contextObj->addData($input);

        $this->attach($request, $context->id);

        \Session::put('success', $this->baseFlash . 'created Successfully!');

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
        $data = $countries = $lawCategories = null;
        $id = Route::current()->parameter('law');
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $countries = Country::pluck('description','id')->all();
            $lawCategories = LawCategory::pluck('description','id')->all();
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','countries','lawCategories'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','countries','lawCategories'));
    }
    
    /**
     * Update the specified law in the storage.
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
     * Remove the specified law from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {

        try{
            $id = Route::current()->parameter('law');
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
            'main_heading' => 'required|string|min:1|max:100',
            'sub_heading' => 'nullable|string|min:0|max:100',
            'country_id' => 'nullable|numeric|min:0|max:4294967295',
            'law_category_id' => 'nullable',
            'content' => 'required|string|min:1|max:4294967295',
            'is_public' => 'nullable|boolean',
            'expires_on' => 'nullable|string|min:0'
        ];

        $this->validate($request, $validateFields);
    }


    
}
