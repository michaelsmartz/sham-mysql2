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

        $temp = $this->contextObj::with(['users'])->where('author_sham_user_id',$userId)->get()->all();

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
        return View::make('selfservice-portal.surveys.sspmysurveys',compact('surveys'));
    }

    public function getFormData($formId) {
        $form = ($formId != "")? Form::find($formId):null;
        if ($form !=null) {
            return $form->getFormHTML();
        }
        return '<b>Survey preview unavailable</b>';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {}
}

