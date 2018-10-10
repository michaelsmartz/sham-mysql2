<?php

namespace App\Http\Controllers;

use App\DateHelper;
use App\ServiceModel;
use App\Http\Requests;
use App\Survey;
use App\SurveyResponse;
use App\Form;
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

        $date = Carbon::today();
        $date = DateHelper::adjustCarbonObjTimeZone($date);

        $surveys = [];

        $temp = $this->contextObj::with(['users'])
            ->where('author_sham_user_id',$userId)
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
            // show the view and pass the data to it
            return view($this->baseViewPath . '.show', compact('survey', 'id', 'form'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {}
}

