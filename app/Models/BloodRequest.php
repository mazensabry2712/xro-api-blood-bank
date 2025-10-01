<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{

    protected $table = 'blood_requests';
    public $timestamps = true;
    protected $fillable = array('blood_type_id', 'number_bags', 'hospital_id', 'longitude', 'latitude', 'status','type_status');

    public function bloodType()
    {
        return $this->belongsTo('App\Models\BloodType', 'blood_type_id');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Models\Hospital', 'hospital_id');
    }
}
