<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alertant extends Model
{
    protected $table = 'alertants';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $with = ['municipi', 'tipusAlertant'];

    public function municipi()
    {
        return $this->belongsTo('App\Models\Municipi', 'municipis_id');
    }

    public function tipusAlertant()
    {
        return $this->hasOne('App\Models\tipusAlertant', 'id', 'tipus_alertant_id');
    }

    public function incidencias()
    {
        return $this->belongsTo('App\Models\incidencias');
    }
}
