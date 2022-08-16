<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use App\Models\AdsRequests;
use App\Models\AdsSocialMedia;
use App\Models\SelectType;
use App\Models\SelectTypeEelements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdsPopController extends Controller
{
    public function store(Request $request)
    {
        $rules=[
           // 'agency_name' => 'required|string|max:191',
          //  'phone' => 'required|string',
           // 'email' => 'required|string|email',
            'ads_date' => 'required|string',
            'campaign_duration' => 'required|string',
            'photo'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ];
          $validator=Validator::make($request->all(),$rules);
          if($validator->fails())
          {
              return response()->json($validator->errors(), 422);
          }

          try 
          {
              DB::beginTransaction(); 
              $image=null; 
              if($request->hasfile('photo')) 
                {
                    $file=$request->file('photo');
                    $ext=$file->getClientOriginalExtension();
                    $filename=time().'.'.$ext;
                    $file->move('assets/uploads/Ads/Popup_Ads/',$filename);
                    $image=$filename;
                }
               
                if(isset($request->agency_logo) && $request->agency_logo !==Null) $agency_logo=$request->agency_logo; else $agency_logo=false;

                $ads=AdsRequests::create([
                      'adstype_id'=>2,
                     // 'tripagent_id'=>Auth::user()->id,
                      'tripagent_id'=>Auth::user()->id,
                      'agency_name'=>Auth::user()->name,
                      'phone'=>Auth::user()->phone,
                      'email'=>null,
                      'ads_date'=>$request->ads_date,
                      'campaign_duration'=>$request->campaign_duration,
                      'expire_at'=>date('Y-m-d',strtotime($request->ads_date." + $request->campaign_duration days")),

                      'photo'=>$image,
                      'agency_logo'=>$agency_logo,

                  ]);
                  
              DB::commit();
                return response()->json([
              'message' => 'ads successfully registered',
              'user' => $ads
          ], 201);
              }
              catch(\Exception $ex){
                  DB::rollBack();
                  return response()->json([
                      'message' => $ex,
                      'user' => 'd'
                  ], 404);
              }

    }
}
