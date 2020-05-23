<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuaris';

    public $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $with = ['rol'];

    //public $fillable = 'nom';

    public function rol()
    {
        return $this->hasOne('App\Models\Rols', 'id', 'rols_id');
        // return $this->hasMany('App\Models\Rols', 'id', 'rols_id');
    }

    public function Incidencies()
    {
        return $this->belongsToMany('App\Models\incidencies', 'incidencies_has_usuaris', 'incidencies_id', 'usuaris_id');
    }

    public function recurso() {
        return $this->belongsTo('App\Models\Recurs');
    }
}
