<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class curso extends Model
{
    protected $primaryKey = 'idcurso';
    protected $table = 'curso';
    public $timestamps = false;
    protected $with = ['tipoDeCurso'];

    public function periodos()
    {
        return $this->hasMany('App\Models\periodo', 'idcurso', 'idcurso');
    }

    public function areaDeEstudio()
    {
        return $this->belongsTo('App\Models\areaDeEstudio', 'idareadeestudio');
    }

    public function tipoDeCurso()
    {
        return $this->belongsTo('App\Models\tiposdecurso', 'idtiposDeCurso');
    }

    public function previas()
    {
        return $this->hasMany('App\Models\previa', 'idcurso', 'idcurso');
    }

    public function carreras()
    {
        return $this->belongsToMany('App\Models\carrera', 'carrera_curso', 'idcurso', 'idcarrera');
    }


}
