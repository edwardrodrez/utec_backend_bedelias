<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class periodo extends Model
{
    protected $primaryKey = 'idperiodo';
    protected $table = 'periodo';
    public $timestamps = false;
    protected $with = ['curso','sede','actas','fechainscripcion','docente'];

    public function docente()
    {
        return $this->belongsTo('App\Models\usuario', 'idusuario');
    }

    public function Estudiantes()
    {
        return $this->belongsToMany('App\Models\usuario', 'usuario_periodo', 'idperiodo', 'idusuario');
    }

    public function actas()
    {
        return $this->hasMany('App\Models\acta', 'idperiodo', 'idperiodo');
    }

    public function fechainscripcion()
    {
        return $this->hasOne('App\Models\fechainscripcion', 'idperiodo');
    }

    public function clases()
    {
        return $this->hasMany('App\Models\clase', 'idperiodo', 'idperiodo');
    }

    public function curso()
    {
        return $this->belongsTo('App\Models\curso', 'idcurso');
    }

    public function sede()
    {
        return $this->belongsTo('App\Models\sede', 'idsede');
    }

}
