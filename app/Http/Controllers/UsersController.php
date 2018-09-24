<?php

namespace App\Http\Controllers;

use App\Employee;
use App\ShamUserProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class UsersController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new User();
        $this->baseViewPath = 'users';
        $this->baseFlash = 'User details ';
    }

    /**
     * Display a listing of the users.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        //$users = $this->contextObj::filtered()->paginate(10);
        $users = $this->contextObj::with('shamUserProfile','employee')->filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('users'));
    }

    public function create() {
        $sham_user_profile_ids = ShamUserProfile::pluck('name', 'id');
        $employee_ids = Employee::pluck('first_name, surname as full_name', 'id');
        return view($this->baseViewPath . '.create',compact('sham_user_profile_ids','employee_ids'));
    }

    /**
     * Store a new user in the storage.
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
        $id = Route::current()->parameter('user');
        $data = $this->contextObj->findData($id);

        $sham_user_profile_ids = ShamUserProfile::pluck('name', 'id');
        $employee_ids = Employee::pluck('first_name, surname as full_name', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data', 'sham_user_profile_ids', 'employee_ids'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data', 'sham_user_profile_ids', 'employee_ids'));
    }

    /**
     * Update the specified user in the storage.
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

        return redirect()->back();
    }

    /**
     * Remove the specified user from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('user');
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
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'username' => 'required|string|min:1|max:100',
            'password' => 'nullable|string|min:1|max:100',
            'email' => 'nullable|string|min:1|max:512',
            'cell_number' => 'nullable|string|min:1|max:20',
            'silence_start' => 'nullable',
            'silence_end' => 'nullable',
        ];

        $this->validate($request, $validateFields);
    }
    
}