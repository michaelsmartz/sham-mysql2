<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

/**
 * 
 * @group Authentication
 * 
 * API for Authentication
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    //
    public function register(Request $request)
    {
      $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
      ]);

      $token = auth()->login($user);

      return $this->respondWithToken($token);
    }

    /**
     * Log the user in
     * 
     * @group Authentication
     * 
     * @bodyParam email email required Email address
     * @bodyParam password string required Password
     * 
     * @response 200 {
     *   "access_token": "blablabla",
     *   "token_type": "bearer",
     *   "expires_in": 3600
     * }
     * 
     * @response 401 {
     *   "error": "Unauthorized"
     * }
     */
    public function login(Request $request)
    {
      $credentials = $request->only(['email', 'password']);

      if (!$token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
      }

      return $this->respondWithToken($token);
    }


    /**
     * Logging the user out
     * 
     * @group Authentication
     *
     * Invalidates the token
     * 
     * @response 200 {
     *   "message": "Successfully logged out"
     * }
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
      return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 60
      ]);
    }
    
}
