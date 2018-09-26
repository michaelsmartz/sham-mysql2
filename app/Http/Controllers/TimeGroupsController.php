<?php

namespace App\Http\Controllers;

use App\Enums\DayType;
use App\TimeGroup;
use App\TimePeriod;
use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

class TimeGroupsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new TimeGroup();
        $this->baseViewPath = 'time_groups';
        $this->baseFlash = 'Time Group details ';
    }

    /**
     * Display a listing of the time groups.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $timeGroups = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('timeGroups'));
    }

    /**
     * Store a new time group in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->validator($request);

            $input = array_except($request->all(),array('_token'));

            $this->contextObj->addData($input);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Request $request)
    {
        $data = null;
        $id = Route::current()->parameter('time_group');
        $data = $this->contextObj->findData($id);

        $shifts = $this->getTimePeriod(1);
        $breaks = $this->getTimePeriod(2);
        $days = DayType::getKeys();

        //dd($shifts);
        //dd($breaks);

        $tgDays = $data->days()->pluck('name','day_id');

        $breakId = $this->contextObj->timePeriods()->where('time_period_type', 2)->pluck('time_group_id','time_period_id');

        //dd($breakId);

        //dd($days);
        //dd($tgDays);

        if($request->ajax()) {
            $view = view($this->baseViewPath . '.edit', compact('data','shifts','breaks','days','tgDays','breakId'))->renderSections();
            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
        return view($this->baseViewPath . '.edit', compact('data','shifts','breaks','days','tgDays','breakId'));
    }

    /**
     * getTimePeriod for breaks and shifts
     * @param $timePeriodType
     * @return array
     */
    private function getTimePeriod($timePeriodType){
        $tempStartTime = $tempEndTime = '';
        $timePeriod = [];

        $times = TimePeriod::where('time_period_type', $timePeriodType)->get(['end_time','start_time','description']);
        $count=0;

        if (!empty($times)) {
            foreach ($times as $time) {

                if ($time->start_time != null) {
                    $intervalStart = new DateTime($time->start_time);
                    $tempStartTime = $intervalStart->format('G:i');
                }

                if ($time->end_time != null) {
                    $intervalEnd = new DateTime($time->end_time);
                    $tempEndTime = $intervalEnd->format('G:i');
                }

                if($timePeriodType == 2){
                    $timePeriod[$count]['title'] = $time->description;
                    $timePeriod[$count]['text'] = $tempStartTime . '-' . $tempEndTime;
                }else{
                    $timePeriod[] = $tempStartTime . '-' . $tempEndTime;
                }
                $count++;
            }
        }

        return $timePeriod;
    }

    /**
     * Update the specified time group in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validator($request);

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');       
    }

    /**
     * Remove the specified time group from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('time_group');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    /**
     * Validate the given request with the defined rules.
     *
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'name' => 'required|string|min:1|max:100',
            'start' => 'nullable|string|min:1',
            'end' => 'nullable|string|min:1'
        ];

        $this->validate($request, $validateFields);
    }
}