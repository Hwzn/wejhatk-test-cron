<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Serivce;
use App\Models\Tripagent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\AdsSlideShow;
use App\Models\PlacesToVisit;
use App\Models\TermsandCondition;
use App\Models\TourGuide;
use App\Models\TripagentsService;
use App\Models\UsagePolicy;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    use ApiResponseTrait;
    
public function updateuser(Request $request)
{
    $user=Auth::user();

    $data = Validator::make($request->all(), [
         'name' => 'required|string|max:255|',
         'phone' => 'required|string|unique:users,phone,'.$user->id,
          'password' => ['required', 'confirmed', Rules\Password::defaults()],
          'photo'=>'image|mimes:jpg,png,jpeg,gif,svg',
    ]);
    if($data->fails()){
        return response()->json($data->errors()->toJson(), 400);
    }
    try{
       DB::beginTransaction();
        $image=$user->photo;

        if($request->hasfile('photo')) 
        {
            //هشيل الصورة الديمة
             $path='assets/uploads/Profile/UserProfile/'.$image;
             if(File::exists($path))
             {
                 File::delete($path);
             }  
           
             $file=$request->file('photo');
             $ext=$file->getClientOriginalExtension();
             $filename=time().'.'.$ext;
             $file->move('assets/uploads/Profile/UserProfile',$filename);
             $image=$filename;
        }
    
        $user=User::findorfail($user->id)->update([
            'name'=>$request->name,
            'phone'=>$request->phone,
            'password'=>bcrypt($request->password),
            'verified_at'=>$user->verified_at,
            'photo'=>$image,
        ]);

        DB::commit();
        return response()->json([
                    'message' => 'User successfully Updated',
                    'user' => $user
                ], 201);
                    
    
    }
    catch(\Exception $ex){
        DB::rollBack();
        return response()->json([
            'message' => $ex,
            'user' => 'd'
        ], 404);
    }

    // return response()->json($user);
}

//restpassword
public function resetpassword(Request $request)
{
    $data = Validator::make($request->all(), [
         'current_password' => 'required',
         'new_password'=> ['required','string','min:3','max:10'],
         'password_confirm'=>'required|same:new_password|string|min:3|max:10',

   ]);
   if($data->fails()){
       return response()->json($data->errors()->toJson(), 400);
   }
    $current_user=Auth::user();
    $currentpassword=$request->current_password;
    if(password_verify($currentpassword,$current_user->password))
    {
        $user=DB::table('users')->where('id',$current_user->id)->update([
         'password'=>bcrypt($request->new_password),
         'updated_at'=>now(),
       ]);
       return response()->json([
           'message'=>'password updated',
           'data'=>$user,
       ],201);

    }
    else   return response()->json('Password User Entered Is Incorrect');

}
//resetpassword
    public function userhomepage($lang)
    {
      $data['services']=Serivce::select('id',"name->$lang as 'service_name'")
                        ->where('status','active')
                        ->orderby('id','desc')->get();

      $data['tripagents']=Tripagent::select('id',"name->$lang as 'Tripagent_Name'",'photo','starnumber')
                          ->where('type','Tourism_Company')
                          ->where('verified_at',"!=",Null)
        ->orderby('id','desc')->take(4)->get();
        

        $data['placestovisit']=PlacesToVisit::select('id',"name->$lang as 'PlaceVisit_Name'",'photo','desc')
                          ->where('status','active')
                          ->orderby('id','desc')->take(4)->get();

        $data['tourguides']=TourGuide::select('id',"name->$lang as 'Tourguide_Name'",'photo','starnumber')
                          ->where('verified_at',"!=",Null)
                          ->orderby('id','desc')->take(4)->get();

        $data['educational_service']=Tripagent::select('id',"name->$lang as 'Tripagent_Name'",'photo','starnumber')
                           ->where('type','educational_service')
                           ->where('verified_at',"!=",Null)
                           ->orderby('id','desc')->take(4)->get();
    
        if(!is_null($data))
        {
           return $this->apiResponse($data,'ok',200);
        }
        else{
           return $this->apiResponse("",'not data found',404);
        }

    }

    //
    public function getallTourism_tripgents($lang)
    {
      
         $data['Tripagents']=Tripagent::select('id',"name->$lang as Tripagent",'phone','photo','desc')
         ->where('type','Tourism_Company')
         ->where('verified_at','!=',Null)
        ->orderby('id','desc')->paginate(10);
         
        $TripAgent=array();
        $HostName=request()->getHttpHost();
        if($data['Tripagents']->count()>0)
        {
           foreach($data['Tripagents'] as $data)
           {
              $array['id']=$data->id;
              $array['Tripagent']=$data->Tripagent;
              $array['phone']=$data->phone;
              $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$data->photo;
              $array['desc']=$data->desc;
              array_push($TripAgent,$array);
           }
          return $this->apiResponse($TripAgent,'ok',200);
         }
        else
        {
           return $this->apiResponse("",'not data found',404);
        }

    }

   //
    public function alleducationcompany_tripgents($lang)
    {
      $data['Tripagents']=Tripagent::select('id',"name->$lang as Tripagent",'phone','photo','desc')
         ->where('type','educational_service')
         ->where('verified_at','!=',Null)
        ->orderby('id','desc')->paginate(10);
         
        $TripAgent=array();
        $HostName=request()->getHttpHost();
        if($data['Tripagents']->count()>0)
        {
           foreach($data['Tripagents'] as $data)
           {
              $array['id']=$data->id;
              $array['Tripagent']=$data->Tripagent;
              $array['phone']=$data->phone;
              $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$data->photo;
              $array['desc']=$data->desc;
              array_push($TripAgent,$array);
           }
          return $this->apiResponse($TripAgent,'ok',200);
         }
        else
        {
           return $this->apiResponse("",'not data found',404);
        }

    }

   
    public function get_tripagentbyid($lang,$id)
    {
      
         $data=Tripagent::select('id',"name->$lang as Tripagent",'phone','photo','type','desc')
         ->where('id',$id)
         ->first();
         
        $HostName=request()->getHttpHost();
         if(!$data==Null)
         {
            $array['id']=$data->id;
            $array['tripagent']=$data->Tripagent;
            $array['phone']=$data->phone;
            $array['type']=$data->type;
            $array['photo']="$HostName/assets/uploads/Profile/TripAgent/".$data->photo;
            $array['desc']=$data->desc;
            return $this->apiResponse($array,'ok',200);
         }
         else
         {
            return $this->apiResponse("",'not data found',404);

         }
          
             
         }
       



    public function getTripgents_byServiceid($lang,$id)
    {
   //   $data=Serivce::with('Tripagents')->findorfail($id);
    $data=Serivce::select('id',"name->$lang as 'Service_Name'")
         ->with(['Tripagents'=>function($query) use($lang){
          $query->select('trip_agents.id',"name->$lang as 'Tripagent_Name'",'phone','photo')
             ->where('trip_agents.verified_at',"!=",Null);
    }])->find($id);

        if($data)
        { 
         return $this->apiResponse($data,'ok',200);
        }
        else{
           return $this->apiResponse("",'No Data Found',404);
      }
    }

    public function getservices_byTripagentid($lang,$id)
    {
      $data=Tripagent::select('id',"name->$lang as 'TripAgent'",'photo','starnumber')
           ->with(['Services'=>function($query) use($lang){
          $query->select('serivces.id',"name->$lang as 'service_name'")
                 ->where('status','active');
       }])->find($id);
        if($data)      
        {
         return $this->apiResponse($data,'ok',200);
        }
        else
        {
           return $this->apiResponse("",'No Data Found',404);
        }

    }

    public function getservice_attributes($id)
    {

      $data=Serivce::select('serivces.id','serivces.name')->with(['attributes'=>function($query){
         $query->select('attributes.id','attributes.name','attribute_types.name as attributetype_name','attr_typeid')
         ->join('attribute_types','attributes.attr_typeid', '=', 'attribute_types.id')
         ->orderby('id','asc');
      }])->find($id);
       if($data)
       {
         return $this->apiResponse($data,'ok',200);
       }
       else{
          return $this->apiResponse("",'No Data Found',404);
       }

    }

    public function showall_tourguides($lang)
    {
      if(TourGuide::get()->count()>0) 
      {
         $HostName=request()->getHttpHost();
         $data['TourGuides']=Tourguide::select('id',"name->$lang as TourGuide",'phone','photo')
         ->where('verified_at',"!=",Null)
         ->orderby('id','desc')->paginate(10);
         $TourGuide=[];
         foreach($data['TourGuides'] as $data)
         {
            $array['id']=$data->id;
            $array['TourGuide']=$data->TourGuide;
            $array['phone']=$data->phone;
            $array['photo']="$HostName/assets/uploads/Profile/TourGuide/".$data->photo;
            array_push($TourGuide,$array);
         }
     return $this->apiResponse($TourGuide,'ok',200);

      }
      
        else
        {
           return $this->apiResponse("",'not data found',404);
        }

    }

  
    public function showtourguide_byid($lang,$id)
    {
     if(Tourguide::where('id',$id)->where('verified_at',"!=",Null)->exists())
     {
      $HostName=request()->getHttpHost();
      $data['TourGuide']=Tourguide::select('id',"name->$lang as TourGuide",'phone','photo')
       ->orderby('id','desc')
       ->where('id',$id)
       ->first();
      
         $array['id']=$data['TourGuide']->id;
         $array['TourGuide']=$data['TourGuide']->TourGuide;
         $array['phone']=$data['TourGuide']->phone;
         $array['photo']="$HostName/assets/uploads/Profile/TourGuide/".$data['TourGuide']->photo;

         return $this->apiResponse($array,'ok',200);
      
     
     }
     else
     {
      return $this->apiResponse("",'not data found',404);
     }

    }


    public function show_placesTovisits($lang)
    {
      $HostName=request()->getHttpHost();
      $data['PlacesToVisit']=PlacesToVisit::select('id',"name->$lang as Place_Name",'photo')
            ->paginate(10);
       $PlaceToVisit=[];
      foreach($data['PlacesToVisit'] as $data)
       {
          $array['id']=$data->id;
          $array['Place_name']=$data->Place_Name;
          $array['ImageURL']="$HostName/assets/uploads/PlacesToVisit/".$data->photo;
         array_push($PlaceToVisit,$array);
        }

      if($PlaceToVisit)
       {
         return $this->apiResponse($PlaceToVisit,'ok',200);

       }
       else
       {
        return $this->apiResponse("",'not data found',404);
       }
    }

    public function viewplacevisit_details($lang,$id)
    {
      $HostName=request()->getHttpHost();
      $data=PlacesToVisit::select('id',"name->$lang as Place_Name",'photo')
                           ->where('id',$id)
                           ->first();
      if($data !==Null)
       {
          $array['id']=$data->id;
          $array['Place_name']=$data->Place_Name;
          $array['ImageURL']="$HostName/assets/uploads/PlacesToVisit/".$data->photo;
          return $this->apiResponse($array,'ok',200);

         }
       else
       {
        return $this->apiResponse("",'not data found',404);
       }
    }

    public function allsearch($name)
    {
        $data[0]=Tourguide::select('name as TourGuide','desc')->where("tour_guides.name",'like','%'.$name.'%')->
                            orwhere("tour_guides.desc",'like','%'.$name.'%')->get();
        $data[1]=Tripagent::select('name as Tripagent','desc')->where("trip_agents.name",'like','%'.$name.'%')->
                           orwhere("trip_agents.desc",'like','%'.$name.'%')->get();
        $data[2]=Serivce::select('name as Serivcename','desc')->where("serivces.name",'like','%'.$name.'%')->
                           orwhere("serivces.desc",'like','%'.$name.'%')->get();
        if($data)
        {
           return $this->apiResponse($data,'ok',200);
        }
        else{
           return $this->apiResponse("",'not data found',404);
        }

    }

    public function showtermscondition($lang)
    {
      if(TermsandCondition::get()->count()>0)
      {
         $data=TermsandCondition::select('id',"desc->$lang as 'desc'")->get();
         return $this->apiResponse($data,'ok',200);

      }
      else
      {
         return $this->apiResponse('','No Data Found',404);
      }
    }

    public function showusageploicy($lang)
    {
      if(UsagePolicy::get()->count()>0)
      {
         $data=UsagePolicy::select('id',"desc->$lang as 'desc'")->get();
         return $this->apiResponse($data,'ok',200);

      }
      else
      {
         return $this->apiResponse('','No Data Found',404);
      }
    }

    public function showads_slideshow()
    {
      $url=request()->getHttpHost();
      $datas=AdsSlideShow::where('status','enabled')
                           ->orderby('id','desc')
                           ->take(4)
                           ->get();
       $AdsSlideshow=array();
       foreach($datas as $data)
       {
         $array['id']=$data->id;
         $array['photo']="$url/assets/uploads/AdsSlideShow/".$data->photo;
         $array['status']=$data->status;
         array_push($AdsSlideshow,$array);
       }
      
      if(count($AdsSlideshow)>0)
      {
         return $this->apiResponse($AdsSlideshow,'ok',200);
      }
      else{
         return $this->apiResponse('','No Data Found',404);

      }
    }
    

}
