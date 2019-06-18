<?php

namespace App\Http\Controllers;

use App\Disability;
use App\DisabilityCategory;
use App\Enums\DisabilityCategoryType;
use App\Support\Helper;
use App\SystemSubModule;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;

class DisabilitiesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Disability();
        $this->baseViewPath = 'disabilities';
        $this->baseFlash = 'Disability details ';
    }

    /**
     * Display a listing of the disabilities.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $disabilities = $this->contextObj::with(['disabilityCategory'])->filtered()->paginate(10);

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_DISABILITY);

        // handle empty result bug
        if (Input::has('page') && $disabilities->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('disabilities','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $disabilityCategories= DisabilityCategory::withoutGlobalScope('system_predefined')
            ->pluck('description', 'id');

        return view($this->baseViewPath . '.create', compact('data','disabilityCategories'));
    }

    /**
     * Store a new disability in the storage.
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $data = null;
        $id = Route::current()->parameter('disability');
        $data = $this->contextObj->findData($id);

        $disabilityCategories= DisabilityCategory::withoutGlobalScope('system_predefined')
            ->pluck('description', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'disabilityCategories'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data', 'disabilityCategories'));
    }

    /**
     * Update the specified disability in the storage.
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
            
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));
            
            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified disability from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('disability');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
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
            'description' => 'required|string|min:1|max:100',
            'disability_category_id' => 'required|string'
        ];        

        $this->validate($request, $validateFields);
    }

}