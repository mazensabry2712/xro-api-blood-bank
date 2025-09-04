<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{

    protected $table = 'heros';
    public $timestamps = true;
    protected $fillable = array('name', 'description');

}
