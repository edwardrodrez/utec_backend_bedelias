<?php

namespace App\Models;

class DTOMaterias
{
    public $materia;
    public $tipo;
    public $fecha;
    public $nota;
    public $creditos;

    public function DTOMaterias($materia,$tipo,$fecha,$nota,$creditos)
    {
        $this->materia = $materia;
        $this->tipo =$tipo;
        $this->fecha =$fecha;
        $this->nota =$nota;
        $this->creditos =$creditos;
    }

}
