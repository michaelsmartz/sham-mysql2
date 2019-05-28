<?php

namespace App\Http\Controllers;

use App\Employee;
use App\ShamUserProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
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
        $employee_ids = Employee::pluck('full_name', 'id');
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
            $this->createValidator($request);

            $password = ['password' => bcrypt($request->get('password'))];

            $input = array_except($request->all(),array('_token','password'));

            $newInput = array_merge($input, $password);

            $this->contextObj->addData($newInput);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = Route::current()->parameter('user');
        if($id == 0){
            $id = \Auth::user()->id;
        }
        $data = $this->contextObj->findData($id);

        $sham_user_profile_ids = ShamUserProfile::pluck('name', 'id');
        $employee_ids = Employee::employeesLite()->whereNull('date_terminated')->pluck('first_name, surname as full_name', 'id');

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
            $this->editValidator($request);

            if(!is_null($request->get('password'))) {
                $password = ['password' => bcrypt($request->get('password'))];
            }else{
                $password['password'] = User::select('password')->where('id', $id)->get()->first()->password;
            }

            $input = array_except($request->all(),array('_token','_method', 'password'));

            $newInput = array_merge($input, $password);

            $this->contextObj->updateData($id, $newInput);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception);
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
    private function validator(Request $request, $validateFields)
    {
        $validator = Validator::make($request->all(), $validateFields);
        if($validator->fails()) {
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors($validator);
        }
    }

    /**
     * @param Request $request
     */
    protected function createValidator(Request $request)
    {
        $validateFields = [
            'username' => 'required|string|min:1|max:100',
            'password' => 'required|string|min:1|max:100',
            'email' => 'required|string|min:1|max:512',
        ];

       $this->validator($request, $validateFields);
    }

    /**
     * @param Request $request
     */
    protected function editValidator(Request $request)
    {
        $validateFields = [
            'username' => 'nullable',
            'email' => 'nullable',
            'password' => 'nullable|string|min:1|max:100',
            'cell_number' => 'nullable|string|min:1|max:20',
            'silence_start' => 'nullable',
            'silence_end' => 'nullable',
        ];

        $this->validator($request, $validateFields);
    }
}