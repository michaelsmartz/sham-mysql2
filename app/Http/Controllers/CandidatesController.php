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
use App\Traits\MediaFiles;
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
    use MediaFiles;
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
            $this->validator($request);

            $this->saveCandidate($request);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    protected function saveCandidate($request, $id = null) {

        $otherFields = [
            '_token',
            '_method',
            'attachment',
            'redirectsTo',
            'date_available_submit',
            'birth_date_submit',
            'skills',
            'disabilities',
            'qualifications',
            'previous_employments'
        ];
        foreach($otherFields as $field){
            ${$field} = array_get($request->all(), $field);
        }

        $input = array_except($request->all(), $otherFields);
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $contents = 'data:' . $image->getMimeType() .';base64,' .base64_encode(file_get_contents($image->getRealPath()));
            $input['picture'] = $contents;
        }

        if ($id == null) { // Create
            $data = $this->contextObj->addData($input);
        } else { // Update
            $this->contextObj->updateData($id, $input);
            $data = Candidate::find($id);
        }

        $this->attach($request, $data->id);

        if(isset($qualifications)){
            foreach($qualifications as $qual){
                $data->qualifications()
                    ->updateOrCreate(['candidate_id'=>$data->id], $qual);
            }
        }

        if(isset($previous_employments)){
            foreach($previous_employments as $employ){
                $data->previousEmployments()
                    ->updateOrCreate(['candidate_id'=>$data->id], $employ);
            }
        }

        $data->skills()->sync($skills);
        $data->disabilities()->sync($disabilities);

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
        $validateFields = [
            'picture' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'birth_date' => 'required|date_format:Y-m-d',
            'gender_id' => 'nullable',
            'preferred_notification_id' => 'nullable',
            'title_id' => 'required',
            'marital_status_id' => 'nullable',
            'first_name' => 'required|string|min:0|max:50',
            'surname' => 'required|string|min:0|max:50',
            'home_address' => 'required|string|min:0|max:50',
            'email' => 'nullable',
            'phone' => 'nullable',
            'id_number' => 'required|string|min:1|max:50',
            'position_applying_for' => 'required|string|min:1|max:50',
            'date_available' => 'nullable|string|min:0',
            'salary_expectation' => 'nullable|numeric|min:0',
            'overview' => 'nullable|string|min:0',
            'cover' => 'nullable|string|min:0',
        ];

        $this->validate($request, $validateFields);
    }
}