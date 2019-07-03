<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\CandidateInterviewer;
use App\Department;
use App\EmailAddress;
use App\Employee;
use App\EmployeeStatus;
use App\Enums\InterviewResultsType;
use App\Enums\InterviewStatusType;
use App\Enums\RecruitmentType;
use App\Contract;
use App\Interview;
use App\Offer;
use App\QualificationRecruitment;
use App\Recruitment;
use App\Skill;
use App\Support\Helper;
use App\SysConfigValue;
use App\SystemSubModule;
use App\TelephoneNumber;
use App\TimelineManager;
use Barryvdh\DomPDF\Facade as PDF;
use App\Traits\MediaFiles;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;
use Plank\Mediable\Media;
use Illuminate\Database\Eloquent\Builder;

class RecruitmentRequestsController extends CustomController
{
    use MediaFiles;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Recruitment();
        $this->baseViewPath = 'recruitment_requests';
        $this->baseFlash = 'Recruitment requests details ';
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $job_title = $request->get('job_title', null);

        if(!empty($job_title)){
            $request->merge(['job_title' => '%'.$job_title.'%']);
        }

        $description = $request->get('description', null);

        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $year_experience = $request->get('year_experience', null);

        if(!empty($year_experience)){
            $request->merge(['year_experience' => '%'.$year_experience.'%']);
        }

        $field_of_study = $request->get('field_of_study', null);

        if(!empty($field_of_study)){
            $request->merge(['field_of_study' => '%'.$field_of_study.'%']);
        }

        $start_date = $request->get('start_date', null);

        if(!empty($start_date)){
            $request->merge(['start_date' => '%'.$start_date.'%']);
        }

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_RECRUITMENT_REQUESTS);

        $requests = $this->contextObj::orderBy('start_date','DESC')->filtered()->paginate(10);

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('requests','allowedActions'));
    }

    public function create(){
        $skills = Skill::pluck('description','id')->all();
        $departments = Department::pluck('description','id')->all();
        $positions = EmployeeStatus::pluck('description','id')->all();
        $qualifications = QualificationRecruitment::pluck('description','id')->all();

        $recruitmentTypes = RecruitmentType::ddList();

        $interviewTypes = Interview::pluck('description','id')->all();

        $request = $this->contextObj;
        $_mode = 'create';

        return view($this->baseViewPath .'.create', compact('_mode', 'request', 'departments',
            'positions', 'qualifications', 'skills', 'interviewTypes','recruitmentTypes'));
    }

    /**
     * Store a new branch in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $this->saveRecruitmentRequest($request);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function edit(Request $request)
    {
        $data = $skills = $departments = $positions = $qualifications = $interviewTypes = $recruitmentTypes = null;
        $_mode = 'edit';
        $id = Route::current()->parameter('recruitment_request');

        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);

            $data->load(['skills','interviewTypes']);

            $skills = Skill::pluck('description','id')->all();
            $departments = Department::pluck('description','id')->all();
            $positions = EmployeeStatus::pluck('description','id')->all();
            $qualifications = QualificationRecruitment::pluck('description','id')->all();
            $recruitmentTypes = RecruitmentType::ddList();
            $interviewTypes = Interview::pluck('description','id')->all();
        }

        $recruitmentSkills = $data->skills->pluck('id');
        $recruitmentInterviewTypes = $data->interviewTypes->pluck('id');

        $processed = $this->checkIfAlreadyProcessed($id);

        if ($data->is_approved == true)
        {
            // show the view and pass the data to it
            return view($this->baseViewPath . '.show',
                compact('_mode', 'processed', 'data', 'departments', 'positions', 'qualifications',
                    'skills', 'interviewTypes', 'recruitmentTypes',
                    'recruitmentInterviewTypes', 'recruitmentSkills'));
        }
        else {
            // show the view and pass the data to it
            return view($this->baseViewPath . '.edit',
                compact('_mode', 'processed', 'data', 'departments', 'positions', 'qualifications',
                    'skills', 'interviewTypes', 'recruitmentTypes',
                    'recruitmentInterviewTypes', 'recruitmentSkills'));
        }
    }

    /**
     * Update the specified branch in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            $processed = $this->checkIfAlreadyProcessed($id);

            $data = Recruitment::find($id);

            if($data) {
                if ($data->is_approved == false && $processed == 0) {
                    $this->validator($request);
                    $this->saveRecruitmentRequest($request, $id);
                } else if($processed == 0) {
                    $data->is_approved = $request->is_approved;
                    $data->is_completed = $request->is_completed;
                    $data->save();
                }
            }

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    private function checkIfAlreadyProcessed($id){
        $data = Recruitment::find($id);

        if($data) {
            //check if status is not 0 (initial state) in pivot candidate_recruitment
            foreach ($data->candidates as $candidate) {
                //check if status is not 0 therefore meaning processed already start
                if ($candidate->pivot->status > 0)
                    return 1;
            }

            //check if recruitment has interview type in pivot candidate_interview_recruitment
            if ($data->interviews->count() == 0)
                return 0;

        }

        return 1;
    }

    public function manageCandidate(Request $request, $id){
        $data = $this->contextObj->findData($id);

        $recruitmentCandidates = $data->candidates()->orderBy('candidate_recruitment.id','asc')->pluck('first_name','candidate_recruitment.candidate_id');
        $candidates = Candidate::pluck('name', 'id');

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.manage-candidate', compact('data', 'candidates', 'recruitmentCandidates'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.manage-candidate', compact('data', 'candidates', 'recruitmentCandidates'));
    }

    public function updateCandidate(Request $request, $recruitment_id){
        try {
            $candidates = array_get($request->all(),'candidates');

            $recruitment = Recruitment::find($recruitment_id);

            if (!is_null($recruitment)) {

                $recruitment->candidates()->sync($candidates);

                //remove from three-way pivot table if not present candidate_recruitment
                $recruitment->interviews()
                    ->where('recruitment_id', $recruitment_id)
                    ->get()
                    ->each(function ($interview) use ($candidates, $recruitment_id) {
                        if (!in_array($interview->pivot->candidate_id, $candidates)) {
                            $interview->pivot->delete();
                        }
                    });


                //add if does not exist in three-way pivot table
                $interview_types = $recruitment->interviewTypes()->get()->all();
                $add_candidate_interview_recruitment_pivot = [];

                foreach ($candidates as $key => $candidate_id) {
                    $hasCandidate = $recruitment->interviews()->where('candidate_id', $candidate_id)->exists();

                    if(!$hasCandidate) {
                        foreach ($interview_types as $interview_type) {
                            $add_candidate_interview_recruitment_pivot[] = [
                                'candidate_id' => $candidate_id,
                                'interview_id' => $interview_type->id,
                                'recruitment_id' => $recruitment_id,
                            ];
                        }
                    }
                }

                $recruitment->interviews()->attach($add_candidate_interview_recruitment_pivot);

                \Session::put('success', $this->baseFlash . 'updated Successfully!!');
            }

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function updateStatus(Request $request, $id, $status){
        try {
            $data = Recruitment::find($id);

            if($data) {
                $data->is_approved = $status;
                $data->save();
            }
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }
        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Remove the specified branch from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('recruitment_request');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function getCandidates(Request $request)
    {
        $candidates = false;
        try {
            $id = Route::current()->parameter('recruitment_request');

            $data = $this->contextObj->findData($id);

            $candidates = $data->candidates()
                ->with(['media','jobTitle','previousEmployments','qualifications',
                    'status'=> function ($query) use ($id)
                    {
                        return  $query->where('recruitment_id', $id);
                    },
                    'interviews.media',
                    'recruitment_status',
                    'interviews'=> function ($query) use ($id)
                    {
                        return  $query->where('recruitment_id', $id);
                    },
                    'contracts'=> function ($query) use ($id)
                    {
                        return  $query->where('recruitment_id', $id);
                    },
                    'offers'=> function ($query) use ($id, $data)
                    {
                        return  $query->where('recruitment_id', '=', $id);
                    }
                ])
                ->get();

            foreach($candidates as $candidate){
                foreach ($candidate['interviews'] as $interview){
                    //send enum type description
                    $interview->pivot->results = InterviewResultsType::getDescription($interview->pivot->results);
                    $interview->pivot->status = InterviewStatusType::getDescription($interview->pivot->status);

                    $interviewMedias =
                        DB::table('mediables')
                            ->join('media', 'mediables.media_id', '=', 'media.id')
                            ->select('*')
                            ->where('mediables.mediable_id', $interview->pivot->id)
                            ->where('mediables.mediable_type', 'App\CandidateInterviewAttachments')
                            ->get()->toArray();

                    $interview->interviewMedias = $interviewMedias;
                }
            }

        } catch (Exception $exception) {
            dd($exception->getMessage());
        } finally {

            return Response()->json($candidates);
        }
    }

    public function getOfferLetters(Request $request) {
        try {

            $result = Offer::select(['description','id'])->get();

        } catch(Exception $exception) {

            $result = false;
        }

        return Response()->json($result);

    }

    public function getContracts(Request $request) {
        try {

            $result = Contract::select(['description','id'])->get();

        } catch(Exception $exception) {

            $result = false;
        }

        return Response()->json($result);

    }

    public function showStages(Request $request){
        $id = Route::current()->parameter('recruitment_request');

        if(!empty($id)) {
            // make 2 less queries
            $this->contextObj->with = [];

            $data = $this->contextObj->findData($id);
        }

        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload document files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "5", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];

        return view($this->baseViewPath .'.stages', compact('data','uploader'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function editInterview(Request $request)
    {
        $interview_id = Route::current()->parameter('interview');
        $recruitment_id = Route::current()->parameter('recruitment_request');
        $candidate_id = Route::current()->parameter('candidate');

        $data = $this->contextObj::find($recruitment_id);

        $candidateInterviewers = [];

        $interview = $data->interviews()
            ->where('recruitment_id', $recruitment_id)
            ->where('interview_id', $interview_id)
            ->where('candidate_id', $candidate_id)
            ->first();

        $pivot_table_id = $interview->pivot->id;

        $candidate_interviewers = DB::table('candidate_interviewers')->select('employee_id')->where('candidate_interview_recruitment_id', $pivot_table_id)->get()->all();

        foreach ($candidate_interviewers as $candidate_interviewer){
            $candidateInterviewers[] = $candidate_interviewer->employee_id;
        }

        $status = InterviewStatusType::ddList();
        $results = InterviewResultsType::ddList();
        $interviewers = Employee::pluck('full_name','id')->all();

        $uploader = [
            "fieldLabel" => "Add attachments...",
            "restrictionMsg" => "Upload document files",
            "acceptedFiles" => "['doc', 'docx', 'ppt', 'pptx', 'pdf']",
            "fileMaxSize" => "5", // in MB
            "totalMaxSize" => "6", // in MB
            "multiple" => "multiple" // set as empty string for single file, default multiple if not set
        ];

        if($request->ajax()) {
            $view = view('interview_requests.edit', compact('data','status','results','interview', 'interviewers', 'candidateInterviewers', 'recruitment_id', 'interview_id', 'candidate_id','uploader'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view('interview_requests.edit', compact('data','status','results','interview', 'interviewers', 'candidateInterviewers', 'recruitment_id', 'interview_id', 'candidate_id','uploader'));
    }

    /**
     * Update the specified branch in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function updateInterview(Request $request, $id)
    {
        try {
            $candidate_interviewers = [];
            $interviewers = array_only($request->all(),['interviewers']);
            $input = array_except($request->all(),array('_token','_method','attachment','schedule_at_submit','interviewers'));
            $data = Recruitment::find($id);

            $interview = $data->interviews()
                ->where('recruitment_id', $input['recruitment_id'])
                ->where('interview_id', $input['interview_id'])
                ->where('candidate_id', $input['candidate_id'])
                ->get()->first();

            $pivot_table_id = $interview->pivot->id;

            foreach ($interviewers['interviewers'] as $interviewer){
                $candidate_interviewers[] = ['candidate_interview_recruitment_id' => $pivot_table_id,
                                             'employee_id' => $interviewer
                                            ];
            }

            DB::statement('DELETE FROM candidate_interviewers WHERE candidate_interview_recruitment_id = '.$pivot_table_id);

            CandidateInterviewer::insert($candidate_interviewers);

            DB::table('candidate_interview_recruitment')
                ->where('id', $pivot_table_id)
                ->update($input);

            $this->attach($request, $pivot_table_id, 'CandidateInterviewAttachments');

            \Session::put('success', 'Interview updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not update Interview!');
        }

        return redirect()->route('recruitment_requests.stages',[$id]);
    }

    public function stateSwitch(Request $request){

        $id = intval(Route::current()->parameter('recruitment_request'));
        $candidate = intval(Route::current()->parameter('candidate'));
        $state = intval(Route::current()->parameter('state'));
        $result = true;

        $recruitment = Recruitment::find($id);
        $dataToSync = ['candidate_id' => $candidate, 'status' => $state];
        
        try{
            $recruitment->candidates()->updateExistingPivot($candidate, $dataToSync);
        } catch(Exception $exception) {
            $result = false;
        }
        
        return Response()->json($result);
    }

    public function downloadOffer(Request $request){

        $id = intval(Route::current()->parameter('recruitment_request'));
        $cdt = intval(Route::current()->parameter('candidate'));

        $startingOn = $request->get('starting_on');
        $offerId = $request->get('offer_id');

        $recruitment = Recruitment::with('department')->find($id);
        $candidate = Candidate::with('title')->find($cdt);
        $offer = Offer::find($offerId);
        $offerRecruitment = $recruitment->offers()->where([
            ['candidate_id', $cdt]
        ])->get()->first();

        $dataSet = ['candidate_id' => $cdt,
                    'recruitment_id' => $id,
                    'offer_id' => $offerId,
                    'starting_on' => $startingOn];
        if(is_null($offerRecruitment)) {
            DB::table('offer_recruitment')->insert($dataSet);
        } else {
            DB::table('offer_recruitment')->where(['id' => $offerRecruitment->pivot->id])->update($dataSet);
        }
        $recruitment->offers()->syncWithoutDetaching([$offerId =>
            ['candidate_id' => $cdt,
             'recruitment_id' => $id,
             'starting_on' => $startingOn]
        ]);

        $content = $this->getOfferContentInfo($recruitment, $candidate, $offer);

        try {

            $pdf = PDF::loadView('recruitments.offer-letter', compact('recruitment','candidate','content'))
                ->setPaper('a4', 'portrait');

        } catch(Exception $exception) {}
  
        return $pdf->download('offer letter.pdf');

    }

    public function downloadContract(Request $request){

        $id = intval(Route::current()->parameter('recruitment_request'));
        $cdt = intval(Route::current()->parameter('candidate'));

        $contractId = $request->get('contract_id');

        $recruitment = Recruitment::with('department')->find($id);
        $candidate = Candidate::with('title')->find($cdt);
        $contract = Contract::find($contractId);
        $contractRecruitment = $recruitment->contracts()->where([
            ['candidate_id', $cdt]
        ])->get()->first();

        $dataSet = ['candidate_id' => $cdt,
                    'recruitment_id' => $id,
                    'contract_id' => $contractId];
        if(is_null($contractRecruitment)) {
            DB::table('contract_recruitment')->insert($dataSet);
        } else {
            DB::table('contract_recruitment')->where(['id' => $contractRecruitment->pivot->id])->update($dataSet);
        }

        $content = $this->getOfferContentInfo($recruitment, $candidate, $contract);
            
        try {

            $pdf = PDF::loadView('recruitments.contract-document', compact('recruitment','candidate','content'))
                ->setPaper('a4', 'portrait');

        } catch(Exception $exception) {}

        return $pdf->download('contract.pdf');
    }

    public function downloadSignedOffer(Request $request){

        $id = intval(Route::current()->parameter('recruitment_request'));
        $candidateId = intval(Route::current()->parameter('candidate'));

        $offerId = $request->get('offer_id');

        $recruitment = Recruitment::find($id);
        $offer = Offer::find($offerId);
        
        $offerRecruitment = $recruitment->offers()->where([
                                ['candidate_id', $candidateId],
                                ['offer_id', $offerId]
                            ])->get()->first();

        // offer letter is signed, download the original, i.e. archived master copy
        $content = base64_decode(str_replace('data:application/pdf;base64,', '', $offerRecruitment->pivot->master_copy));

        try {

            return response()->pdf($content);

        } catch(Exception $exception) {}

    }

    public function downloadSignedContract(Request $request){

        $id = intval(Route::current()->parameter('recruitment_request'));
        $candidateId = intval(Route::current()->parameter('candidate'));

        $contractId = $request->get('contract_id');

        $recruitment = Recruitment::find($id);
        $contract = Contract::find($contractId);

        $contractRecruitment = $recruitment->contracts()->where([
                                ['candidate_id', $candidateId],
                                ['contract_id', $contractId]
                            ])->get()->first();

        // contract is signed, download the original, i.e. archived master copy
        $content = base64_decode(str_replace('data:application/pdf;base64,', '', $contractRecruitment->pivot->master_copy));
            
        try {
            return response()->pdf($content);
        } catch(Exception $exception) {}

        //return $pdf->download($recruitment->job_title . ' - ' . $candidate->name .'- offer letter.pdf');
        return $pdf->download('signed contract.pdf');
    }

    public function deleteInterviewMedia(Request $request){
        $media_id = $request->get('media_id');
        $mediable_id = $request->get('mediable_id');

        try {
            $model = "CandidateInterviewAttachments";
            $this->detachMedia($model, $mediable_id, $media_id);

        }catch(Exception $exception) {
            dd($exception->getMessage());
        }
    }

    private function detachMedia($model, $pivot_mediable_id, $mediaId)
    {
        $modelClass = 'App\\'.$model;
        $relatedMedias = $modelClass::find($pivot_mediable_id);

        $media = Media::find($mediaId);
        $media->delete();
        $relatedMedias->detachMedia($media);
    }

    public function updateInterviewComment(Request $request){
        $id = intval(Route::current()->parameter('recruitment_request'));
        $candidateId = intval(Route::current()->parameter('candidate'));
        $overallComment= $request->get('overallComment');
        $result = true;

        try{

            $dataSet = [
                    'recruitment_id'  => $id,
                    'candidate_id'    => $candidateId,
                    'status'       => 1,
                    'comment'       => $overallComment,
            ];

            $data = Recruitment::find($id);

            if($data) {
                $status = $data->status()->where(['recruitment_id'=>$id, 'candidate_id'=>$candidateId])->get()->first();

                if(is_null($status)) {
                    DB::table('recruitment_status')->insert($dataSet);
                } else {
                    DB::table('recruitment_status')->where(['id' => $status->pivot->id])->update($dataSet);
                }
            }


        } catch(Exception $exception) {
            $result = false;
        }

        return Response()->json($result);
    }

    public function downloadInterviewMedia(){
        $media_id = intval(Route::current()->parameter('media'));
        $mediable_id = null;

        try {
            return $this->download($mediable_id, $media_id);
        }catch(Exception $exception) {
            dd($exception->getMessage());
        }
    }

    public function importHiredCandidate(Request $request, $recruitment_id, $candidate_id){
        $result = true;

        $comments = $request->get('comments');
        $employee_no = $request->get('employee_no');

        try{
            if(!is_null($candidate_id)){
                $candidate = Candidate::find($candidate_id);

                if($candidate) {
                    $candidate->employee_no = $employee_no;
                    $candidate->save();


                    $candidate_arr = $candidate->ToArray();

                    $sfeCode = SysConfigValue::where('key', '=', 'LATEST_SFE_CODE')->first();

                    if ($sfeCode !== null) {
                        $candidate_arr['employee_code'] = $this->increment($sfeCode->value);
                        $candidate_arr['employee_no'] = $employee_no;
                        $sfeCode->value = $candidate_arr['employee_code'];
                    }
                    $sfeCode->save();

                    $data_employee = array_except($candidate_arr,
                        ['addr_line_1',
                            'addr_line_2',
                            'addr_line_3',
                            'addr_line_4',
                            'city',
                            'province',
                            'zip',
                            'preferred_notification_id',
                            'created_at',
                            'updated_at',
                            'deleted_at',
                            'name',
                        ]);

                    $data_address = array_except($candidate_arr, [
                        'id',
                        'title_id',
                        'gender_id',
                        'marital_status_id',
                        'job_title_id',
                        'first_name',
                        'surname',
                        'email',
                        'id_number',
                        'phone',
                        'date_available',
                        'salary_expectation',
                        'preferred_notification_id',
                        'birth_date',
                        'overview',
                        'cover',
                        'picture',
                        'employee_code',
                        'employee_no',
                        'created_at',
                        'updated_at',
                        'deleted_at',
                        'name'
                    ]);

                    $recruitment_status = [
                      'recruitment_id' =>  $recruitment_id,
                      'candidate_id' =>  $candidate_id,
                      'comment' => $comments
                    ];

                    $employee = new Employee();

                    $all_employees = Employee::all()->toArray();

                    //if employee_no already exist update else insert
                    if (in_array($data_employee['employee_no'], array_column($all_employees, 'employee_no'))) { // search value in the array
                        DB::table('recruitment_status')
                            ->where('recruitment_id', $recruitment_id)
                            ->where('candidate_id', $candidate_id)
                            ->update($recruitment_status);

                        $data = Employee::where('employee_no', $data_employee['employee_no'])->get()->first();

                        $data->update($data_employee);
                        TimelineManager::updateEmployeeTimelineHistory($data);

                    } else {
                        DB::table('recruitment_status')
                            ->insert($recruitment_status);

                        $data = $employee->addData($data_employee);
                        TimelineManager::addEmployeeTimelineHistory($data);
                    }

                    if(empty($candidate_arr['phone'])) {
                        TelephoneNumber::where('employee_id', '=', $data->id)->delete();
                    }
                    if(!empty($candidate_arr['phone'])){
                        $data->phones()
                            ->updateOrCreate(['employee_id'=>$data->id, 'telephone_number_type_id'=>1],
                                ['tel_number' =>  $candidate_arr['phone']]);
                    }

                    if(!isset($candidate_arr['email'])) {
                        EmailAddress::where('employee_id', '=', $data->id)->delete();
                    }
                    if(!empty($candidate_arr['email'])) {
                        $data->emails()
                            ->updateOrCreate(['employee_id'=>$data->id, 'email_address_type_id'=>1],
                                ['email_address' => $candidate_arr['email']]);
                    }

                    $data->addresses()
                        ->updateOrCreate(['employee_id'=>$data->id, 'address_type_id'=>1],
                            $data_address);
                }
            }
        } catch(Exception $exception) {
            return false;
        }
        return Response()->json($result);
    }

    protected function increment($string) {
        return preg_replace_callback('/^([^0-9]*)([0-9]+)([^0-9]*)$/', array($this, "subfunc"), $string);
    }

    protected function subfunc($m) {
        return $m[1].str_pad($m[2]+1, strlen($m[2]), '0', STR_PAD_LEFT).$m[3];
    }

    public function uploadSignedOfferForm(Request $request){

        $recruitment_id = intval(Route::current()->parameter('recruitment_request'));
        $candidate_id = intval(Route::current()->parameter('candidate'));
        $offer_id = intval(Route::current()->parameter('offer'));

        $data = $this->contextObj::find($recruitment_id);

        $uploader = [
            "fieldLabel" => "Add signed offer letter...",
            "restrictionMsg" => "Upload 1 document file",
            "acceptedFiles" => "['pdf']",
            "fileMaxSize" => "2", // in MB
            "totalMaxSize" => "2", // in MB
            "multiple" => "" // set as empty string for single file, default multiple if not set
        ];

        if($request->ajax()) {
            $view = view('recruitments.upload-signed-offer', compact('data', 'recruitment_id', 'candidate_id', 'offer_id', 'uploader'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view('recruitments.upload-signed-offer', compact('data', 'recruitment_id', 'candidate_id', 'offer_id', 'uploader'));

    }

    public function uploadSignedContractForm(Request $request){

        $recruitment_id = intval(Route::current()->parameter('recruitment_request'));
        $candidate_id = intval(Route::current()->parameter('candidate'));
        $contract_id = intval(Route::current()->parameter('contract'));

        $data = $this->contextObj::find($recruitment_id);

        $uploader = [
            "fieldLabel" => "Add signed contract...",
            "restrictionMsg" => "Upload 1 document file",
            "acceptedFiles" => "['pdf']",
            "fileMaxSize" => "2", // in MB
            "totalMaxSize" => "2", // in MB
            "multiple" => "" // set as empty string for single file, default multiple if not set
        ];

        if($request->ajax()) {
            $view = view('recruitments.upload-signed-contract', compact('data', 'recruitment_id', 'candidate_id', 'contract_id', 'uploader'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view('recruitments.upload-signed-contract', compact('data', 'recruitment_id', 'candidate_id', 'contract_id', 'uploader'));

    }

    public function saveSignedContractForm(Request $request){
        try {
            $input = array_except($request->all(),array('_token','_method','contract_signed_on_submit'));

            $data = Recruitment::with('contracts')->find($input['recruitment_id']);
            $contractRecruitment = $data->contracts()->where([
                ['candidate_id', '=', $input['candidate_id']],
                ['contract_id', '=', $input['contract_id']]
            ])->get()->first();

            if($contractRecruitment) {
                $contractRecruitment->pivot->signed_on = $input['contract_signed_on'];
                $contractRecruitment->pivot->comments = $input['comments'];
                $contractRecruitment->pivot->master_copy = $input['attachment'][0]['value'];
                $contractRecruitment->pivot->save();

                $this->attach($request, $contractRecruitment->pivot->id, 'ContractRecruitmentAttachments');
            }

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        \Session::put('success', 'Contract updated Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');
    }

    public function saveSignedOfferForm(Request $request){
        try {

            $input = array_except($request->all(),array('_token','_method','offer_signed_on_submit'));

            $data = Recruitment::with('offers')->find($input['recruitment_id']);
            $offerRecruitment = $data->offers()->where([
                ['candidate_id', '=', $input['candidate_id']],
                ['offer_id', '=', $input['offer_id']]
            ])->get()->first();
            
            if($offerRecruitment) {
                $offerRecruitment->pivot->signed_on = $input['offer_signed_on'];
                $offerRecruitment->pivot->comments = $input['comments'];
                $offerRecruitment->pivot->master_copy = $input['attachment'][0]['value'];
                $offerRecruitment->pivot->save();
            }
            

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        \Session::put('success', 'Offer updated Successfully!!');

        return redirect()->route($this->baseViewPath .'.index');
    }

    protected function saveRecruitmentRequest($request, $id = null) {

        $employee_id  = (\Auth::check()) ? \Auth::user()->employee_id : 0;

        $otherFields = [
            '_token',
            '_method',
            'redirectsTo',
            'start_date_submit',
            'end_date_submit',
            'skills',
            'interview_types'
        ];
        foreach($otherFields as $field){
            ${$field} = array_get($request->all(), $field);
        }

        $input = array_except($request->all(), $otherFields);
        $input['employee_id'] = $employee_id;

        if ($id == null) { // Create
            $data = $this->contextObj->addData($input);
        } else { // Update
            $this->contextObj->updateData($id, $input);
            $data = Recruitment::find($id);
        }

        if($data) {
            $data->skills()->sync($skills);
            $data->interviewTypes()->sync($interview_types);
        }
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
            'job_title' => 'required|string|min:0|max:50',
            'employee_status_id' => 'nullable',
            'department_id' => 'nullable',
            'employee_id' => 'nullable',
            'year_experience' => 'nullable',
            'qualification_id' => 'nullable',
            'field_of_study' => 'required|string|min:0|max:50',
            'recruitment_type_id' => 'nullable',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
            'quantity' => 'nullable',
            'min_salary' => 'nullable',
            'max_salary' => 'nullable',
            'description' => 'nullable|string|min:0',
        ];

        $this->validate($request, $validateFields);
    }

    protected function getOfferContentInfo($recruitmentobj,$candidateobj, $offerobj){

        $content = $offerobj->content;
        //dump($candidateobj);
        //title, name, phoneno, addressline1, addressline2, addressline3, addressline4, city, provinde, zipcode
        //Job Title, department

        $candidate_title = $candidateobj->title->description;
        $candidate_name = $candidateobj->first_name . ' ' .$candidateobj->surname;
        $candidate_phone_no = $candidateobj->phone;
        $candidate_addr_1 = $candidateobj->addr_line_1;
        $candidate_addr_2 = $candidateobj->addr_line_2;
        $candidate_addr_3 = $candidateobj->addr_line_3;
        $candidate_addr_4 = $candidateobj->addr_line_4;
        $candidate_city = $candidateobj->city;
        $candidate_province = $candidateobj->province;
        $candidate_zip = $candidateobj->zip;

        $recruitment_jobtitle = $recruitmentobj->job_title;
        $recruitment_department = $recruitmentobj->department->description;

        $content = str_replace('[[recruitment Job Title]]', $recruitment_jobtitle, $content);
        $content = str_replace('[[recruitment Department]]', $recruitment_department, $content);
        $content = str_replace('[[candidate Title]]', $candidate_title, $content);
        $content = str_replace('[[candidate Name]]', $candidate_name, $content);
        $content = str_replace('[[candidate Phone Number]]', $candidate_phone_no, $content);
        $content = str_replace('[[candidate Address Line 1]]', $candidate_addr_1, $content);
        $content = str_replace('[[candidate Address Line 2]]', $candidate_addr_2, $content);
        $content = str_replace('[[candidate Address Line 3]]', $candidate_addr_3, $content);
        $content = str_replace('[[candidate Address Line 4]]', $candidate_addr_4, $content);
        $content = str_replace('[[candidate City]]', $candidate_city, $content);
        $content = str_replace('[[candidate Province]]', $candidate_province, $content);
        $content = str_replace('[[candidate Zip code]]', $candidate_zip, $content);

        return $content;
    }
}
