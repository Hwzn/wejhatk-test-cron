<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasFactory;

    protected $table='currencies';
    protected $guarded=['id'];
    use HasTranslations;
    public $translatable = ['name','short_name'];

    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }
}
