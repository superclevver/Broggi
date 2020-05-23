<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipi extends Model
{
    //

    protected $table = 'municipis';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function Comarques()
    {
        return $this->hasMany('App\Models\Comarca', 'id', 'comarques_id');
    }

    public function Afectats()
    {
        return $this->belongsTo('App\Models\Afectats');
    }
}
