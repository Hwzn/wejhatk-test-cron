<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsRequests extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='ads_requests';
}
