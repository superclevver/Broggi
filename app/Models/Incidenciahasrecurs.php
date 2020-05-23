<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class incidenciahasrecurs extends Model
{
    //

    protected $table = 'incidencies_has_recursos';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function Recurs()
    {
        return $this->belongsTo('App\Models\Recurs', 'recursos_id');
    }
}
