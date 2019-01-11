<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class TokenChecker
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
        $token = $request->header('token');  

        $user = User::isValidToken($token); 

        if(is_null($user) || is_null($token) ){
            return response()->json([
                'success'       =>      false, 
                'message'       =>      'Invalid Token. Please relogin again to access restricted page.',
            ],200);
        }

        return $next($request);
    } 
}
