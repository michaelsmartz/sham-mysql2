<?php

namespace App\Http\Controllers\Open;

use App\Http\Controllers\Controller;
use Barryvdh\Debugbar\Facade as Debugbar;

class RecruitmentsController extends Controller
{
    public function __construct() {
        Debugbar::disable();
    }

    public function publicHome() {
        
        return view('public.index');
    }

}