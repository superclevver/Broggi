<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstatIncidencia extends Model
{
    //

    protected $table = 'estats_incidencia';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function incidencias()
    {
        return $this->belongsTo('App\Models\incidencias');
    }
}
