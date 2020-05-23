<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rols extends Model
{
    protected $table = 'rols';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function Usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }
}
