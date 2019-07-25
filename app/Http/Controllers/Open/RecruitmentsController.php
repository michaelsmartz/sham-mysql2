<?php

namespace App\Http\Controllers\Open;

use Auth;
use App\Candidate;
use App\Recruitment;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class RecruitmentsController extends Controller
{
    protected $contextObj;
    protected $baseViewPath;

    public function __construct() {
        Debugbar::enable();
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
        ])->whereIn('recruitment_type_id', [2, 3]);

        if($candidateId == 0){
            $vacancies = $a->get();
        } else {
            $vacancies = $b->get();
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

            $vacancy->end_date = $dtEndDate->toFormattedDateString();

        }
        return view('public.index', compact('vacancies'));
    }

    public function apply(Request $request)
    {
        $candidateId = Auth::guard('candidate')->check() ? Auth::guard('candidate')->user()->id :0;
        $recruitmentId = Route::current()->parameter('recruitment_id');
        $recruitment = Recruitment::find($recruitmentId);

        Session::put('recruitmentId', $recruitmentId);

        // logged-in candidate is making an application
        if($candidateId !=0) {

            return view('public.salary', compact('recruitmentId','recruitment'));
        } else {

            return redirect('candidate/login');

        }

    }
    
    public function showCandidateStatus(Request $request)
    {

        $candidateId = Auth::guard('candidate')->check() ? Auth::guard('candidate')->user()->id :0;

        $recruitmentId = Route::current()->parameter('recruitment_id');
        $recruitment = Recruitment::with(['trackCandidateStatus' => function($query) use ($candidateId){
            return $query->where('candidate_id',$candidateId);
        }])->find($recruitmentId);

        $candidate = Candidate::candidatesList()->with(['interviews', 'offers', 'contracts'])->find($candidateId);
        //dump($candidate);

        $view = view($this->baseViewPath . '.candidate-status', compact('recruitment','candidate'))->renderSections();

        return response()->json([
            'title' => $view['modalTitle'],
            'content' => $view['modalContent'],
            'footer' => $view['modalFooter']
        ]);
    }
}