<?php

namespace App\Http\Controllers\Open;

use App\Employee;
use Auth;
use App\Candidate;
use App\Recruitment;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class RecruitmentsController extends Controller
{
    protected $contextObj;
    protected $baseViewPath;

    public function __construct() {
        Debugbar::disable();
        $this->contextObj = new Recruitment();
        $this->baseViewPath = 'public';
    }

    public function publicHome() {
        $candidateId = Auth::guard('candidate')->check() ? Auth::guard('candidate')->user()->id :0;

        $recruitmentId = Route::current()->parameter('recruitment_id');

        $candidateFilter = function ($q) use ($candidateId) {
            $q->where('candidate_id', $candidateId);
        };

        $a = $this->contextObj::with(['department', 'employeeStatus', 'qualification', 'skills'
        ])->where('is_approved', '=', 1)
        ->where('end_date', '>=', Carbon::now()->endOfDay()->toDateTimeString())
        ->whereIn('recruitment_type_id', [2, 3])
        ->orderBy('posted_on', 'desc');

        $b = $this->contextObj::with([
            'department', 'employeeStatus', 'qualification', 'skills',
            'candidates' => function ($query) use ($candidateId) {
                return $query->where('candidate_id', $candidateId);
            }
        ])->whereIn('recruitment_type_id', [2, 3])
          /*->where('end_date', '<', Carbon::yesterday()->endOfDay()->toDateTimeString())*/;

        if($candidateId == 0){
            $vacancies = $a->get();
        } else {
            $vacancies = $b->get();

            $filtered = $vacancies->reject(function ($value) {
                
                $dtEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $value->end_date);
                $dt = Carbon::now('UTC');
                if($dt->greaterThan($dtEndDate) && $value->candidates->count() == 0){
                    return true;
                }
            });

            $vacancies = $filtered;
        }

        foreach($vacancies as $vacancy) {
            $vacancy->posted_on = Carbon::createFromTimeStamp(strtotime($vacancy->posted_on))->diffForHumans();
            $dt = Carbon::now('UTC');
            $dtEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $vacancy->end_date);
            $diff = $dt->diffInHours($dtEndDate, false);

            $vacancy->dateOk = true;
            $vacancy->canApply = false;
            $vacancy->hasApplied = false;

            if($diff > 72){
                $vacancy->rel_calendar_id = "hourglass-relax";
            }elseif($diff >0 && $diff <= 72){
                $vacancy->rel_calendar_id = "hourglass-rush";
            }else{
                $vacancy->rel_calendar_id = "hourglass-cross";
                $vacancy->dateOk = false;
            }

            if( $candidateId != 0 && sizeof($vacancy->candidates) > 0 ){
                $vacancy->hasApplied = true;
            }

            if($vacancy->dateOk && !$vacancy->hasApplied){
                $vacancy->canApply = true;
            }
            
            $timezone = session('candidate.timezone');
            $vacancy->end_date = $dtEndDate->setTimezone($timezone)->toFormattedDateString();

        }
        return view('public.available-jobs', compact('vacancies'));
    }

    public function apply(Request $request)
    {
        $candidateId = Auth::guard('candidate')->check() ? Auth::guard('candidate')->user()->id :0;
        $recruitmentId = Route::current()->parameter('recruitment_id');
        $recruitment = Recruitment::find($recruitmentId);

        Session::put('recruitmentId', $recruitmentId);

        // logged-in candidate is making an application
        if($candidateId !=0) {
            $recruitmentId = Route::current()->parameter('recruitment_id');

            $vacancy = $this->contextObj::with(['department', 'employeeStatus', 'qualification', 'skills'
            ])->where('is_approved', '=', 1)
                ->where('end_date', '>=', Carbon::now()->endOfDay()->toDateTimeString())
                ->where('id', '=', $recruitmentId)
                ->whereIn('recruitment_type_id', [2, 3])
                ->orderBy('posted_on', 'desc')
                ->get()
                ->first();

            $vacancy->posted_on = Carbon::createFromTimeStamp(strtotime($vacancy->posted_on))->diffForHumans();
            $dt = Carbon::now('UTC');
            $dtEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $vacancy->end_date);
            $diff = $dt->diffInHours($dtEndDate, false);

            $vacancy->dateOk = true;
            $vacancy->canApply = false;
            $vacancy->hasApplied = false;

            if($diff > 72){
                $vacancy->rel_calendar_id = "hourglass-relax";
            }elseif($diff >0 && $diff <= 72){
                $vacancy->rel_calendar_id = "hourglass-rush";
            }else{
                $vacancy->rel_calendar_id = "hourglass-cross";
                $vacancy->dateOk = false;
            }

            if( $candidateId != 0 && sizeof($vacancy->candidates) > 0 ){
                $vacancy->hasApplied = true;
            }

            if($vacancy->dateOk && !$vacancy->hasApplied){
                $vacancy->canApply = true;
            }

            $timezone = session('candidate.timezone');
            $vacancy->end_date = $dtEndDate->setTimezone($timezone)->toFormattedDateString();


            return view('public.salary', compact('recruitmentId','recruitment','vacancy'));
        } else {

            return redirect('candidate/login');

        }

    }
    public function applyInterview(Request $request)
    {
        try {
            $candidate_id       = \Illuminate\Support\Facades\Auth::guard('candidate')->user()->id;
            $salary_expectation = ($request->has('salary_expectation')) ? $request->get('salary_expectation') : null;
            $recruitment_id     = ($request->has('recruitment_id')) ? $request->get('recruitment_id') : null;

            $candidate_recruitment = [
                'candidate_id' => $candidate_id,
                'recruitment_id' => $recruitment_id,
                'salary_expectation' => $salary_expectation
            ];

            DB::table('candidate_recruitment')->insert($candidate_recruitment);

            //insert in recruitment_status
            $recruitment_status = [
                'recruitment_id' =>  $recruitment_id,
                'candidate_id' =>  $candidate_id,
                'comment' => null
            ];

            DB::table('recruitment_status')
                ->insert($recruitment_status);

            //remove from three-way pivot table if not present candidate_recruitment
            $recruitment = Recruitment::find($recruitment_id);
            $recruitment->interviews()
                ->where('recruitment_id', $recruitment_id)
                ->get()
                ->each(function ($interview) use ($candidate_id, $recruitment_id) {
                    if ($interview->pivot->candidate_id == $candidate_id) {
                        dump('in');
                        $interview->pivot->delete();
                    }
                });

            //add if does not exist in three-way pivot table
            $interview_types = $recruitment->interviewTypes()->get()->all();
            $add_candidate_interview_recruitment_pivot = [];

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

            $recruitment->interviews()->attach($add_candidate_interview_recruitment_pivot);
            \Session::put('success', 'Job applied successfully!!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not update !');
        }


        return redirect()->route('candidate.vacancies');
    }



    public function showCandidateStatus(Request $request)
    {

        $candidateId = Auth::guard('candidate')->check() ? Auth::guard('candidate')->user()->id :0;

        $recruitmentId = Route::current()->parameter('recruitment_id');
        $recruitment = Recruitment::with(['trackCandidateStatus' => function($query) use ($candidateId){
            return $query->where('candidate_id', $candidateId);
        }])->find($recruitmentId);

        $candidate = Candidate::candidatesList()->with(['interviews' => function($query) use ($candidateId){
            return $query->where('candidate_id', $candidateId);
        }, 'offers' => function($query) use ($candidateId){
            return $query->where('candidate_id', $candidateId);
        }, 'contracts' => function($query) use ($candidateId){
            return $query->where('candidate_id', $candidateId);
        }])->find($candidateId);
        //dump($candidate);

        $view = view($this->baseViewPath . '.candidate-status', compact('recruitment','candidate'))->renderSections();

        return response()->json([
            'title' => $view['modalTitle'],
            'content' => $view['modalContent'],
            'footer' => $view['modalFooter']
        ]);
    }
}