<?php

namespace App\Http\Controllers;

use App\Employee;
use App\ShamUser;
use App\ShamUserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class ShamUsersController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new ShamUser();
        $this->baseViewPath = 'sham_users';
        $this->baseFlash = 'Sham User details ';
    }

    /**
     * Display a listing of the sham users.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $shamUsers = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('shamUsers'));
    }

    public function create() {
        $ShamUserProfileIds = ShamUserProfile::pluck('name', 'id');
        $employee_ids = Employee::pluck('name', 'id');
        return view($this->baseViewPath . '.create',compact('ShamUserProfileIds','employee_ids'));
    }

    /**
     * Store a new sham user in the storage.
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

    public function edit(Request $request)
    {
        $id = Route::current()->parameter('report_template');
        $data = $this->contextObj->findData($id);

        $ShamUserProfileIds = ShamUserProfile::pluck('name', 'id');
        $employee_ids = Employee::pluck('name', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'ShamUserProfileIds','employee_ids'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data', 'ShamUserProfileIds','employee_ids'));
    }

    /**
     * Update the specified sham user in the storage.
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

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified sham user from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('sham_user');
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
            'username' => 'required|string|min:1|max:100',
            'password' => 'nullable|string|min:1|max:100',
            'email_address' => 'nullable|string|min:1|max:512',
            'cell_number' => 'nullable|string|min:1|max:20',
            'silence_start' => 'nullable',
            'silence_end' => 'nullable',
        ];

        $this->validate($request, $validateFields);
    }
    
    
}