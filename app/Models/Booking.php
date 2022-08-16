<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Booking extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    protected $table='bookings';
    // public function asJson($value)
    // {
    //     return json_encode($value,JSON_UNESCAPED_UNICODE);
    // }
    public function user()
    {
        return $this->belongsTo('App\Models\User','User_id');
    }

    public function Tripagent()
    {
        return $this->belongsTo('App\Models\Tripagent','Tripagent_id');
    }

   
}
