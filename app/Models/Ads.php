<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Ads extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    use HasTranslations;
    public $translatable = ['name','description'];

    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency','currency_id');
    }
}
