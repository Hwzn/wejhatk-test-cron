<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsListDetails extends Model
{
    use HasFactory;
    protected $table='adslist_details';
    protected $guarded=['id'];
}
