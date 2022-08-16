<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class VerifyCode
{
   
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('web')->check())
        {
            if(Auth::user()->verified_at==null)
            {
                // return redirect(route('register'));
            return redirect()->route('put_otpcode');
            }
        }
        return $next($request);

    }
}
