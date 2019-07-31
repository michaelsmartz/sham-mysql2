<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:sham')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        session(['timezone' => $request->timezone]);
    }

    protected function guard()
    {
        return Auth::guard('sham');
    }

    /**
     * Override original method from \Illuminate\Foundation\Auth\AuthenticatesUsers trait
     * Clear session of main logged-in user only
     */
    public function logout(Request $request)
    {
        // Get the session key for this user
        $sessionKey = $this->guard()->getName();

        // Logout current user by guard
        $this->guard()->logout();

        // Delete single session key (just for this user)
        $request->session()->forget($sessionKey);

        // After logout, redirect to login screen again
        return redirect()->route('login');
    }

}
