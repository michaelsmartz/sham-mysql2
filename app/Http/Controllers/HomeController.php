<?php

namespace App\Http\Controllers;

use App\ShamUserProfile;
use App\AssetDataView;
use App\EmployeeHeadcountDeptView;
use App\EmployeeHeadcountView;
use App\EmployeeNewHiresView;
use App\Course;
use App\DisciplinaryAction;
use App\Reward;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getHeadcountData()
    {
        $temp = Cache::remember('EmployeeHeadcountView', 1 * 60, function () {
            return EmployeeHeadcountView::all();
        });

        return response()->json(['response' => $temp], 200);
    }

    public function getHeadcountDeptData()
    {
        $temp = Cache::remember('EmployeeHeadcountDeptView', 1 * 60, function () {
            return EmployeeHeadcountDeptView::all();
        });

        return response()->json(['response' => $temp], 200);
    }

    public function getNewHiresData()
    {

        //$temp = Cache::remember('EmployeeNewHiresView', 1*60, function() {
        $temp = EmployeeNewHiresView::all();

        if (is_array($temp) && sizeof($temp) > 0) {
            foreach ($temp as $item) {
                $item->Hired = 0;
                $item->Terminated = 0;
                $item->Name = '';
                if ($item->Type == 0) {
                    $item->Hired = $item->Count;
                    $item->Name = 'Hired';
                } else {
                    $item->Terminated = $item->Count;
                    $item->Name = 'Terminated';
                }
                unset($item->Type);
            }
        }
        //dump($temp);
        //return $temp;
        //});

        return response()->json(['response' => $temp], 200);
    }

    public function getAssetData()
    {
        $ret = array();
        //$temp = Cache::remember('getAssetData', 1*60, function() {
        $temp = AssetDataView::all();

        foreach ($temp as $assetData) {
            $assets = $assetData;
            $sampleObj = new \stdClass();
            $sampleObj->Description = $assetData->name;
            $sampleObj->Available = $assetData->total;
            $ret[] = $sampleObj;
        }

        //return $ret;
        //});

        return response()->json(['response' => $ret], 200);
    }

    public function getCourseData()
    {
        $temp = Cache::remember('getCourseData', 1 * 60, function () {
            return Course::select('description as Description')->withCount('employees')->get();
        });

        $ret = array();
        foreach ($temp as $courseData) {
            $sampleObj = new \stdClass();
            $sampleObj->Description = $courseData->Description;
            $sampleObj->Participants = $courseData->employees_count;
            $ret[] = $sampleObj;
        }

        return response()->json(['response' => $ret], 200);
    }

    public function getRewardCount()
    {
        $temp = Cache::remember('getRewardCount', 1*60, function() {
            return Reward::count();
        });

        return response()->json(['response' => $temp], 200);
    }

    public function getDisciplinaryActionCount(){

        $temp = DisciplinaryAction::whereHas('employee')->count();

        return response()->json(['response' => $temp], 200);
    }

}
