<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
class ContactUsController extends Controller
{
    public function index()
    {
        $contact_message=ContactUs::orderby('id','desc')->get();
        return view('dashboard.admin.contactus.index',compact('contact_message'));
    }

    public function showmessage($id)
    {
        $message=ContactUs::findorfail($id);
       if($message) return response()->json($message);
 
    }
}
