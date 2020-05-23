<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurs extends Model
{
    protected $table = 'recursos';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $with = ['tipus_recurs', 'usuari'];

    public function tipusIncident() {
        return $this->hasMany('App\Models\tipusIncident', 'id', 'tipus_recurs_id');
    }

    public function incidenciahasincidencias() {
        return $this->belongsToMany('App\Models\incidencias', 'incidencies_has_recursos', 'incidencies_id', 'recursos_id');
    }

    public function tipus_recurs() {
        return $this->belongsTo('App\Models\tipusRecurs');
    }

    public function usuari() {
        return $this->hasOne('App\Models\Usuario', 'id', 'id_usuario');
    }
}
