<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            // Auth::guard('web')->logout();
            // Auth::guard('student')->logout();
            // Auth::guard('admin')->logout();
            if (Request::is(app()->getLocale() . '/student/dashboard')) {
              
                return route('selection');
            }
            elseif(Request::is(app()->getLocale() . '/teacher/dashboard')) {
                return route('selection');
            }
            elseif(Request::is(app()->getLocale() . '/parent/dashboard')) {
                return route('selection');
            }
            elseif(Request::is(app()->getLocale() . '/dashboard')) {
                return route('selection');
            }
            else {
                return route('selection');
            }
        
            // if (Request::is(app()->getLocale() . '/dashboard/admin')) {
            //     return route('selection');
            // }
            // elseif(Request::is(app()->getLocale() . '/dashboard/student')) {
            //     return route('selection');
            // }
            // elseif(Request::is(app()->getLocale() . '/dashboard/teacher')) {
            //     return route('selection');
            // }
            // elseif(Request::is(app()->getLocale() . '/dashboard/parent')) {
            //     return route('selection');
            // }
            
        }
    }
}
