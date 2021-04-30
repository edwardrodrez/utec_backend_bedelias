<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class roles extends Model
{
    protected $primaryKey = 'idroles';
    protected $table = 'roles';
    public $timestamps = false;
    protected $fillable = ['nombre'];

}
