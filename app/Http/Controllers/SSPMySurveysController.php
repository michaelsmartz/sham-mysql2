<?php

namespace App\Http\Controllers;

use App\DateHelper;
use App\ServiceModel;
use App\Http\Requests;
use App\Support\Helper;
use App\Survey;
use App\SurveyResponse;
use App\Form;
use App\SystemSubModule;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response;
use View;
use Redirect;
use Request;
use Validator;
use Session;
use Auth;
use \Carbon\Carbon;

class SSPMySurveysController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(){
        $this->contextObj = new Survey();
        $this->baseViewPath = 'selfservice-portal.surveys';
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $userId = (\Auth::check()) ? \Auth::user()->id : 0;

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_MY_SURVEYS);

        if ($allowedActions == null || !$allowedActions->contains('List')){
            return View('not-allowed')
                ->with('title', 'My Surveys')
                ->with('warnings', array('You do not have permissions to access this page.'));
        }

        $date = Carbon::today();
        $date = DateHelper::adjustCarbonObjTimeZone($date);

        $surveys = [];

        $temp = $this->contextObj::with('users')
        ->whereDoesntHave('SurveyResponse', function ($query) use ($userId)
        {
            return  $query->where('sham_user_id', $userId);
        })
        ->where('final',1)
        ->get()
        ->all();

        if ($temp!=null){
            foreach ($temp as $t) {
                $st = new Carbon($t->date_start);
                $ed = new Carbon($t->date_end);

                $res = (bool)(($date->eq($st) || $date->eq($ed)) ||
                    ($date->gte($st) && $date->lte($ed)));
                if ($res) {
                    $surveys[] = $t;
                }
            }
        }

        // load the view and pass the surveys
        return view($this->baseViewPath .'.index',compact('surveys'));
    }

    public function getFormData($formId) {
        $form = ($formId != "")? Form::find($formId):null;
        if ($form !=null) {
            return $form->getFormHTML();
        }
        return '<b>Survey preview unavailable</b>';
    }


    /**
     * Display the survey form for the user to fill.
     *
     * @param  string  $id
     * @return Response
     */
    public function show($id) {
        // send the survey form to fill
        $survey = $this->contextObj::find($id);

        $form = ($survey->form_id != "")?Form::find($survey->form_id):null;

        if ($form !=null) $survey->FormData = $form->sata;//Handle the Form Data

        // my survey showed final surveys, only take final surveys
        if ($survey->final==true) {
            $view = view($this->baseViewPath . '.complete-survey', compact('survey', 'id','form'))->renderSections();

            return response()->json([
                'title' => $view['modalTitle'],
                'content' => $view['modalContent'],
                'footer' => $view['modalFooter'],
                'url' => $view['postModalUrl']
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        try {
            // store
            $filledFormData = Input::except(array('_token', 'id',));

            $surveyRsp = new SurveyResponse();
            $surveyRsp->survey_id = Input::get('id');
            $surveyRsp->response = json_encode($filledFormData);
            $surveyRsp->sham_user_id = (\Auth::check()) ? \Auth::user()->id : 0;
            $surveyRsp->date_occurred = Carbon::now()->toDateTimeString();
            $surveyRsp->save();

            \Session::put('success', 'Your survey response has been saved successfully!');

        } catch (Exception $exception) {
            \Session::put('error', 'An error occurred while saving your survey response!');
        }

        return redirect()->route('my-surveys.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {}
}

