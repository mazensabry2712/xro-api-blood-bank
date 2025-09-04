<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{

    protected $table = 'blood_types';
    public $timestamps = true;
    protected $fillable = array('name');

    public function bloodRequests()
    {
        return $this->hasMany('App/Models\BloodRequest');
    }

    public function bloodDonors()
    {
        return $this->hasMany('App/Models\BloodDonor');
    }

}
