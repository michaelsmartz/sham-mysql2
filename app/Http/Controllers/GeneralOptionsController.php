<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SysConfigValue;

class GeneralOptionsController extends Controller
{

    //@todo Permission for path access
    /**
     * Display a listing of the employee leave requests.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $working_year_start = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
        $working_year_end   = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();

        return view('general_options.index')->with([
            'working_year_start' => $working_year_start->value,
            'working_year_end'   => $working_year_end->value
        ]);
    }


    public function store(Request $request){
        try {
            $working_year_start = SysConfigValue::where('key','=', 'WORKING_YEAR_START')->first();
            $working_year_start->value = $request->input('working_year_start');
            $working_year_start->save();

            $working_year_end   = SysConfigValue::where('key','=', 'WORKING_YEAR_END')->first();
            $working_year_end->value = $request->input('working_year_end');
            $working_year_end->save();

            return redirect()->route('general_options.index')
                ->with('success', 'Configuration saved successfully.');

        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['error' => 'Unexpected error occurred while trying to process your request.']);
        }

    }

}
