<?php

namespace App\Http\Controllers\Api\Tripagent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use App\Models\Ads;

class AdsController extends Controller
{
    use ApiResponseTrait;

    public function ads_types($lang)
    {
        $lang=strtolower($lang);
        $data['ads']=Ads::select('ads.id',"ads.name->$lang as ads_name",'price',"description->$lang as desc","currencies.short_name->$lang as currency")
                    ->join('currencies','currencies.id','=','ads.currency_id')
                   ->get();
       $ads_types=array();
         foreach($data['ads'] as $ads)
        {
            $array['id']=$ads->id;
            $array['name']=$ads-> ads_name;
            $array['price']=$ads->price .' ' .$ads->currency;
            $array['desc']=$ads->desc;
            array_push($ads_types,$array);
        }
        if($ads_types)      
        {
        return $this->apiResponse($ads_types,'ok',200);
        }
        else
        {
        return $this->apiResponse("",'No Data Found',404);
        }
    }

}
