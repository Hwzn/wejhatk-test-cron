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

class AdsSocialMediaController extends Controller
{
    public function show_dropdownlistsocial($lang)
    {
        $lang=strtolower($lang);
        $data['ads']=Ads::select('id',"name->$lang as AdsName")->get();
         
        $data['ads_socialmediatypes']=SelectTypeEelements::where('selecttype_id',15)
          ->pluck("name->$lang as SocialMediaName");
           
          $data['ads_types']=SelectTypeEelements::where('selecttype_id',17)
          ->pluck("name->$lang as AdsType");
         
        return response($data);
    }

    public function store(Request $request)
    {
        $rules=[
            
            'agency_name' => 'required|string|max:191',
            'phone' => 'required|string',
            'email' => 'required|string|email',
            'social_media_platform' => 'required|string',
            'number_of_times_placed_ads' => 'required|string',
            'ads_type' => 'required|string',
            'ads_description' => 'required|string',
            'photo'=>'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'ads_date' => 'required|string',
            'ads_time' => 'required|string',
            'addational_information' => 'nullable|string',
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
                    $file->move('assets/uploads/Ads/SocialMedia/',$filename);
                    $image=$filename;
                }
               
                if(isset($request->ads_description) && $request->ads_description !==Null) $ads_description=$request->ads_description; else $ads_description=null;
                if(isset($request->addational_information) && $request->addational_information !==Null) $addational_information=$request->addational_information; else $addational_information=null;
                if(isset($request->agency_logo) && $request->agency_logo !==Null) $agency_logo=$request->agency_logo; else $agency_logo=false;

                $ads=AdsRequests::create([
                      'adstype_id'=>1,
                      'tripagent_id'=>Auth::user()->id,
                      'agency_name'=>$request->agency_name,
                      'phone'=>$request->phone,
                      'email'=>$request->email,
                      'social_media_platform'=>$request->social_media_platform,
                      'number_of_times_placed_ads'=>$request->number_of_times_placed_ads,
                      'ads_type'=>$request->ads_type,
                      'ads_description'=>$ads_description,
                      'photo'=>$image,
                      'agency_logo'=>$agency_logo,
                      'ads_date'=>$request->ads_date,
                      'ads_time'=>$request->ads_time,
                      'addational_information'=>$addational_information,

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
