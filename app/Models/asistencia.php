<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asistencia extends Model
{
    protected $primaryKey = 'idasistencia';
    protected $table = 'asistencia';
    public $timestamps = false;
    protected $with = ['usuario'];

    public function usuario()
    {
        return $this->belongsTo('App\Models\usuario', 'idusuario');
    }

}
