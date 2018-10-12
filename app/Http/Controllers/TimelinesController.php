<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Timeline;
use App\Reward;
use App\Violation;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class TimelinesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Employee();
        $this->baseViewPath = 'timelines';
        $this->baseFlash = 'Timeline ';
    }

    //functions necessary to handle 'resource' type of route
    public function show(Request $request)
    {
        $id = Route::current()->parameter('timeline');
        $tmp = $this->contextObj::with(['jobTitle',
                        'department',
                        'branch',
                        'division',
                        'team',
                        'historyDepartments.department',
                        'historyRewards.reward',
                        'historyDisciplinaryActions.disciplinaryAction',
                        'historyJoinTermination',
                        'historyJobTitles.jobTitle',
                        'historyQualification.qualification',
                ])
                ->where('id',$id)
                ->get()
                ->first();
        dd($tmp);
        return view($this->baseViewPath .'.index', compact('teams'));
    }
}