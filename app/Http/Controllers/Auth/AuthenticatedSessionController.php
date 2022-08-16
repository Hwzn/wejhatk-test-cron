<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Triats\AuthTriat;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    use AuthTriat;
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

public function loginForm($type)
{
    return view('auth.login',compact('type'));
}


public function login(Request $request){

   $data = Validator::make($request->all(), [
    'phone'=>'required|min:5|max:15|exists:admins,phone',
    'password'=>'required'
   ]);
        if($data->fails())
        {
            return redirect()->route('login.show',$request->type)->withErrors($data->errors());

        }
        if (Auth::guard($this->chekGuard($request))->attempt(['phone' => $request->phone, 'password' => $request->password])) {
           return $this->redirect($request);
        }

        else
        {
            return redirect()->route('login.show',$request->type);
        }
        
    }

    
    public function logout(Request $request,$type)
    {
       //return $type;
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');


        // Auth::guard('web')->logout();

        // $request->session()->invalidate();

        // $request->session()->regenerateToken();

        // return redirect('/');
    }

    // public function create()
    // {
    //     return view('auth.login');
    // }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function store(LoginRequest $request)
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return redirect()->intended(RouteServiceProvider::HOME);
    // }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();

        //Auth::guard('web')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
