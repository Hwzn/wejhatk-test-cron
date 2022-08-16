<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SelectTypeEelements extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded=['id'];
    protected $table='selecttype_elements';

    public $translatable = ['name'];
    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

    public function selecttype_elements()
    {
        return $this->belongsTo('App\Models\SelectType','selecttype_id');
    }
}
