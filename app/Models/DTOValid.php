<?php

namespace App\Models;

class DTOValid
{
    public $res;
    public $mensaje;

    public function DTOValid($res,$mensaje)
    {
        $this->res = $res;
        $this->mensaje =$mensaje;
    }
    /**
     * Get the value of res
     */
    public function getRes()
    {
        return $this->res;
    }

    /**
     * Set the value of res
     *
     * @return  self
     */
    public function setRes($res)
    {
        $this->res = $res;

        return $this;
    }

    /**
     * Get the value of mensaje
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set the value of mensaje
     *
     * @return  self
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;

        return $this;
    }
}
