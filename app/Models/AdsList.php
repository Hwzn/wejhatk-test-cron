<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class AdsList extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $table='ads_lists';
    protected $guarded=['id'];
    public $translatable = ['duration'];

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency','currency_id');
    }
}
