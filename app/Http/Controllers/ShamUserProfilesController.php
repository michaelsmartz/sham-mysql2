<?php

namespace App\Http\Controllers;

use App\ShamPermission;
use App\ShamUserProfile;
use App\SystemSubModule;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class ShamUserProfilesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new ShamUserProfile();
        $this->baseViewPath = 'sham_user_profiles';
        $this->baseFlash = 'Sham User Profile details ';
    }

    /**
     * Display a listing of the sham user profiles.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $shamUserProfiles = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('shamUserProfiles'));
    }

    /**
     * Store a new sham user profile in the storage.
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
        $id = Route::current()->parameter('sham_user_profile');
        $data = $this->contextObj->findData($id);

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data'));
    }

    /**
     * Update the specified sham user profile in the storage.
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
     * Remove the specified sham user profile from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('sham_user_profile');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Gets and Sets the permission matrix for user profiles
     * @param Request $request
     * @param $Id
     * @return mixed
     */
    public function matrix(Request $request, $Id)
    {
        $profile = ShamUserProfile::find($Id);

        if (!is_null($profile)) {
            if ($request->isMethod('patch')) {
                $sham_user_profile_pivot = [];
                foreach ($request->Permission as $system_sub_module_id => $permissions) {
                    foreach ($permissions as $permission_id => $permission) {

                        if($permission != 0) {
                            $sham_user_profile_pivot[] = [
                                'sham_user_profile_id' => $Id,
                                'sham_permission_id' => $permission_id,
                                'system_sub_module_id' => $system_sub_module_id,
                            ];
                        }
                    }
                }

                $profile->shamPermissions()->sync([]);
                $profile->shamPermissions()->sync($sham_user_profile_pivot);
                \Session::put('success','Permission Matrix updated Successfully!!');
                return redirect()->route($this->baseViewPath .'.index');
            }else {

                $permissionsUserProfilesArray = [];
                $permissions = [];
                $permissionMatrix = [];

                $permissionsUserProfiles = $profile->shamPermissions()->get(['sham_user_profile_id', 'sham_permission_id', 'system_sub_module_id'])->all();

                if (!is_null($permissionsUserProfiles)) {
                    foreach ($permissionsUserProfiles as $permissionsUserProfile) {
                        $permissionsUserProfilesArray[] = [
                            "Id" => $permissionsUserProfile->sham_user_profile_id,
                            "ShamPermissionId" => $permissionsUserProfile->sham_permission_id,
                            "SystemSubModuleId" => $permissionsUserProfile->system_sub_module_id
                        ];
                    }
                }

                //Get all SubModules
                $submodules = SystemSubModule::pluck('description', 'id')->all();

                //Get all Permissions
                $shamPermissions = ShamPermission::get(['id', 'alias', 'description'])->all();

                $count = 1;
                if (!is_null($shamPermissions)) {
                    foreach ($shamPermissions as $permission) {
                        $permissions[$count] = [
                            "Id" => $permission->id,
                            "alias" => $permission->alias,
                            "description" => $permission->description
                        ];

                        $count++;
                    }
                }

                //Build Matrix
                foreach ($submodules as $submoduleKey => $submoduleVal) {
                    foreach ($permissions as $permissionKey => $permissionVal) {
                        $permissionMatrix[$submoduleKey][$permissionKey] = 0;
                    }
                }

                //Update Matrix
                if (!is_null($permissionsUserProfiles)) {
                    foreach ($permissionsUserProfiles as $permissionsUserProfile) {
                        $permissionMatrix
                        [$permissionsUserProfile->system_sub_module_id]
                        [$permissionsUserProfile->sham_permission_id] = $permissionsUserProfile->sham_user_profile_id;
                    }
                }

                if ($request->ajax()) {
                    $view = view($this->baseViewPath . '.permissions', compact('profile', 'submodules', 'permissions', 'permissionMatrix'))->renderSections();
                    return response()->json([
                        'title' => $view['modalTitle'],
                        'content' => $view['modalContent'],
                        'footer' => $view['modalFooter'],
                        'url' => $view['postModalUrl']
                    ]);
                }
            }
            return view($this->baseViewPath . '.permissions', compact('profile', 'submodules', 'permissions', 'permissionMatrix'));
        }

    }

    /**
     * Validate the given request with the defined rules.
     *
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'name' => 'required|string|min:1|max:50',
            'description' => 'required|string|min:1|max:100'
        ];

        $this->validate($request, $validateFields);
    }
}