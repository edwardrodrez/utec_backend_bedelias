<?php

namespace App\Models;

class DTOescolaridad
{
    public $nombre;
    public $apellido;
    public $cedula;
    public $añoDeIngreso;
    public $carrera;
    public $Promedio;
    public $creditosTotales;
    public $creditosDeCarrera;
    public $areas;

    public function DTOescolaridad($nombre,$apellido,$cedula,$añoDeIngreso,$carrera,$Promedio,$creditosTotales,$creditosDeCarrera,$areas)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->cedula =$cedula;
        $this->añoDeIngreso =$añoDeIngreso;
        $this->carrera =$carrera;
        $this->Promedio =$Promedio;
        $this->creditosTotales =$creditosTotales;
        $this->creditosDeCarrera =$creditosDeCarrera;
        $this->areas =$areas;
  
    }


    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }
}
