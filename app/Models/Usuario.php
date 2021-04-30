<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
    {

    use Authenticatable, Authorizable;

    protected $primaryKey = 'idusuario';
    protected $table = 'usuario';
    public $timestamps = false;
    protected $with = ['persona','roles'];
    protected $fillable = ['password','persona','nombre'];
    protected $hidden = ['password'];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function certificados()
    {
        return $this->hasMany('App\Models\certificado', 'idusuario', 'idusuario');
    }

    public function actas()
    {
        return $this->hasMany('App\Models\acta', 'idusuario', 'idusuario');
    }

    public function periodoDocente()
    {
        return $this->hasMany('App\Models\periodo', 'idusuario', 'idusuario');
    }

    public function periodoEstudiante()
    {
        return $this->belongsToMany('App\Models\periodo', 'usuario_periodo', 'idusuario', 'idperiodo');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\roles', 'usuario_roles', 'idusuario', 'idroles');
    }

    public function carrera()
    {
        return $this->belongsToMany('App\Models\carrera', 'usuario_carrera', 'idusuario', 'idcarrera');
    }

    public function persona()
    {
        return $this->hasOne('App\Models\persona', 'idusuario');
    }

}

