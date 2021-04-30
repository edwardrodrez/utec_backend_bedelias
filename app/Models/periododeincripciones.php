<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class periododeincripciones extends Model
{
    protected $primaryKey = 'idperiododeincripciones';
    protected $table = 'periododeincripciones';
    public $timestamps = false;
    protected $with = ['carrera','inscripciones'];


    public function carrera()
    {
        return $this->belongsTo('App\Models\carrera', 'idcarrera');
    }

    public function inscripciones()
    {
        return $this->hasMany('App\Models\inscripcion', 'idperiododeincripciones', 'idperiododeincripciones');
    }

}
