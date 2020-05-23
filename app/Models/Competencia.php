<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    protected $table = 'competencias';
    public $primaryKey = 'id_competencias';
    public $incrementing = false;
    // public $keyType = 'int';
    public $timestamps = false;
}
