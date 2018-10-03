<?php

namespace App\Http\Controllers;

use App\Enums\NotificationGroupType;
use App\Enums\NotificationRecurrenceType;
use App\Form;
use App\Survey;
use App\SurveyResponse;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;

class SurveysController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new Survey();
        $this->baseViewPath = 'surveys';
        $this->baseFlash = 'Survey details ';
    }

    /**
     * Display a listing of the surveys.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $surveys = $this->contextObj::with('users.employee')->filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $notificationRecurrences = NotificationRecurrenceType::ddList();
        $notificationGroups = NotificationGroupType::ddList();

        return view($this->baseViewPath . '.create', compact('data','notificationRecurrences','notificationGroups'));
    }

    /**
     * Store a new survey in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            dd($request);
            //$this->validator($request);

            $formData = array_get($request->all(),'FormData');
            $title = array_get($request->all(),'title');

            //dd(['sata'=>$formData,'title'=>$title]);

            $input = array_except($request->all(),array('_token', 'form_textarea1135',  'FormData'));

            $data = $this->contextObj->addData($input);

            $data->forms()
                ->sync(['sata'=>$formData,'title'=>$title]); //sync what has been selected

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
        $id = Route::current()->parameter('survey');
        $data = $this->contextObj->findData($id);

        $form = ($data->form_id != "")?Form::find($data->form_id):null;
        if ($form !=null) $data->FormData = $form->sata;//Handle the Form Data

        //dd($data);

        if ($data->final == true)
        {
            // show the view and pass the data to it
            return view($this->baseViewPath . '.show', compact('data', 'form'));
        }
        else {
            // show the view and pass the data to it
            return view($this->baseViewPath . '.edit', compact('data'));
        }
    }

    /**
     * Update the specified survey in the storage.
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
            
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));
            
            $input = array_except($request->all(),array('_token','_method','redirectsTo'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    //functions necessary to handle 'resource' type of route
    public function results(Request $request, $Id) {

        $survey = Survey::find($Id);

        $form = ($survey)?Form::find($survey->form_id):null;

        if ($form) {
            $template = $form->getFormKeys();

            $keys = array_keys($template);

            $responses = ($survey) ? SurveyResponse::where('survey_id', $survey->id)->get(['id']): null;

            if ($responses) {

                $wrongFilenameChars = array('/',':','*','?','<','>','\\','|');
                $safeTitle = str_replace($wrongFilenameChars,'_',$survey->title);
                $pathToFile = storage_path() . "/tmp/" . $safeTitle . "-results.csv";
                $fp = fopen($pathToFile, 'w');
                // nested arrays cause problems with fputcsv
                $result = array_flatten(array_values($template));
                fputcsv($fp, $result);

                foreach ($responses as $responseRow) {
                    $response = SurveyResponse::find($responseRow->id);

                    if ($response) {
                        $resultArray = array_fill_keys($keys, '');

                        $result = $response->getResponseArray();
                        foreach ($result as $key => $value) {
                            if (array_key_exists($key, $resultArray)) $resultArray[$key] = is_array($value)?implode(PHP_EOL,$value):$value;
                        }
                        fputcsv($fp, array_values($resultArray));
                    }
                }

                fclose($fp);
                return response()->download($pathToFile);
            }
        }
    }

    /**
     * Remove the specified survey from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('survey');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    
}