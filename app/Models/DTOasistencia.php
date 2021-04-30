<?php

namespace App\Models;

class DTOasistencia
{
    public $idasistencia;
    public $nombre;
    public $apellido;
    public $asistio;
    public $inasistencias;
    public $porsentaje;

    public function DTOasistencia($nombre,$apellido,$asistio,$inasistencias,$porsentaje)
    {
        $this->nombre = $nombre;
        $this->apellido =$apellido;
        $this->asistio =$asistio;
        $this->inasistencias =$inasistencias;
        $this->porsentaje =$porsentaje;
    }

}
