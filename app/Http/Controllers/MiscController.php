<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiscController extends Controller
{
    public function welcome(){
        return view('welcome');
    }
    public function test(){
        return view('test');
    }
    public function elearningHelper(){
        return view('elearning-helper');
    }
    public function vueTest(){
        return view('vue-test');
    }
}
