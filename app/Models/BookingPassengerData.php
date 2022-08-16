<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPassengerData extends Model
{
    use HasFactory;
    protected $table='booking_passengerdata';
    protected $guarded=['id'];

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking','booking_id');
    }
}
