<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
   
  
    protected $fillable = [
        'name',
        'phone',
        'password',
        'verified_at',
        'photo',
    ];
    public function otpcodes()
    {
        return $this->hasMany('App\Models\User_verfication','user_id');
    }
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

   
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    
    public function getJWTCustomClaims() {
        return [];
    }    

    public function Tripagents()
    {
      return $this->belongsToMany('App\Models\Tripagent','faviourt_tripagents','User_id','TripAgent_id');
    }

    public function DeviceTokens()
    {
        return $this->hasMany('App\Models\DeviceToken');
    }

    public function Notifications()
    {
        return $this->belongsToMany('App\Models\UserNotification','user_notifications');
    }
    
}
