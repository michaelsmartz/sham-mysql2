<?php

namespace App\Http\Controllers;

use App\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Exception;

class OrganisationChartsController extends CustomController
{
    
    protected $detectedRoots;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new JobTitle();
        $this->baseViewPath = 'organisation_charts';
        $this->baseFlash = 'Organisation Charts details ';
    }

        /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $managerEmployeeId = Input::get('ManagerEmployeeId', ''); //search string
        $jsonData = json_encode(self::orgStructData($managerEmployeeId)); //json_encode($data);
        $managers = JobTitle::ManagerialJobs()->with('employees')->get();
        // load the view and pass the organisationcharts
        return view($this->baseViewPath .'.index',compact('allowedActions', 'managers'))
            ->with('data', $jsonData)
            ->with('detectedRoots', $this->detectedRoots);
    }

    public function orgStructData($managerEmployeeId)
    {
        $employeeArray = array();
        $returnArray = array();
        $temp = DB::select("
                    select (CASE WHEN a.id = a.line_manager_id THEN @curRow := @curRow + 1 ELSE @curRow := @curRow + 0 END) As detected_roots,
                           a.id, a.full_name, a.job_title_id, a.line_manager_id, a.description 
                    from 
                        (select e.id, concat(e.first_name,' ',e.surname) as full_name, job_title_id, line_manager_id, j.description 
                        from employees e left join job_titles j on e.job_title_id = j.id 
                        where e.deleted_at is null) as a 
                        join (SELECT @curRow := 0) as r 
                        order by @curRow desc 
        ");

        if(!empty($temp) && sizeof($temp) > 0) {
            $t = $temp[0];
            $this->detectedRoots = $t->detected_roots;

            if($managerEmployeeId != '' && $managerEmployeeId > 0) {
                foreach($temp as $key => $employee){
                    if($employee->id == $managerEmployeeId) {
                        $employee->line_manager_id = $managerEmployeeId;
                    }
                    else {
                        if($employee->id == $employee->line_manager_id){
                            $employee->line_manager_id = '';
                        }
                    }
                }

                foreach($temp as $key => $employee)
                {
                    $stdclassobj = new \stdClass();
                    $stdclassobj->id = $employee->id;
                    $stdclassobj->text = array(
                        'name' => $employee->full_name,
                        'title' => empty($employee->job_title_id)? '': $employee->description,
                        'Contact' => ''
                    );
                    $stdclassobj->name = $employee->full_name;
                    $stdclassobj->line_manager_id = $employee->line_manager_id;
                    $employeeArray[$employee->id] = $stdclassobj;
                }

                foreach($employeeArray as $employee)
                {
                    if(array_key_exists($employee->line_manager_id,$employeeArray)) {
                        $employeeobj = $employeeArray[$employee->line_manager_id];
                        $employee->parent = $employeeobj->text['name'];
                    } else {
                        $employee->parent = '';
                    }
                    $returnArray[] = $employee;
                }

                // the person who reports to him/her self tops the array
                usort($returnArray, function($a, $b) {
                    if ($a->id == $a->line_manager_id) {
                        if($this->detectedRoots == 2) {
                            return -2;
                        } else {
                            return -1;
                        }
                        // put first
                    }
                    return 1; // put last
                });

                // for the javascript grouping using d3
                for($i=0; $i < $this->detectedRoots; $i++) {
                    $returnArray[$i]->parent = null;
                }

            }
        }

        return $returnArray;
    }

}