<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Package extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $hidden=['pivot'];

    use HasTranslations;
    public $translatable = ['package_desc','package_contain'
    ,'conditions','cancel_conditions','package_notinclude','ReturnPloicy'];

    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency','currency_id');
    }

    public function Tripagents()
    {
      return $this->belongsToMany('App\Models\Tripagent','tripagent_package','package_id','tripagent_id');
    }

    public function ReturnPloicy()
    {
        return $this->belongsTo('App\Models\RetrunPloicy','ReturnPloicy_id');
    }
}
