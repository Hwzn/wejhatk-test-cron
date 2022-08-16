<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopupSliderPhoto extends Model
{
    use HasFactory;
    protected $table='popupsliderphotos';
    protected $guarded=['id'];
}
