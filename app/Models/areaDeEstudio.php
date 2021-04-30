<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class areaDeEstudio extends Model
{
    protected $primaryKey = 'idareadeestudio';
    protected $table = 'areadeestudio';
    public $timestamps = false;
    protected $with = ['cursos','carreraArea'];

    public function cursos()
    {
        return $this->hasMany('App\Models\curso', 'idareadeestudio', 'idareadeestudio');
    }

    public function carreraArea()
    {
        return $this->hasMany('App\Models\carreraarea', 'idareadeestudio', 'idareadeestudio');
    }

}
