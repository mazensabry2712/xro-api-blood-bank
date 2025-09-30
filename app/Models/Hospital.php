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
        'email_otp',
        'email_otp_expires_at',
    ];

    protected $hidden = ['password'];

    // 'type' is an enum column in the database — keep only address translatable
    public $translatable = ['address'];

    /**
     * Ensure 'type' is always stored as a plain string in the enum column.
     * Accepts: plain string, JSON string, or array/object like ['en' => 'governmental']
     */
    public function setTypeAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['type'] = $value['en'] ?? array_values($value)[0] ?? null;
            return;
        }

        if (is_string($value)) {
            $trim = trim($value);
            if ((str_starts_with($trim, '{') || str_starts_with($trim, '[')) && $decoded = json_decode($trim, true)) {
                $this->attributes['type'] = is_array($decoded) ? ($decoded['en'] ?? array_values($decoded)[0] ?? null) : $decoded;
                return;
            }
        }

        $this->attributes['type'] = $value;
    }

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
