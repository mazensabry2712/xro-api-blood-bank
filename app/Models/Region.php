<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Region extends Model
{
    use HasTranslations;

    protected $table = 'regions';
    public $timestamps = true;

    protected $fillable = ['name', 'address', 'city_id'];

    public $translatable = ['name', 'address'];

    /** Relations */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function hospitals()
    {
        return $this->hasMany(Hospital::class, 'region_id');
    }
}
