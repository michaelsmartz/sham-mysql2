<?php

namespace App\Http\Controllers;

use App\Team;
use App\TimeGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class TeamsController extends Controller
{

    /**
     * Display a listing of the teams.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        $teams = Team::with('timegroup')->paginate(25);

        return view('teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $timeGroups = TimeGroup::pluck('id','id')->all();
        
        return view('teams.create', compact('timeGroups'));
    }

    /**
     * Store a new team in the storage.
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
            
            Team::create($data);

            return redirect()->route('teams.team.index')
                             ->with('success_message', 'Team was successfully added!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }
    }

    /**
     * Display the specified team.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $team = Team::with('timegroup')->findOrFail($id);

        return view('teams.show', compact('team'));
    }

    /**
     * Show the form for editing the specified team.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $team = Team::findOrFail($id);
        $timeGroups = TimeGroup::pluck('id','id')->all();

        return view('teams.edit', compact('team','timeGroups'));
    }

    /**
     * Update the specified team in the storage.
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
            
            $team = Team::findOrFail($id);
            $team->update($data);

            return redirect()->route('teams.team.index')
                             ->with('success_message', 'Team was successfully updated!');

        } catch (Exception $exception) {

            return back()->withInput()
                         ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request!']);
        }        
    }

    /**
     * Remove the specified team from the storage.
     *
     * @param  int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $team = Team::findOrFail($id);
            $team->delete();

            return redirect()->route('teams.team.index')
                             ->with('success_message', 'Team was successfully deleted!');

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
            'description' => 'required|string|min:1|max:50',
            'time_group_id' => 'nullable',
     
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
        $data = $request->only(['description','time_group_id']);

        $data['is_active'] = $request->has('is_active');


        return $data;
    }

}
