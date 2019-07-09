<?php

namespace App\Http\Controllers\Open;

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

        $vacancies = $this->contextObj::with(['department','employeeStatus','qualification', 'skills'])
        ->where('is_approved', '=', 1)
        ->whereDate('end_date', '>', Carbon::now())
        ->whereIn('recruitment_type_id', [1, 3])
        ->orderBy('posted_on', 'desc')
        ->paginate(10)
        ->all();

        foreach($vacancies as $vacancy) {
            $vacancy->posted_on = Carbon::createFromTimeStamp(strtotime($vacancy->posted_on))->diffForHumans();
        }
        return view('public.index', compact('vacancies'));
    }

}