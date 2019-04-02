<?php

namespace App\Http\Controllers;

use App\CategoryQuestion;
use Illuminate\Http\Request;
//use App\CategoryQuestionType;
use App\CategoryQuestionChoice;
use App\Enums\CategoryQuestionType;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Exception;
use App\SystemSubModule;
use App\Support\Helper;

class CategoryQuestionsController extends CustomController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->contextObj = new CategoryQuestion();
        $this->baseViewPath = 'category_questions';
        $this->baseFlash = 'Category Question details ';
    }

    /**
     * Display a listing of the category questions.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = $request->get('title', null);
        $description = $request->get('description', null);

        $allowedActions = Helper::getAllowedActions(SystemSubModule::CONST_CATEGORY_QUESTIONS);

        if(!empty($title)){
            $request->merge(['title' => '%'.$title.'%']);
        }
        if(!empty($description)){
            $request->merge(['description' => '%'.$description.'%']);
        }

        $categoryQuestions = $this->contextObj::with('categoryQuestionType')
            ->filtered()->paginate(10);

        //resend the previous search data
        session()->flashInput($request->input());

        return view($this->baseViewPath .'.index', compact('categoryQuestions','allowedActions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$categoryQuestionTypes = CategoryQuestionType::pluck('description','id')->all();
        $categoryQuestionTypes = CategoryQuestionType::ddList();
        return view($this->baseViewPath . '.create', compact('data','categoryQuestionTypes'));
    }

    /**
     * Store a new category question in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        //dump(Input::all());die;
        try {
            //$this->validator($request);

            $input = array_except($request->all(),array('_token'));

            $data = $this->contextObj->addData($input);

            if (Input::has('Choices'))
            {
                $choices = Input::get('Choices');

                foreach($choices as $choice)
                {
                    //dump($choice['Choice']);die;
                    if ( !empty($choice['Choice']))
                    {
                        $categoryquestionchoice = new CategoryQuestionChoice();
                        $categoryquestionchoice->category_question_id = $data->id;
                        $categoryquestionchoice->choice_text = $choice['Choice'];
                        $categoryquestionchoice->points = $choice['Point'];
                        $data->categoryQuestionChoices()->save($categoryquestionchoice);
                    }
                }
            }

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            //dump($exception->getMessage());die;
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');

    }

    public function edit(Request $request)
    {

        $data = null;
        $_mode = 'edit';
        $fullPageEdit = true;
        $id = Route::current()->parameter('category_question');

        if(!empty($id)) {
            $data = $this->contextObj->findData($id);
        }
        //$categoryQuestionTypes = CategoryQuestionType::pluck('description','id')->all();
        $categoryQuestionTypes = CategoryQuestionType::ddList();

        $categoryquestionchoices = CategoryQuestionChoice::where('category_question_id',$id)->get();

        $categoryquestionchoicesCount = $categoryquestionchoices->count();

        return view($this->baseViewPath .'.edit',
            compact('_mode','fullPageEdit','data','categoryQuestionTypes','categoryquestionchoices','$categoryquestionchoicesCount'));
    }

    /**
     * Update the specified category question in the storage.
     *
     * @param  int $id
     * @param Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        try {
            //$this->validator($request);

            $input = array_except($request->all(),array('_token','_method'));
            $redirectsTo = $request->get('redirectsTo', route($this->baseViewPath .'.index'));

            $this->contextObj->findData($id)->categoryQuestionChoices()->delete();
            $data = $this->contextObj->findData($id);

            if (Input::has('Choices'))
            {
                $choices = Input::get('Choices');

                foreach($choices as $choice)
                {
                    //dump($choice['Choice']);die;
                    if ( !empty($choice['Choice']))
                    {
                        $categoryquestionchoice = new CategoryQuestionChoice();
                        $categoryquestionchoice->category_question_id = $data->id;
                        $categoryquestionchoice->choice_text = $choice['Choice'];
                        $categoryquestionchoice->points = $choice['Point'];
                        $data->categoryQuestionChoices()->save($categoryquestionchoice);
                    }
                }

                unset($input['Choices']);
            }


            unset($input['Id1']);
            unset($input['Choice']);
            unset($input['ChoicePoint']);

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            dump($exception->getMessage());die;
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return Redirect::to($redirectsTo);
    }

    /**
     * Remove the specified category question from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        try {
            $id = Route::current()->parameter('category_question');
            $this->contextObj->destroyData($id);

            \Session::put('success', $this->baseFlash . 'deleted Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not delete '. $this->baseFlash . '!');
        }

        return redirect()->back();
    }
    
    
}