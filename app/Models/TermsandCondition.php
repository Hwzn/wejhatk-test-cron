<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TermsandCondition extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='terms_conditions';

    use HasTranslations;
    public $translatable = ['desc'];

    public function asJson($value)
    {
        return json_encode($value,JSON_UNESCAPED_UNICODE);
    }

}
