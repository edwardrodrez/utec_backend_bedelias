<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clase extends Model
{
    protected $primaryKey = 'idclase';
    protected $table = 'clase';
    public $timestamps = false;
    protected $with = ['asistencias'];

    public function asistencias()
    {
        return $this->hasMany('App\Models\asistencia', 'idclase', 'idclase');
    }

}
