<?php

namespace App\Http\Controllers;

use App\CategoryQuestion;
use Illuminate\Http\Request;
use App\CategoryQuestionType;
use App\Http\Controllers\CustomController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Exception;

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
    public function index()
    {
        $categoryQuestions = $this->contextObj::filtered()->paginate(10);
        return view($this->baseViewPath .'.index', compact('categoryQuestions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryQuestionTypes = CategoryQuestionType::pluck('description','id')->all();
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

        dump(Input::all());die;

        try {
            //$this->validator($request);

            $input = array_except($request->all(),array('_token'));

            $this->contextObj->addData($input);

            \Session::put('success', $this->baseFlash . 'created Successfully!');

        } catch (Exception $exception) {
            dump($exception->getMessage());
            die;
            \Session::put('error', 'could not create '. $this->baseFlash . '!');
        }

        return redirect()->route($this->baseViewPath .'.index');

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
            $this->validator($request);

            $input = array_except($request->all(),array('_token','_method'));

            $this->contextObj->updateData($id, $input);

            \Session::put('success', $this->baseFlash . 'updated Successfully!!');

        } catch (Exception $exception) {
            \Session::put('error', 'could not update '. $this->baseFlash . '!');
        }

        return redirect()->back();
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