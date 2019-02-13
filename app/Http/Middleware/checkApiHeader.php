<?php

namespace App\Http\Middleware;

use Closure;

class checkApiHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $status = false;
        $accessToken = $request->header('AccessToken');
        if($accessToken) {
            $user_check = User::where("api_token", $accessToken)->first();
            if(count($user_check) > 0) 
            {
               $status = true;
            }
        }

        if($status == false) {
            return response()->json([
                'code' => 401,
                'msg' => trans('web_service.unathenticated')
            ]);
        } else {
            return $next($request);
        }
    }
}
