<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdsList;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdsListController extends Controller
{
    public function index()
    {
       $data['ads_list']=AdsList::orderby('id','desc')->get();
       $data['currency']=Currency::orderby('id','desc')->get();
        return  view('dashboard.admin.ads.ads_list.index')->with($data);
    }

    public function store(Request $request)
    {
        // return $request;
      $List_adsAttrbiteselemnt=$request->List_adsAttrbiteselemnt;
      $val=$request->validate([
       'List_adsAttrbiteselemnt.*.appearance_order'=>'required',
       'List_adsAttrbiteselemnt.*.duration_ar'=>'required',
       'List_adsAttrbiteselemnt.*.duration_en'=>'required',
       'List_adsAttrbiteselemnt.*.price'=>'required',
       'List_adsAttrbiteselemnt.*.duration_en'=>'required',
       'List_adsAttrbiteselemnt.*.currency_id'=>'required',

       
       'List_adsAttrbiteselemnt.*.appearance_order.required'=>trans('validation.required'),
       'List_adsAttrbiteselemnt.*.duration_ar.required'=>trans('validation.required'),
       'List_adsAttrbiteselemnt.*.duration_en.required'=>trans('validation.required'),
       'List_adsAttrbiteselemnt.*.price.required'=>trans('validation.required'),
       'List_adsAttrbiteselemnt.*.currency_id.required'=>trans('validation.required'),

      ]);
 
 try{ 
   
   foreach($List_adsAttrbiteselemnt as $List_adsAttrbiteselemnt)
   {
    
   
     DB::table('ads_lists')->insert([
          'appearance_order'=>$List_adsAttrbiteselemnt['appearance_order'],
          'duration'=>json_encode(["en"=>$List_adsAttrbiteselemnt['duration_en'],"ar"=>$List_adsAttrbiteselemnt['duration_ar']]),
          'price'=>$List_adsAttrbiteselemnt['price'],
          'currency_id'=>$List_adsAttrbiteselemnt['currency_id'],
          'created_at'=>now(),
          'updated_at'=>now(),
     ]);
   
   }
   toastr()->success(trans('messages_trans.success'));
   return redirect()->route('show_adsList');
 }
 catch (\Exception $e){
   return redirect()->back()->withErrors(['error' => $e->getMessage()]);
 }
    }

    public function edit($id)
    {
      $ads=AdsList::findorfail($id);
      if($ads)
      {
        return response()->json($ads);
      }
    }
}
