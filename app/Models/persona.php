<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class persona extends Model
{
    protected $primaryKey = 'ci';
    protected $table = 'persona';
    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $with = ['direccion'];
    protected $fillable = ['ci','nombre','apellido','correo','telefono','fechaDeNacimiento','sexo',];

    public function direccion()
    {
        return $this->hasOne('App\Models\direccion', 'ci');
    }

    public function inscripcion()
    {
        return $this->hasMany('App\inscripcion','idpersona','ci');
    }


}
