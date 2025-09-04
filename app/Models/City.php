<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class City extends Model
{
    use HasTranslations;

    protected $table = 'cities';
    public $timestamps = true;

    protected $fillable = ['name', 'governorate_id'];

    // الحقول المترجمة
    public $translatable = ['name'];

    /** Relations */
    public function governorate()
    {
        return $this->belongsTo(\App\Models\Governorate::class, 'governorate_id');
    }

    public function regions()
    {
        return $this->hasMany(\App\Models\Region::class, 'city_id');
    }

    // لو حابب تجيب المستشفيات اللي في المدينة كلها
    public function hospitals()
    {
        return $this->hasManyThrough(
            Hospital::class,
            Region::class,
            'city_id',    // Foreign key on regions table...
            'region_id',  // Foreign key on hospitals table...
            'id',         // Local key on cities table...
            'id'          // Local key on regions table...
        );
    }
}
