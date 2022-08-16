<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPackageDetails extends Model
{
    use HasFactory;
    protected $table='booking_packagedetails';
    protected $guarded=['id'];
}
