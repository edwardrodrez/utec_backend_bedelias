<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class direccion extends Model
{
    protected $primaryKey = 'iddireccion';
    protected $table = 'direccion';
    public $timestamps = false;
    protected $fillable = ['departamento', 'ciudad', 'calle'];
}
