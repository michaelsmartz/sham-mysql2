<?php

namespace App\Http\Controllers\Open;

use App\Candidate;
use App\Country;
use App\DisabilityCategory;
use App\Enums\PreferredNotificationType;
use App\Gender;
use App\Http\Controllers\Controller;
use App\ImmigrationStatus;
use App\MaritalStatus;
use App\Skill;
use App\Title;
use App\Traits\MediaFiles;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class CandidateController extends Controller
{
    use MediaFiles;

    public function __construct()
    {
        $this->contextObj = new Candidate();
        $this->baseFlash = 'Candidate details ';
        $this->middleware('auth:candidate',['only' => 'index','edit']);
        Debugbar::disable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('public.candidate-register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data
        $this->validate($request, [
          'email'         => [
              'required',
              'unique:candidates,email'
          ],
          'password'      => 'required|confirmed'
        ]);

        // store in the database
        $candidate = new Candidate;
        $candidate->email = $request->email;
        $candidate->password = bcrypt($request->password);
        $candidate->save();

        return redirect()->route('candidate.auth.login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        if(empty(Auth::guard('candidate')->user()->id)){
            return redirect()->route('candidate.auth.login');
        }else{
            $id = Auth::guard('candidate')->user()->id;
        }

        $candidate = $titles = $genders = $maritalstatuses = null;
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

            $candidate = $this->contextObj->findData($id);

            if (!isset($candidate->picture)) {
                $candidate->picture = asset('img/avatar.png');
            }
            $candidate->load(['skills','disabilities']);
            $qualifications = $candidate->qualifications;

            $titles                  = Title::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
            $genders                 = Gender::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
            $maritalstatuses         = MaritalStatus::withoutGlobalScope('system_predefined')->pluck('description','id')->all();
            $skills                  = Skill::pluck('description','id')->all();
            $disabilities            = DisabilityCategory::with('disabilities')->withGlobalScope('system_predefined',1)->get();
            $preferredNotifications  = PreferredNotificationType::ddList();
            $countries               = Country::orderBy('is_preferred','desc')->pluck('description','id')->all();
            $immigrationStatuses     = ImmigrationStatus::pluck('description','id')->all();
        }

        $candidateSkills       = $candidate->skills->pluck('id');
        $candidateDisabilities = $candidate->disabilities->pluck('id');

        return view('public.candidate-form',
            compact('candidate', 'uploader', 'titles','genders','maritalstatuses','jobTitles','skills', 'preferredNotifications',
                'disabilities', 'candidateSkills','candidateDisabilities','qualifications', 'countries', 'immigrationStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        return redirect()->route('candidate.vacancies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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
            'profile_pic',
            'profil_complete'
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

        //candidate has filled required informations
        $input['profil_complete'] = 1;

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
            'overview' => 'nullable|string|min:0',
            'cover' => 'nullable|string|min:0',
            'addr_line_1' => 'nullable|string|min:0|max:50',
            'addr_line_2' => 'nullable|string|min:0|max:50',
            'addr_line_3' => 'nullable|string|min:0|max:50',
            'addr_line_4' => 'nullable|string|min:0|max:50',
            'city' => 'nullable|string|min:0|max:50',
            'province' => 'nullable|string|min:0|max:50',
            'zip_code' => 'nullable|string|min:0|max:50'
        ];

        $this->validate($request, $validateFields);
    }
}