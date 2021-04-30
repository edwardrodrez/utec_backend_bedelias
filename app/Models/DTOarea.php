<?php

namespace App\Models;

class DTOarea
{
    public $nombre;
    public $creditosMinimos;
    public $creditosTiene;
    public $materias;

    public function DTOarea($nombre,$creditosMinimos,$creditosTiene,$materias)
    {
        $this->nombre = $nombre;
        $this->creditosMinimos = $creditosMinimos;
        $this->creditosTiene = $creditosTiene;
        $this->materias = $materias;
    }


}
