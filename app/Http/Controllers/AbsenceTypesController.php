<?php

namespace App\Http\Controllers;

use App\AbsenceType;
use App\Colour;
use App\Enums\LeaveAccruePeriodType;
use App\Enums\LeaveDurationUnitType;
use App\Enums\LeaveEmployeeGainEligibilityType;
use App\Enums\LeaveEmployeeLossEligibilityType;
use App\JobTitle;
use App\Support\Helper;
use App\SystemSubModule;

use App\Http\Controllers\CustomController;
use App\Http\Requests\AbsenceTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Exception;

class AbsenceTypesController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new AbsenceType();
        $this->baseViewPath = 'absence_types';
        $this->baseFlash = 'Absence Type details ';
    }

    /**
     * Display a listing of the absence types.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $description = $request->get('description', null);

        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $eligibility_begins = $request->get('$eligibility_begins', null);

        if(!empty($eligibility_begins)){
            $request->merge(['eligibility_begins' => '%'.$eligibility_begins.'%']);
        }

        $eligibility_ends = $request->get('$eligibility_ends', null);

        if(!empty($eligibility_ends)){
            $request->merge(['eligibility_ends' => '%'.$eligibility_ends.'%']);
        }

        // handle empty result bug
        if (Input::has('page')) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_ABSENCE_TYPES);

        $absenceTypes = $this->contextObj::with(['eligibilityEmployees','jobTitles','absenceTypeEmployees'])->filtered()->paginate(10);

        return view($this->baseViewPath .'.index', compact('absenceTypes','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $duration_units = LeaveDurationUnitType::ddList();
        // get unused colours
        $temp = Colour::doesnthave('absenceTypes')->pluck('code', 'id');
        $colours = array_keys(array_flip($temp->toArray()));

        return view($this->baseViewPath . '.create',
            compact('data', 'duration_units', 'colours'));
    }

    /**
     * Store a new absence type in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(AbsenceTypeRequest $request)
    {

        try {

            if (Cache::has('ColoursList')) {
                $temp = Cache::get('ColoursList');
            } else {
                $temp = Cache::tags('colours')->remember('ColoursList', 1 * 60, function () {
                    return Colour::doesnthave('absenceTypes')->pluck('code', 'id');
                });
            }
            // make the array as colour code => colour id
            $colours = array_flip($temp->toArray());

            $colourCode = $request->colour_code;

            // array has # as the starting character
            $replacedKeys = str_replace('#', '', array_keys($colours));
            $colours = array_combine($replacedKeys, $colours);
            $key = str_replace('#', '', $colourCode);

            // cleaned the # in array keys and colour_code for lookup
            $colourId = $colours[$key];

            $request->merge(['colour_id' => $colourId]);

            $this->saveAbsenceTypes($request);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

            return redirect()->route($this->baseViewPath .'.index');

        } catch (Exception $exception) {
            dump($exception);
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $data = null;
        $id = Route::current()->parameter('absence_type');
        if(!empty($id)) {
            $data = $this->contextObj::with('colour')->find($id);
            $duration_units = LeaveDurationUnitType::ddList();
            $start_eligibilities = LeaveEmployeeGainEligibilityType::ddList();
            $end_eligibilities = LeaveEmployeeLossEligibilityType::ddList();

            if(isset($data->eligibility_ends) && !is_null($data->eligibility_ends)
                && $data->eligibility_ends === 1
            )
                $hideAccrue = true;
            else
                $hideAccrue = false;


            if(isset($data->eligibility_begins) && !is_null($data->eligibility_begins)
                && $data->eligibility_begins === 1
            )
                $hideEndProbation = true;
            else
                $hideEndProbation = false;

            $accrue_periods = LeaveAccruePeriodType::ddList();
            //remove not applicable from dropdown accrue period
            $notApplicable = $accrue_periods[-1];
            unset($accrue_periods[-1]);
            $jobTitles = JobTitle::withoutGlobalScope('system_predefined')->pluck('description','id')->all();

            $absenceTypeJobTitles = $data->jobTitles->pluck('id');

            $recordComplete = !empty($data->amount_earns) && !empty($data->colour_id);
        }

        if($request->ajax()) {

            if(!$recordComplete) {
                $view = view($this->baseViewPath . '.edit',
                compact('data', 'absenceTypeJobTitles', 'jobTitles', 'hideAccrue', 'hideEndProbation', 'notApplicable', 'duration_units','start_eligibilities','end_eligibilities', 'accrue_periods'))
                    ->renderSections();
            } else {
                $view = view($this->baseViewPath . '.show',
                compact('data', 'absenceTypeJobTitles', 'jobTitles'))
                    ->renderSections();
            }

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }

        return view($this->baseViewPath . '.edit',
            compact('data', 'absenceTypeJobTitles', 'jobTitles', 'hideAccrue', 'hideEndProbation', 'notApplicable', 'duration_units','start_eligibilities','end_eligibilities', 'accrue_periods'));
    }

    /**
     * Update the specified absence type in the storage.
     *
     * @param  int $id
     * @param AbsenceTypeRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(AbsenceTypeRequest $request, $id)
    {
        try {

            $this->saveAbsenceTypes($request, $id);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            dd($exception->getMessage());
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');
    }

    protected function saveAbsenceTypes(AbsenceTypeRequest $request, $id = null) {

        $otherFields = [
            '_token',
            '_method',
            'jobTitles',
            'colour_code'
        ];
        foreach($otherFields as $field){
            ${$field} = array_get($request->all(), $field);
        }

        $input = array_except($request->all(), $otherFields);

        if ($id == null) { // Create
            $this->contextObj->addData($input);
        } else { // Update
            //case when employee losses equals to "When probation ends" set Accrue_period to 0 (default 12 months)
            if(!is_null($input['eligibility_ends']) && $input['eligibility_ends'] == 1){
                $input['accrue_period'] = "-1";
            }
            $this->contextObj->updateData($id, $input);
            $data = AbsenceType::find($id);
            $data->jobTitles()->sync($jobTitles);
        }

    }

    /**
     * Remove the specified absence type from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('absence_type');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }

}