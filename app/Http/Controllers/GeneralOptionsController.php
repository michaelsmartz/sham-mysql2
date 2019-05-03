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



//        $validator = Validator::make($request->all(),[
//            'working_year_start' => 'required',
//            'working_year_end'   => 'required',
//        ]);
//        $errors = array();
//
//        if($request->input('working_year_end') <= $request->input('working_year_start')){
//            $validator->errors()->add('working_year_start','Working Year End must be greater than Working Year Start');
//        }
//
//
//
//
//        if($year_diff !== 1){
//            $validator->errors()->add('working_year_start','Working Year End and Working Year Start must be 1 year inclusive');
//        }
//
//
//        $this->validate(request(), [
//            'greater_end_date' => [function ($attribute, $value, $fail) {
//                if ($value <= 10) {
//                    $fail('Working Year End must be greater than Working Year Start');
//                }
//            }],
//            'one_year_interval' => [function ($attribute, $value, $fail) {
//                $interval = date_diff(date_create($request->input('working_year_start')), date_create($request->input('working_year_end')));
//                $year_diff = (int)$interval->format('%y');
//                if($year_diff !== 1){
//                    $fail('Working Year End must be greater than Working Year Start');
//                }
//            }]
//        ]);
//


}
