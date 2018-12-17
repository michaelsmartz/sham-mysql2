<?php

namespace App\Http\Controllers;

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

    /**
     * Display a listing of the policies.
     *
     * @return Illuminate\View\View
     */
    public function request()
    {

        return view($this->baseViewPath .'.request');
    }

}
