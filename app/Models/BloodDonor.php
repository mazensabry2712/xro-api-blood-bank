<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodDonor extends Model
{

    protected $table = 'bloods_donor';
    public $timestamps = true;
    protected $fillable = array('blood_type_id');

    public function bloodType()
    {
        return $this->belongsTo('App/Models\BloodType', 'blood_type_id');
    }

}
