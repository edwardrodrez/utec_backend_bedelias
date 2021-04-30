<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class acta extends Model
{
    protected $primaryKey = 'idacta';
    protected $table = 'acta';
    public $timestamps = false;
    protected $with = ['usuario'];

    public function usuario()
    {
    return $this->belongsTo('App\Models\usuario', 'idusuario');
    }

    public function periodo()
    {
        return $this->belongsTo('App\Models\periodo', 'idperiodo');
    }



}
