<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }
    public function index()
    {
        return view('auth.selection');
    }
    public function dashboard()
    {
       // print_r('kkkkk');die;
        return view('dashboard');
    }
}
