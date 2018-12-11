<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Department;
use App\SystemSubModule;
use App\Enums\AnnouncementType;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
//use App\Support\Collection;
use Exception;

class AnnouncementsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Announcement();
        $this->baseViewPath = 'announcements';
        $this->baseFlash = 'Announcement details ';
    }

    /**
     * Display a listing of the announcements.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $announcements = $this->contextObj->getData(['announcement_status_id' => 'asc', 'end_date' => 'asc']);

        $allowedActions = getAllowedActions(SystemSubModule::CONST_ANNOUNCEMENTS);

        // handle empty result bug
        if (Input::has('page') && $announcements->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('announcements','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $announcementStatuses = AnnouncementType::ddList();
        $departments = Department::pluck('description', 'id');

        return view($this->baseViewPath . '.create', compact('data','announcementStatuses', 'departments'));
    }

    /**
     * Store a new announcement in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $departments = array_get($request->all(),'departments');

            $input = array_except($request->all(),array('_token', 'departments'));

            $data = $this->contextObj->addData($input);
            $data->departments()
                ->sync($departments); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {

            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

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
        $data = $announcementStatuses = null;
        $id = Route::current()->parameter('announcement');
        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
            $announcementStatuses = AnnouncementType::ddList();
            $announcementDepartments = $data->departments()
                ->orderBy('announcement_department.id','asc')
                ->pluck('description', 'announcement_department.department_id');
            $departments = Department::pluck('description', 'id');
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit',
                compact('data','announcementStatuses', 'announcementDepartments', 'departments'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit',
            compact('data','announcementStatuses', 'announcementDepartments', 'departments'));
    }

    /**
     * Update the specified announcement in the storage.
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

            $departments = array_get($request->all(),'departments');

            $input = array_except($request->all(),array('_token','_method','departments'));

            $this->contextObj->updateData($id, $input);
            $data = Announcement::find($id);
            $data->departments()
                ->sync($departments); //sync what has been selected

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {

            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->back(); //route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified announcement from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('announcement');
            $data = Announcement::find($id);
            $data->departments()->sync([]); //detach all linked course modules
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back(); //route($this->baseViewPath .'.index');
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
            'title' => 'required|string|min:1|max:50',
            'description' => 'required|string|min:1|max:256',
            'start_date' => 'required|string|min:0|max:4294967295',
            'end_date' => 'required|string|min:0',
            'announcement_status_id' => 'required|string|min:1|max:1'
        ];

        $this->validate($request, $validateFields);
    }

}