<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Afectats extends Model
{
    //

    protected $table = 'afectats';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;


    public function incidencias()
    {
        return $this->belongsToMany('App\Models\incidencias', 'incidencies_has_afectats', 'incidencies_id', 'afectats_id');
    }
    public function Municipi()
    {
        return $this->hasMany('App\Models\Municipi', 'id', 'municipis_id');
    }
}
