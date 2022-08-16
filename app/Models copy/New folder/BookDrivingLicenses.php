<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDrivingLicenses extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='bookinternational_drivinglicenses';
}
