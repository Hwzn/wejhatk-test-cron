<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ContactUscontroller extends Controller
{
    //
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:60|min:3',
            'phone' => 'required|max:14|min:9',
            'message'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if($request->guardkey !==null)
        {
           // $user_id=Auth::user()->id;
             if($request->guardkey=='user_1')
             {
                $data=ContactUs::create([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'message'=>$request->message,
                    'type'=>'user',
                ]);

             }
             if($request->guardkey=='tripagent_1')
             {
               
                $data=ContactUs::create([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'message'=>$request->message,
                    'type'=>'tripagent',
                ]);
             }

             if($request->guardkey=='tourguide_1')
             {
                $data=ContactUs::create([
                    'name'=>$request->name,
                    'phone'=>$request->phone,
                    'message'=>$request->message,
                    'type'=>'tourguide',
                ]);

             }
           
        }
        else
        {

            $data=ContactUs::create([
                'name'=>$request->name,
                'phone'=>$request->phone,
                'message'=>$request->message,
                'type'=>'anonymous user',
            ]);
        }
       
       
        if($data)
        {
            return response()->json([
                        'message' => 'Data  Send Successfully',
                        'data' => $data
                    ], 201);
        }
        else
        {
            return response()->json([
                'message' => 'Faild Send Data',
                'data' => ''
            ], 405);
        }

    }
}
