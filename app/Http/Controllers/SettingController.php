<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Triats\AttachFilesTriat;
class SettingController extends Controller
{
    use AttachFilesTriat;
    public function index()
    {
        $collection=Setting::all();
       // return $collection;
       $setting['settings']=$collection->flatMap(function($collection){
           return [$collection->key=>$collection->value];
       });
       //return $setting;
      return view('dashboard.pages.settings.index',$setting);
    }

    public function update(Request $request)
    {
       // return $request;
        try{
            $info=$request->except('_token','_method','logo');
            // return $info;
            foreach($info as $key=>$value)
            {
                Setting::where('key',$key)->update(['value'=>$value]);
            }

            if($request->hasFile('logo'))
            {

                //delete old logo
                $oldlog=Setting::where('key','logo')->first();
                $this->deleteFile($oldlog->value,'Schoollogo');
               
                //add new loho
               //get name of pic 1.jpg 2.jpg

                $log_name=$request->file('logo')->getClientOriginalName();
                // return $log_name;
                Setting::where('key','logo')->update(['value'=>$log_name]);
                $this->uploadFile($request,'logo','Schoollogo');
            }

            //حل اخر
            // $key=array_keys($info);
            // $value=array_values($info);
            // for($i=0;$i<count($info);$i++)
            // {
            //   Setting::where('key',$key[$i])->update(['value'=>$value[$i]]);
            // }
            toastr()->success(trans('messages.success'));
           return redirect()->route('settings.index');
        }
        catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
