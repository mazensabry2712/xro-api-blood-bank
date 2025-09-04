<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Governorate extends Model
{
    use HasTranslations;

    protected $table = 'governorates';
    public $timestamps = true;

    protected $fillable = ['name', 'code'];

    // الحقول المترجمة
    public $translatable = ['name'];

    /** Relations */
    public function cities()
    {
        return $this->hasMany(\App\Models\City::class, 'governorate_id');
    }
}
