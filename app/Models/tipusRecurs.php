<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipusRecurs extends Model
{
    protected $table = 'tipus_recurs';
    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function Recurs()
    {
        return $this->belongsTo('App\Models\Recurs');
    }
}
