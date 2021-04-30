<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sede extends Model
{
    protected $primaryKey = 'idsede';
    protected $table = 'sede';
    public $timestamps = false;
    protected $fillable = ['nombre'];
    protected $with = ['direccion','carreras'];

    public function direccion()
    {
        return $this->hasOne('App\Models\direccion', 'idsede');
    }

    public function carreras()
    {
        return $this->belongsToMany('App\Models\carrera', 'sede_carrera', 'idsede', 'idcarrera');
    }

    public function periodos()
    {
        return $this->hasMany('App\Models\periodo', 'idcurso', 'idcurso');
    }

}
