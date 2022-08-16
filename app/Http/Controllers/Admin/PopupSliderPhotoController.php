<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PopupSliderPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class PopupSliderPhotoController extends Controller
{
    public function index()
    {
        $popslider=PopupSliderPhoto::orderby('id','desc')->get();
        return view('dashboard.admin.ads.popupads.popupphoto_slider.index',compact('popslider'));
    }

    public function edit($id)
    {
        $pop_photo=PopupSliderPhoto::where('id',$id)->first();
        if($pop_photo)
        {
           return response($pop_photo);
        }
    }

    public function view_popattachment($filename)
    {
      return response()->download('assets/uploads/popup_slider/'.$filename);

    }

    public function store(Request $request)
    {
      // return response($request) ;
       
        $validator = Validator::make($request->all(),
        [
             'expired_at'=>'required',
             'expired_at.required'=>trans('validation.required'),
             'file'=>'image|mimes:jpg,png,jpeg,gif,svg',
     
        ]);
        $image=Null;
        if ($validator->fails())
        {
        return response()->json(['error'=>$validator->errors()->all()]);

        }
        else {
          if($request->hasfile('file')) 
          {
              $file=$request->file('file');  
              $ext=$file->getClientOriginalExtension(); 
              $filename=time().'.'.$ext;
              $file->move('assets/uploads/popup_slider/',$filename);
              $image=$filename;
          }
            $popslider=PopupSliderPhoto::create([
              
              'expired_at'=>$request->expired_at,
              'photo'=>$image,
            ]);
            if(!is_null($popslider)) {
              toastr()->success(trans('messages_trans.success'));
              return response()->json(['success'=>'Added new records.']);
              //return redirect()->route('showservices');
            }
  
          }
    }
    
public function delete($id)
{
  $popslider=PopupSliderPhoto::where('id',$id)->first();
  $path='assets/uploads/popup_slider/'.$popslider->photo;
  if(File::exists($path))
  {
      File::delete($path);
  }  
  $popslider->delete($id);
  if(!is_null($popslider))
{
  toastr()->error(trans('Service_trans.Message_Delete'));
  return response()->json(['success'=>'deleted  success.']);
}
}
public function update(Request $request)
{
   
    $validator = Validator::make($request->all(),
    [
         'expired_at'=>'required',
         'expired_at.required'=>trans('validation.required'),
         'file'=>'image|mimes:jpg,png,jpeg,gif,svg',
 
    ]);
    $image=Null;
    if ($validator->fails())
    {
    return response()->json(['error'=>$validator->errors()->all()]);

    }
    $image=$request->oldphoto;
      if($request->hasfile('file')) 
      {
          //هشيل الصورة الديمة
           $path='assets/uploads/popup_slider/'.$request->oldphoto;
           if(File::exists($path))
           {
               File::delete($path);
           }  
         
           $file=$request->file('file');
           $ext=$file->getClientOriginalExtension();
           $filename=time().'.'.$ext;
           $file->move('assets/uploads/popup_slider',$filename);
           $image=$filename;
      }
   
        $popslider=PopupSliderPhoto::where('id',$request->id)->update([
          'expired_at'=>$request->expired_at,
          'photo'=>$image,
          'status'=>$request->status==1?'active':'notactive',
        ]);
        if(!is_null($popslider)) {
          toastr()->success(trans('messages_trans.success'));
          return response()->json(['success'=>'Added new records.']);
          //return redirect()->route('showservices');
        }

      }
}
    


