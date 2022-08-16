<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourguide_verfication extends Model
{
    use HasFactory;
    public $table='tourguide_verfications';
    protected $fillable=['user_id','otpcode','expired_at'];
}
