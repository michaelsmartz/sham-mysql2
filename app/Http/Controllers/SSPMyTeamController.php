<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class SSPMyTeamController extends Controller
{
    public function __construct()
    {
        $this->contextObj   = new User();
        $this->baseViewPath = 'selfservice-portal.team';
        $this->baseRoute    = "my-team";
        $this->baseFlash    = "Team member ";
    }

    /**
     * Display a listing of the employee's leaves.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $employee_id = (\Auth::check()) ? \Auth::user()->employee_id : 0;
        $employees   = EmployeesController::getManagerEmployees($employee_id);
        return view($this->baseViewPath .'.index',compact('employees'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $id = Route::current()->parameter('my_team');
        if($id == 0){
            $id = \Auth::user()->id;
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('id'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('id'));
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
                $password['password'] = User::select(['id','password'])->where('id', $id)->get()->first()->password;
            }

            $this->contextObj->updateData($id, $password);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception);
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
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
    protected function editValidator(Request $request)
    {
        $validateFields = [
            'password' => 'nullable|string|min:1|max:100'
        ];

        $this->validator($request, $validateFields);
    }

}
