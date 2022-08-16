<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TourGuide extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use HasTranslations;
    protected $table='tour_guides';
    protected $fillable = [
      'name',
      'phone',
      'password',
      'verified_at',
      'photo',
      'profile_photo',
      'address',
      'desc',
      'tripagent_id',
      'commercial_registrationNo',
      'commercialregistration_expiryDate',
      'license_number',
      'license_expiry_date',
      'countries',
      'status',
      'starnumber',

  ];


    public function getJWTIdentifier() {
        return $this->getKey();
    }
  
    
    public function getJWTCustomClaims() {
        return [];
    }    
    
    public $translatable = ['desc'];
    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    // public function Agency()
    // {
    //   return $this->belongsTo('App\Models\AgencyType','agency_id');
    // }

    public function DeviceTokens()
    {
        return $this->hasMany('App\Models\DeviceToken','tourguide_id','id');
    }

    public function trip_agent()
    {
        return $this->belongsTo('App\Models\Tripagent','tripagent_id');
    }

}
