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
use App\QAEvaluationScoresView;
use App\QAEvaluationsView;
use App\Jobs\FlushDashboardCachedQueries;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    const CONST_ELAPSE_DAYS = 370;
    const CONST_MIN_PASS_PERCENTAGE = 95;
    const CONST_MAX_FAIL_PERCENTAGE = 79;

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
        $temp = Cache::tags('dashboard')->remember('EmployeeHeadcountView', 1 * 15, function () {
            return EmployeeHeadcountView::all();
        });

        return response()->json(['response' => $temp], 200);
    }

    public function getHeadcountDeptData()
    {
        $temp = Cache::tags('dashboard')->remember('EmployeeHeadcountDeptView', 1 * 15, function () {
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
        $temp =Cache::tags('dashboard')->remember('getCourseData', 1 * 15, function () {
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
        $temp = Cache::tags('dashboard')->tags('dashboard')->remember('getRewardCount', 1 * 15, function() {
            return Reward::count();
        });

        return response()->json(['response' => $temp], 200);
    }

    public function getDisciplinaryActionCount()
    {

        $temp = DisciplinaryAction::whereHas('employee')->count();

        return response()->json(['response' => $temp], 200);
    }

    public function getQALastFiveDaysData() {

        $ret = array();
        $qarecords = Cache::tags('dashboard')->remember('getQALastFiveDaysData', 1 * 15, function() {
            $startdate = self::getStartDate();
            return QAEvaluationsView::where('TotalPoints', '>', 0)
            ->where('Feedbackdate', '>=', $startdate->format('Y-m-d'))->get();
        });

        if($qarecords !=null)
        {
            foreach ($qarecords as $result)
            {
                $sampleObj = new \stdClass();
                $sampleObj->year = Carbon::parse($result->Feedbackdate)->toDateString();// => "2016-10-01 23:59:59" $result->Feedbackdate;
                $sampleObj->name = $result->description;
                $sampleObj->Assessment = 1;
                $ret[] = $sampleObj;

            }
        }

        return response()->json(['response'=>$ret], 200);
    }

    public function getQAEvaluationScoresData() 
    {
        $ret = array();
        $qarecords = Cache::tags('dashboard')->remember('getQAEvaluationScoresData', 1 * 15, function() {

            $elapsedays = 370;
            $date = new Carbon;
            $startdate =  $date->subDays($elapsedays);
            return QAEvaluationScoresView::where('Feedbackdate', '>=', $startdate->format('Y-m-d'))->get();
        });

        if($qarecords !=null)
        {
            foreach ($qarecords as $result)
            {
                if($result->Percentage >= self::CONST_MIN_PASS_PERCENTAGE){
                    $stdObj = new \stdClass();
                    $stdObj->value = 1;
                    $stdObj->Name = "Pass";
                    $ret[] = $stdObj;
                }
                elseif($result->Percentage <= self::CONST_MAX_FAIL_PERCENTAGE){
                    $stdObj = new \stdClass();
                    $stdObj->value = 1;
                    $stdObj->Name = "Fail";
                    $ret[] = $stdObj;
                }
                else{
                    $stdObj = new \stdClass();
                    $stdObj->value = 1;
                    $stdObj->Name = "Other";
                    $ret[] = $stdObj;
                }
            }
        }
        return response()->json(['response'=>$ret],  200);
    }

    public function getTotalAssessmentData() 
    {
        $temp = Cache::tags('dashboard')->remember('getTotalAssessmentData', 1 * 15, function() {
            $elapsedays = self::CONST_ELAPSE_DAYS;
            $date = new Carbon;
            $startdate =  $date->subDays($elapsedays);

            return QAEvaluationsView::where('TotalPoints', '>', 0)
                   ->where('Feedbackdate', '>=', $startdate->format('Y-m-d'))->get();
        });

        return response()->json(['response' => $temp], 200);
    }

    private static function getStartDate() {

        $todaysdate = Carbon::now();

        $elapsedays = self::CONST_ELAPSE_DAYS; // $elapsedays = 6;
        $dates = array();

        $date = new Carbon;
        $startdate =  $date->subDays($elapsedays);

        $dates = [];
        for($date = $startdate; $date->lte($todaysdate); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        foreach ($dates as $date)
        {
            $sampleObj = new \stdClass();
            $sampleObj->year = $date;
            $sampleObj->name = 'Product A';
            $sampleObj->Assessment = 0;
            $ret[] = $sampleObj;
        }

        $date = new Carbon;
        $startdate =  $date->subDays($elapsedays);

        return $startdate;
    }

}
