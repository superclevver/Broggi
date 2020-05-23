<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comarca extends Model
{
    //

    protected $table = 'comarques';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;


    public function provincies()
    {
        return $this->hasMany('App\Models\Provincia', 'id', 'provincies_id');
    }
    public function municipi()
    {
        return $this->belongsTo('App\Models\Municipi');
    }
}
