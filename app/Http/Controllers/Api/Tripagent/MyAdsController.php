<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use App\Models\AdsRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;

class MyAdsController extends Controller
{
  use ApiResponseTrait;
    public function myads_active($lang,$id)
    {
        $lang=strtolower($lang);
        //الاعلانات الجارية
        if($id==1)
        {
                $Myads=AdsRequests::select('ads_requests.id','agency_name',"ads.name->$lang as ads_type"
                ,'ads_requests.status','actual_price as ads_price','ads_requests.created_at'
                ,'ads_requests.expire_at')
                ->join('ads','ads.id','=','ads_requests.adstype_id')
                //    ->where(function($query){

                //    });
                //    ->function($query)
                ->where('tripagent_id',Auth::user()->id)
                ->where('ads_requests.status','paid')
                ->where('ads_requests.expire_at','>',now())
                ->orwhere('ads_requests.expire_at',null)
                ->orderby('ads_requests.id','desc')
                ->get();
                $ads=[];
                foreach($Myads as $Myad)
                {
                if($Myad->status=='paid') 
                {
                $data['id']=$Myad->id;
                //  $data['agency_name']=$Myad->agency_name;
                $data['ads_type']=$Myad->ads_type;
                $data['status']=$Myad->status;
                //  $data['ads_price']=$Myad->ads_price . 'KSA';
                $data['expire_at']=!$Myad->expire_at==null?$Myad->expire_at:0;
                //  $data['created_at']=$Myad->created_at;
                array_push($ads,$data);
                }

                }

                if($ads)      
                {
                return $this->apiResponse($ads,'ok',200);
                }
                else
                {
                return $this->apiResponse("",'No Data Found',404);
                }
        }

        //الاعلانات المعلقة
        if($id==2)
        {
                $Myads=AdsRequests::select('ads_requests.id','agency_name',"ads.name->$lang as ads_type"
                ,'ads_requests.status','actual_price as ads_price','ads_requests.created_at'
                ,'ads_requests.expire_at','ads_requests.admin_desc')
                ->join('ads','ads.id','=','ads_requests.adstype_id')
                //    ->where(function($query){

                //    });
                //    ->function($query)
                ->where('tripagent_id',Auth::user()->id)
                ->where('ads_requests.status','refused')
                ->orderby('ads_requests.id','desc')
                ->get();
                $ads=[];
                foreach($Myads as $Myad)
                {
               
                $data['id']=$Myad->id;
                $data['ads_type']=$Myad->ads_type;
                $data['status']=$Myad->status;
                $data['refused_resaon']=$Myad->admin_desc;
                array_push($ads,$data);

                }

                if($ads)      
                {
                return $this->apiResponse($ads,'ok',200);
                }
                else
                {
                return $this->apiResponse([],'No Refused ads Found',404);
                }
        }

        //الاعلانات المرفوضة
        if($id==3)
        {
                $Myads=AdsRequests::select('ads_requests.id','agency_name',"ads.name->$lang as ads_type"
                ,'ads_requests.status','actual_price as ads_price','ads_requests.created_at'
                ,'ads_requests.expire_at','ads_requests.admin_desc')
                ->join('ads','ads.id','=','ads_requests.adstype_id')
                //    ->where(function($query){

                //    });
                //    ->function($query)
                ->where('tripagent_id',Auth::user()->id)
                ->where('ads_requests.status','refused')
                ->orderby('ads_requests.id','desc')
                ->get();
                $ads=[];
                foreach($Myads as $Myad)
                {
               
                $data['id']=$Myad->id;
                $data['ads_type']=$Myad->ads_type;
                $data['status']=$Myad->status;
                $data['refused_resaon']=$Myad->admin_desc;
                array_push($ads,$data);

                }

                if($ads)      
                {
                return $this->apiResponse($ads,'ok',200);
                }
                else
                {
                return $this->apiResponse([],'No Refused ads Found',404);
                }
        }
    }

    public function myads_details($id,$lang)
    {
        $lang=strtolower($lang);
        $HostName=request()->getHttpHost();

        $Myads=AdsRequests::select('ads_requests.id','agency_name',"ads.name->$lang as ads_type"
        ,'ads_requests.status','ads_requests.expire_at','actual_price as ads_price','ads_requests.created_at'
        ,'ads_requests.adstype_id','social_media_platform','number_of_times_placed_ads',
        'ads_description','photo','agency_logo','ads_date','ads_time','addational_information',
        'campaign_duration','admin_desc','phone','email'
        )
        ->join('ads','ads.id','=','ads_requests.adstype_id')
        ->where('tripagent_id',Auth::user()->id)
        ->where('ads_requests.id',$id)
        ->first();
       
        if($Myads->adstype_id==1)
        {
            $data['id']=$Myads->id;
            $data['agency_name']=$Myads->agency_name;
            $data['phone']=$Myads->phone;
            $data['email']=$Myads->email;
            $data['ads_type']=$Myads->ads_type;
            $data['ads_date']=$Myads->ads_date;
            $data['ads_time']=$Myads->ads_time;

            $data['social_media_platform']=$Myads->social_media_platform;
            $data['number_of_times_placed_ads']=$Myads->number_of_times_placed_ads;
            $data['ads_description']=$Myads->ads_description;
            if(!is_null($Myads->photo))
            {
              $data['photo']="$HostName/assets/uploads/Ads/Popup_Ads/".$Myads->photo;
            }
            else
            {
                $data['photo']=null;
            }

            if($Myads->agency_logo==0)$data['agency_logo']='No';else $data['agency_logo']='Yes';
            
            $data['addational_information']=$Myads->addational_information;
            $data['admin_desc']=$Myads->admin_desc;


            $data['status']=$Myads->status;
            $data['ads_price']=$Myads->ads_price . 'KSA';

            $data['expired_at']=$Myads->expire_at;
            $data['created_at']=$Myads->created_at;
        }
        
        if($Myads->adstype_id==2)
        {
            $data['id']=$Myads->id;
            $data['agency_name']=$Myads->agency_name;
            $data['ads_type']=$Myads->ads_type;
            $data['ads_date']=$Myads->ads_date;
            $data['campaign_duration']=$Myads->campaign_duration;
            $data['admin_desc']=$Myads->admin_desc;
            $data['status']=$Myads->status;

            $data['ads_price']=$Myads->ads_price . 'KSA';
            if(!is_null($Myads->photo))
            {
              $data['photo']="$HostName/assets/uploads/Ads/Popup_Ads/".$Myads->photo;
            }
            else
            {
                $data['photo']=null;
            }

            if($Myads->agency_logo==0)$data['agency_logo']='No';else $data['agency_logo']='Yes';
            $data['expired_at']=$Myads->expire_at;
            $data['created_at']=$Myads->created_at;
        }

        //
        if($Myads->adstype_id==3)
        {
            $data['id']=$Myads->id;
            $data['agency_name']=$Myads->agency_name;
            $data['ads_type']=$Myads->ads_type;
            $data['appearance_order']=$Myads->appearance_order;
            $data['duration']=$Myads->duration;
            $data['expire_at']=$Myads->expire_at;
            $data['ads_price']=$Myads->ads_price . 'KSA';
            $data['status']=$Myads->status;
            $data['expired_at']=$Myads->expire_at;
            $data['created_at']=$Myads->created_at;
        }
 

        //

        if($data)      
        {
        return $this->apiResponse($data,'ok',200);
        }
        else
        {
        return $this->apiResponse("",'No Data Found',404);
        }
    }
}
