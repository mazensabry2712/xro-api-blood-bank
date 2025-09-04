<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Translatable\HasTranslations;

class Hospital extends Authenticatable
{
    use HasApiTokens, Notifiable, HasTranslations;

    protected $table = 'hospitals';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'license_number',
        'type',
        'address',
        'phone',
        'hotline',
        'email',
        'website',
        'longitude',
        'latitude',
        'region_id',
        'password',
    ];

    protected $hidden = ['password'];

    public $translatable = ['type', 'address'];

    /** Relations */
    public function region()
    {
        return $this->belongsTo(\App\Models\Region::class, 'region_id');
    }

    public function bloodRequests()
    {
        return $this->hasMany(\App\Models\BloodRequest::class, 'hospital_id');
    }
}
