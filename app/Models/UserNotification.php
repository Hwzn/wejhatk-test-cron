<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Translatable\HasTranslations;

class UserNotification extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    // public $translatable = ['body'];

    // public function asJson($value)
    // {
    //     return json_encode($value,JSON_UNESCAPED_UNICODE);
    // }
    protected $table='user_notifications';
    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
}
