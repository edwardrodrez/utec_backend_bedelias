<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carrera extends Model
{
    protected $primaryKey = 'idcarrera';
    protected $table = 'carrera';
    public $timestamps = false;
    protected $with = ['cursos'];

    public function usuarios()
    {
        return $this->belongsToMany('App\Models\Usuario', 'usuario_carrera', 'idcarrera', 'idusuario');
    }

    public function sedes()
    {
        return $this->belongsToMany('App\Models\sede', 'sede_carrera', 'idcarrera', 'idsede');
    }

    public function cursos()
    {
        return $this->belongsToMany('App\Models\curso', 'carrera_curso', 'idcarrera', 'idcurso');
    }

    public function periodoDeIncripciones()
    {
        return $this->hasMany('App\Models\periododeincripciones', 'idcarrera', 'idcarrera');
    }



}
