<?php

namespace App\Http\Controllers;

use App\Policy;
use App\PolicyCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;

class PoliciesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Policy();
        $this->baseViewPath = 'policies';
        $this->baseFlash = 'Policy details ';
    }

    /**
     * Display a listing of the policies.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $policies = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('policies'));
    }

    /**
     * Store a new policy in the storage.
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
     * Update the specified policy in the storage.
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
     * Remove the specified policy from the storage.
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
                    'title' => 'required|string|min:1|max:100',
            'content' => 'required|string|min:1|max:4294967295',
            'policy_category_id' => 'nullable',
            'expires_on' => 'nullable|string|min:0',
     
        ];
        

        $this->validate($request, $validateFields);
    }

    
}
