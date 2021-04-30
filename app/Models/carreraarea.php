<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carreraarea extends Model
{
    protected $primaryKey = 'idcarreraarea';
    protected $table = 'carreraarea';
    public $timestamps = false;
    protected $with = ['carrera'];

    public function carrera()
    {
        return $this->belongsTo('App\Models\carrera', 'idcarrera');
    }
}
