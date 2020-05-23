<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class incidencias extends Model
{
    //

    protected $table = 'incidencies';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    protected $dates = ['created_at'];


    public function Afectats()
    {
        return $this->belongsToMany('App\Models\Afectats', 'incidencies_has_afectats', 'incidencies_id', 'afectats_id');
    }

    public function Alertants()
    {

        return $this->belongsTo('App\Models\Alertant');
    }
    public function getYourDateFieldAttribute($value)
    {
        return $value->format('Y-m-d H:i');
    }

    public function incidenciahasrecursos()
    {
        return $this->belongsToMany('App\Models\Recurs', 'incidencies_has_recursos', 'incidencies_id', 'recursos_id')
        ->withPivot('prioritat');
    }
    public function incidenciaspruebaderecursos()
    {
        return $this->belongsTo('App\Models\incidenciahasrecurs','id','incidencies_id');

    }
    public function Usuario()
    {
        return $this->belongsToMany('App\Models\Usuario', 'incidencies_has_usuaris', 'incidencies_id', 'usuaris_id');
    }


    public function tipusAlertant()
    {
        return $this->hasMany('App\Models\tipusAlertant', 'id', 'tipus_alertant_id');
    }
    public function tipusIncident()
    {
        return $this->hasMany('App\Models\tipusIncident', 'id', 'tipus_incident_id');
    }

    public function EstatIncidencia()
    {
        return $this->hasMany('App\Models\EstatIncidencia', 'id', 'estats_incidencia_id');
    }
    public function Municipi()
    {
        return $this->hasMany('App\Models\Municipi', 'id', 'municipis_id');
    }

}