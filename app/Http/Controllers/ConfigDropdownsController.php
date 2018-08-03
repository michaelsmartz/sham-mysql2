<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use bnjns\SearchTools;

class ConfigDropdownsController extends Controller
{
    //
    public function employees() {
        $options = array('text'=>'name', 'value'=> 'abc');
        \SearchTools::setFilterOptions($options);
        return view('config.employees');
    }
}
