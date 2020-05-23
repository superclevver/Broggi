<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipusIncident extends Model
{
    //

    protected $table = 'tipus_incident';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function incidencias()
    {
        return $this->belongsTo('App\Models\incidencias');
    }
}
