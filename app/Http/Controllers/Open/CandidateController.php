<?php

namespace App\Http\Controllers\Open;

use App\Candidate;
use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facade as Debugbar;
use Carbon\Carbon;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:candidates',['only' => 'index','edit']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.index');
    }
}