<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\DisabilityCategory;
use App\Gender;
use App\MaritalStatus;
use App\Qualification;
use App\Skill;
use App\Support\Helper;
use App\SystemSubModule;
use App\Title;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;

class CandidatesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Candidate();
        $this->baseViewPath = 'candidates';
        $this->baseFlash = 'Candidate details ';
    }

    /**
     * Display a listing of the candidates.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_RECRUITMENT_CANDIDATES);

        $candidates = [];

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }
        return view($this->baseViewPath .'.index', compact('candidates','allowedActions'));
    }

    public function create(){

        if(!isset($this->contextObj->picture)){
            $this->contextObj->picture = asset('/img/avatar.png');
        }

        $titles = Title::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $genders = Gender::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $maritalstatuses = MaritalStatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();

        $disabilities = DisabilityCategory::with('disabilities')->withGlobalScope('system_predefined',1)->get();

        $skills = Skill::pluck('description','id')->all();

        return view($this->baseViewPath .'.create', compact('titles', 'genders', 'maritalstatuses', 'disabilities', 'skills'));
    }

    public function qualifications(Request $request)
    {
        $id = intval(Route::current()->parameter('candidate'));
        $result = Qualification::where('employee_id', $id)->get();

        return Response()->json($result);
    }

    /**
     * Store a new candidate in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            //$this->validator($request);
            dd($request);

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
        $id = Route::current()->parameter('candidate');
        $data = $this->contextObj->findData($id);

        $requests = [];

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('requests','data'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit', compact('requests','data'));
    }

    /**
     * Update the specified candidate in the storage.
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
     * Remove the specified candidate from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('candidate');
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
        $validateFields = [];
//        $validateFields = [
//            'title_id' => 'required',
//            'profile_pic' => 'nullable|string|min:0|max:10',
//            'first_name' => 'required|string|min:0|max:50',
//            'surname' => 'required|string|min:0|max:50',
//            'known_as' => 'nullable|string|min:0|max:50',
//            'birth_date' => 'required|date_format:Y-m-d',
//            'marital_status_id' => 'nullable',
//            'id_number' => 'required|string|min:1|max:50',
//            'passport_country_id' => 'nullable|numeric|min:0|max:4294967295',
//            'nationality' => 'nullable|string|min:0|max:50',
//            'language_id' => 'nullable|numeric|min:0|max:4294967295',
//            'gender_id' => 'nullable',
//            'ethnic_group_id' => 'nullable',
//            'immigration_status_id' => 'nullable',
//            'time_group_id' => 'nullable',
//            'passport_no' => 'nullable|string|min:0|max:50',
//            'spouse_full_name' => 'nullable|string|min:0|max:50',
//            'employee_no' => 'required|string|min:1|max:50',
//            'employee_code' => 'nullable|string|min:1|max:50',
//            'tax_status_id' => 'nullable',
//            'tax_number' => 'required_if:tax_status_id,3|min:0|max:50',
//            'date_joined' => 'nullable|string|min:0',
//            'date_terminated' => 'nullable|string|min:0',
//            'department_id' => 'required',
//            'team_id' => 'required',
//            'employee_status_id' => 'nullable',
//            'physical_file_no' => 'nullable|string|min:0|max:50',
//            'job_title_id' => 'nullable',
//            'division_id' => 'nullable',
//            'branch_id' => 'nullable',
//            'picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
//            'line_manager_id' => 'nullable|numeric|min:0|max:4294967295'
//        ];

        $this->validate($request, $validateFields);
    }
}