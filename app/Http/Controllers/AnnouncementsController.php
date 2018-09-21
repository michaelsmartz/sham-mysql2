<?php

namespace App\Http\Controllers;

use App\Announcement;
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
        //$data = $this->contextObj->getData(['announcement_status_id' => 'asc', 'end_date' => 'asc']);
        $announcements = $this->contextObj->getData(['announcement_status_id' => 'asc', 'end_date' => 'asc']);
        return view($this->baseViewPath .'.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $announcementStatuses = AnnouncementType::ddList();

        return view($this->baseViewPath . '.create', compact('data','announcementStatuses'));
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
        }

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','announcementStatuses'))
                    ->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('data','announcementStatuses'));
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

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

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