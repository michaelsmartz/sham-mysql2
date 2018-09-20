<?php

namespace App\Http\Controllers;

use App\Assessment;
use Illuminate\Http\Request;
use App\Http\Controllers\CustomController;
use Exception;

class AssessmentsController extends CustomController
{

    /**
     * Display a listing of the assessments.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $assessments = Assessment::paginate(25);

        return view('assessments.index', compact('assessments'));
    }

    /**
     * Show the form for creating a new assessment.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        
        
        return view('assessments.create');
    }

    /**
     * Store a new assessment in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {
            $this->affirm($request);
            $data = $this->getData($request);
            
            Assessment::create($data);

            return redirect()->route('assessments.assessment.index')
                             ->with('success_message', 'Assessment was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified assessment.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $assessment = Assessment::findOrFail($id);

        return view('assessments.show', compact('assessment'));
    }

    /**
     * Show the form for editing the specified assessment.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */


    /**
     * Update the specified assessment in the storage.
     *
     * @param  int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {
            $this->affirm($request);
            $data = $this->getData($request);
            
            $assessment = Assessment::findOrFail($id);
            $assessment->update($data);

            return redirect()->route('assessments.assessment.index')
                             ->with('success_message', 'Assessment was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified assessment from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $assessment = Assessment::findOrFail($id);
            $assessment->delete();

            return redirect()->route('assessments.assessment.index')
                             ->with('success_message', 'Assessment was successfully deleted!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }
    
    /**
     * Validate the given request with the defined rules.
     *
     * @param  Illuminate\Http\Request  $request
     *
     * @return boolean
     */
    protected function affirm(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:1|max:1024',
            'description' => 'required|string|min:1|max:1024',
            'passmark_percentage' => 'nullable|numeric|min:-9|max:9',
     
        ];


        return $this->validate($request, $rules);
    }

    
    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request 
     * @return array
     */
    protected function getData(Request $request)
    {
        $data = $request->only(['name','description','passmark_percentage']);
        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
