<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Recruitment;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;

class RecruitmentsController extends CustomController
{

    public $baseViewPath;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->baseViewPath = 'recruitments';
    }

    /**
     * Display a listing of the policies.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        return view($this->baseViewPath .'.index');
    }

    public function show($id)
    {
        return view($this->baseViewPath .'.index');
    }

    /**
     * Recruitment request form.
     *
     * @return Illuminate\View\View
     */
    public function request()
    {

        return view($this->baseViewPath .'.request');
    }

    public function stateSwitch(Request $request){

        $id = intval(Route::current()->parameter('recruitment'));
        $candidate = intval(Route::current()->parameter('candidate'));
        $state = intval(Route::current()->parameter('state'));
        $result = true;

        $recruitment = Recruitment::find($id);
        $dataToSync =[ $id => ['candidate_id' => $candidate, 'status' => $state]];
        
        try{
            $recruitment->candidates()->sync($dataToSync);
        } catch(Exception $exception) {
            $result = false;
        }
        
        return Response()->json($result);
    }
}
