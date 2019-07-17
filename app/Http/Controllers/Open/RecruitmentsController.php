<?php

namespace App\Http\Controllers\Open;

use Auth;
use App\Recruitment;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;

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

        $candidateFilter = function ($q) use ($candidateId) {
            $q->where('candidate_id', $candidateId);
        };

        $a = $this->contextObj::with(['department', 'employeeStatus', 'qualification', 'skills'
        ])->where('is_approved', '=', 1)
        ->whereIn('recruitment_type_id', [2, 3])
        ->orderBy('posted_on', 'desc');

        $b = $this->contextObj::with(['department', 'employeeStatus', 'qualification', 'skills',
            'candidates' => $candidateFilter
        ])->whereHas('candidates', $candidateFilter);

        if($candidateId == 0){
            $vacancies = $a->get();
        } else {
            $vacancies = $b->get();
        }

        foreach($vacancies as $vacancy) {
            $vacancy->posted_on = Carbon::createFromTimeStamp(strtotime($vacancy->posted_on))->diffForHumans();
            $dt = Carbon::now();
            $dtEndDate = Carbon::createFromFormat('Y-m-d', $vacancy->end_date);
            $diff = $dt->diffInHours($dtEndDate, false);

            $vacancy->dateOk = true;
            if($diff > 72){
                $vacancy->rel_calendar_id = "hourglass-relax";
            }elseif($diff >0 && $diff <= 72){
                $vacancy->rel_calendar_id = "hourglass-rush";
            }else{
                $vacancy->rel_calendar_id = "hourglass-cross";
                $vacancy->dateOk = false;
            }

            $vacancy->canApply = false;

            if($candidateId == 0){
                $vacancy->canApply = true;
            }

            if( !isset($vacancy->candidates) && $vacancy->dateOk ){
                $vacancy->canApply = true;
            }

        }
        return view('public.index', compact('vacancies'));
    }

}