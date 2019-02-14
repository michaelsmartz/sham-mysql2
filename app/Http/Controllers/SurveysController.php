<?php

namespace App\Http\Controllers;

use App\Enums\NotificationGroupType;
use App\Enums\NotificationRecurrenceType;
use App\Form;
use App\Survey;
use App\SurveyResponse;
use App\SystemSubModule;
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
    public function index(Request $request)
    {
        $title = $request->get('title', null);

        if(!empty($title)){
            $request->merge(['title' => '%'.$title.'%']);
        }

        $surveys = $this->contextObj::with('users.employee')->filtered()->paginate(10);
        
        $allowedActions = getAllowedActions(SystemSubModule::CONST_SURVEYS);

        // handle empty result bug
        if (Input::has('page') && $surveys->isEmpty()) {
            return redirect()->route($this->baseViewPath .'.index');
        }

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('surveys','allowedActions'));
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
            $this->validator($request);
            $filtered = [];

            //insert in form first to get last inserted id
            $form = new Form;
            $form->title = array_get($request->all(),'title');
            $form->sata = array_get($request->all(),'FormData');

            $form->save();

            //filter all array keys starting with form
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'form') !== 0) {
                    $filtered[$key] = $value;
                }
            }

            $input = array_except($filtered,array('_token', 'redirects_to', 'FormData'));

            //Handle the Author
            $input['author_sham_user_id'] = \Auth::user()->id;
            //Handle the Status
            $input['survey_status_id'] = 1;
            //use last inserted id obtained from insert in table Form
            $input['form_id'] = $form->id;

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
            $filtered = [];

            //filter all array keys starting with form
            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'form') !== 0) {
                    $filtered[$key] = $value;
                }
            }

            $redirectsTo = $request->get('redirects_to', route($this->baseViewPath .'.index'));

            $input = array_except($filtered ,array('_token','_method','redirects_to', 'FormData'));

            if(!array_key_exists('final', $input))  $input['final'] = false;

            $this->contextObj->updateData($id, $input);
            $survey = Survey::find($id);

            $form = Form::find($survey->form_id);

            $form->title = array_get($request->all(),'title');
            $form->sata = array_get($request->all(),'FormData');

            $form->save();

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


    /**
     * Validate the given request with the defined rules.
     *
     * @param Request $request
     */
    protected function validator(Request $request)
    {
        $validateFields = [
            'title' => 'required|string|min:1|max:100',
            'date_start' => 'required|string|min:1',
            'date_end' => 'required|string|min:1'
        ];

        $this->validate($request, $validateFields);
    }
    
}