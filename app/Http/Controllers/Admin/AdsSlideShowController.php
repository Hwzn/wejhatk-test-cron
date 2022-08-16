<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdsSlideShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class AdsSlideShowController extends Controller
{
    public function index()
    {
      $AdsSlideShows=AdsSlideShow::get();
        return view('dashboard.admin.AdsSlideShow.index',compact('AdsSlideShows'));
    }

    public function store(Request $request)
    {
      $validator=Validator::make($request->all(),[
          'file'=>'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        else 
        {
            if($request->hasfile('file')) 
            {
                $file=$request->file('file');  
                $ext=$file->getClientOriginalExtension(); 
                $filename=time().'.'.$ext;
                $file->move('assets/uploads/AdsSlideShow/',$filename);
            }
           $AdsSlideShow=AdsSlideShow::create([
            'photo'=>$filename,
            ]);
            if(!is_null($AdsSlideShow)) {
                toastr()->success(trans('messages_trans.success'));
                return response()->json(['success'=>'Added new records.']);
              }
    
  
          }
    }

    public function edit($id)
    {
      $AdsSlideShow=AdsSlideShow::findorfail($id);
      // $url=request()->getHttpHost().'/public/assets/uploads/AdsSlideShow/';
      $url='/assets/uploads/AdsSlideShow/';
      $array['id']=$AdsSlideShow->id;
      $array['oldimage']=$AdsSlideShow->photo;
      $array['imageurl']=$url.$AdsSlideShow->photo;
      $array['status']=$AdsSlideShow->status;
      if($AdsSlideShow)
      {
        return response()->json($array);
      }
    }


    public function update(Request $request)
    {
    
     // return response()->json($request);
      $validator=Validator::make($request->all(),[
        'file'=>'image|mimes:jpg,png,jpeg,gif,svg',
     ]);
    if ($validator->fails())
    {
      return response()->json(['error'=>$validator->errors()->all()]);
    }
    
    $image=$request->oldimage;
    if($request->hasfile('file')) 
    {
        //هشيل الصورة الديمة
         $path='assets/uploads/AdsSlideShow/'.$request->oldimage;
         if(File::exists($path))
         {
             File::delete($path);
         }  
       
         $file=$request->file('file');
         $ext=$file->getClientOriginalExtension();
         $filename=time().'.'.$ext;
         $file->move('assets/uploads/AdsSlideShow',$filename);
         $image=$filename;
    }

    $user=AdsSlideShow::findorfail($request->id)->update([
       'photo'=>$image,
        'status'=>$request->status==1?'enabled':'disabled',
    ]);
      
    if(!is_null($user))
    {
      toastr()->success(trans('messages_trans.success'));
      return response()->json(['success'=>'updated  success.']);
    }
    }


    public function delete($id)
    {
        $data=AdsSlideShow::where('id',$id)->first();
        $path='assets/uploads/AdsSlideShow/'.$data->photo;
        if(File::exists($path))
        {
            File::delete($path);
        }  
        $data->delete($id);
        if(!is_null($data))
      {
        toastr()->error(trans('Aboutus_trans.Message_Delete'));
        return response()->json(['success'=>'deleted  success.']);
      }
    }

}
