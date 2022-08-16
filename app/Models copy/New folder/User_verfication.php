<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_verfication extends Model
{
    use HasFactory;
    public $table='users_verficationcode';
    protected $fillable=['user_id','otpcode'];

}
