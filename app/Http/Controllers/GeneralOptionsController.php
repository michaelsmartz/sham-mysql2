<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkingYearRequest;
use Illuminate\Http\Request;
use App\SysConfigValue;
use Illuminate\Support\Facades\Validator;

class GeneralOptionsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseViewPath = 'general_options';
        $this->baseFlash = 'Working year configurations : ';
    }

    /**
     * Display a listing of the employee leave requests.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $working_year_start = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $working_year_end   = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();

        return view($this->baseViewPath.'.index')->with([
            'working_year_start' => $working_year_start->value,
            'working_year_end'   => $working_year_end->value
        ]);
    }


    public function store(WorkingYearRequest $request){
        try {

            $working_year_start = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
            $working_year_start->value = $request->input('working_year_start');
            $working_year_start->save();

            $working_year_end   = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
            $working_year_end->value = $request->input('working_year_end');
            $working_year_end->save();

            \Session::put('success', $this->baseFlash . 'updated!!');
        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');

    }



}
