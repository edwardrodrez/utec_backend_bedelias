<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inscripcion extends Model
{
    protected $primaryKey = 'idInscripcion';
    protected $table = 'inscripcion';
    public $timestamps = false;
    protected $with = ['persona'];

    public function persona()
    {
        return $this->belongsTo('App\Models\persona', 'idpersona');
    }

    public function periododeincripcione()
    {
        return $this->belongsTo('App\Models\periododeincripciones', 'idperiododeincripciones');
    }
}
