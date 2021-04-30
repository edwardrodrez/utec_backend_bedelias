<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tiposdecurso extends Model
{
    protected $primaryKey = 'idtiposDeCurso';
    protected $table = 'tiposdecurso';
    public $timestamps = false;

    public function cursos()
    {
        return $this->hasMany('App\Models\curso', 'idtiposDeCurso', 'idtiposDeCurso');
    }
}
