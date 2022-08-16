<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
class CheckTripagentToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
                auth()->shouldUse('tripagent-api');
                $token = $request->header('auth-token');
                $request->headers->set('auth-token', (string) $token, true);
                $request->headers->set('Authorization', 'Bearer '.$token, true);
               $user=null;
                try {
                   $user=JWTAuth::parseToken()->authenticate();
                //    return response()->json($user);
                   if($user==false)
                   {
                    return response()->json(['status' => 'Token is Invalid']);
                   }
                }
                
                catch (\Exception $e) 
                {
                    if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                        return response()->json(['status' => 'Token is Invalid']);
                    }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                        return response()->json(['status' => 'Token is Expired']);
                    }else{
                       return response()->json(['status' => 'Authorization Token not found']);
                    }
                }
                return $next($request);

            
        
      
    }
}
