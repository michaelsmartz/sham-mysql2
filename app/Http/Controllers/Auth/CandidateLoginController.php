<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CandidatesController;
use App\Http\Controllers\Controller;
use Auth;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use Redirect;

class CandidateLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('guest:candidate')->except('logout');
        Debugbar::disable();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('public.candidate-login');
    }

    public function loginCandidate(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (Auth::guard('candidate')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        if(Auth::guard('candidate')->user()->profil_complete == 1){
            return redirect()->intended(route('candidate.vacancies'));
        }else{
            return redirect()->intended(route('candidate.auth.details'));
        }

      }

      // if unsuccessful, then redirect back to the login with the form data
      $errors = new MessageBag(['password' => ['Email and/or password invalid.']]);
      return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        $candidate = new CandidatesController();
        return $candidate->edit($request,'external');
    }

    public function logout()
    {
        Auth::guard('candidate')->logout();
        return redirect()->route('candidate.vacancies');
    }
}