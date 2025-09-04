<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{

    protected $table = 'urls';
    public $timestamps = true;
    protected $fillable = array('name', 'url', 'icon');

}
