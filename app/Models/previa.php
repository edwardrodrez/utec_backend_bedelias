<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class previa extends Model
{
    protected $primaryKey = 'idprevia';
    protected $table = 'previa';
    public $timestamps = false;
    protected $with = ['curso'];

    public function curso()
    {
        return $this->belongsTo('App\Models\curso', 'idcursoprevio');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Models\carrera', 'idcarrera');
    }
}
