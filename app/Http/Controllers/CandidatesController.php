<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\CandidatePreviousEmployment;
use App\CandidateQualification;
use App\Country;
use App\DisabilityCategory;
use App\Enums\PreferredNotificationType;
use App\Gender;
use App\ImmigrationStatus;
use App\JobTitle;
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $first_name = $request->get('first_name', null);

        if(!empty($first_name)){
            $request->merge(['first_name' => '%'.$first_name.'%']);
        }

        $surname = $request->get('surname', null);

        if(!empty($surname)){
            $request->merge(['surname' => '%'.$surname.'%']);
        }

        $email = $request->get('email', null);

        if(!empty($email)){
            $request->merge(['email' => '%'.$email.'%']);
        }

        $phone = $request->get('phone', null);

        if(!empty($phone)){
            $request->merge(['phone' => '%'.$phone.'%']);
        }

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_RECRUITMENT_CANDIDATES);

        $candidates = $this->contextObj::filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('candidates','allowedActions'));
    }

    public function create(){

        $uploader = [
            "fieldLabel" => "Attach Files",
            "restrictionMsg" => "Upload document files in the format doc, docx, ppt, pptx, pdf",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "1.2", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];

        if(!isset($this->contextObj->picture)){
            $this->contextObj->picture = asset('/img/avatar.png');
        }

        $titles = Title::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $genders = Gender::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $maritalstatuses = MaritalStatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
        $countries = Country::orderBy('is_preferred','desc')->pluck('description','id')->all();
        $immigrationStatuses = ImmigrationStatus::pluck('description','id')->all();

        $disabilities = DisabilityCategory::with('disabilities')->withGlobalScope('system_predefined',1)->get();

        $skills = Skill::pluck('description','id')->all();

        $preferredNotifications = PreferredNotificationType::ddList();

        $candidate = $this->contextObj;

        return view($this->baseViewPath .'.create', compact('titles', 'candidate', 'uploader', 'genders',
            'maritalstatuses', 'countries', 'immigrationStatuses', 'disabilities', 'skills', 'preferredNotifications'));
    }

    public function qualifications(Request $request)
    {
        $id = intval(Route::current()->parameter('candidate'));
        $result = CandidateQualification::where('candidate_id', $id)->get();

        return Response()->json($result);
    }

    public function previousEmployments(Request $request)
    {
        $id = intval(Route::current()->parameter('candidate'));
        $result = CandidatePreviousEmployment::where('candidate_id', $id)->get();

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
            'previous_employments',
            'picture',
            'profile_pic'
        ];
        foreach($otherFields as $field){
            ${$field} = array_get($request->all(), $field);
        }

        $input = array_except($request->all(), $otherFields);
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
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

        //dd($qualifications);

        $data->qualifications()->delete();
        if(isset($qualifications)){
            foreach($qualifications as $qual){
                $data->qualifications()->withTrashed()
                    ->updateOrCreate(['candidate_id'=>$data->id, 'reference'=>$qual['reference']], $qual);
            }
        }

        $data->previousEmployments()->delete();
        if(isset($previous_employments)){
            foreach($previous_employments as $employ){
                $data->previousEmployments()->withTrashed()
                    ->updateOrCreate(['candidate_id'=>$data->id, 'previous_employer'=>$employ['previous_employer']], $employ);
            }
        }

        $data->skills()->sync($skills);
        $data->disabilities()->sync($disabilities);

    }

    public function edit(Request $request)
    {

        $data = $titles = $genders = $maritalstatuses = null;
        $id = Route::current()->parameter('candidate');

        $uploader = [
            "fieldLabel" => "Attach Files",
            "restrictionMsg" => "Upload document files in the format doc, docx, ppt, pptx, pdf",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "1.2", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];

        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);

            if (!isset($data->picture)) {
                $data->picture = asset('img/avatar.png');
            }
            $data->load(['skills','disabilities']);

            $qualifications = $data->qualifications;

            $titles = Title::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
            $genders = Gender::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
            $maritalstatuses = MaritalStatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
            $skills = Skill::pluck('description','id')->all();
            $disabilities = DisabilityCategory::with('disabilities')->withGlobalScope('system_predefined',1)->get();
            $preferredNotifications = PreferredNotificationType::ddList();
            $countries = Country::orderBy('is_preferred','desc')->pluck('description','id')->all();
            $immigrationStatuses = ImmigrationStatus::pluck('description','id')->all();
        }

        $candidateSkills = $data->skills->pluck('id');

        $candidateDisabilities = $data->disabilities->pluck('id');

        return view($this->baseViewPath .'.edit',
            compact('data', 'uploader', 'titles','genders','maritalstatuses','jobTitles','skills', 'preferredNotifications',
                'disabilities', 'candidateSkills','candidateDisabilities','qualifications', 'countries', 'immigrationStatuses'));
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

            $this->saveCandidate($request, $id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
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
            'immigration_status_id' => 'nullable',
            'passport_country_id' => 'nullable',
            'passport_no' => 'nullable',
            'nationality' => 'nullable',
            'notice_period' => 'nullable',
            'first_name' => 'required|string|min:0|max:50',
            'surname' => 'required|string|min:0|max:50',
            'email' => 'nullable',
            'phone' => 'nullable',
            'id_number' => 'required|string|min:1|max:50',
            'date_available' => 'nullable|string|min:0',
            'salary_expectation' => 'nullable|numeric|min:0',
            'overview' => 'nullable|string|min:0',
            'cover' => 'nullable|string|min:0',
            'addr_line_1' => 'nullable|string|min:0|max:50',
            'addr_line_2' => 'nullable|string|min:0|max:50',
            'addr_line_3' => 'nullable|string|min:0|max:50',
            'addr_line_4' => 'nullable|string|min:0|max:50',
            'city' => 'nullable|string|min:0|max:50',
            'province' => 'nullable|string|min:0|max:50',
            'zip' => 'nullable|string|min:0|max:50'
        ];

        $this->validate($request, $validateFields);
    }
}