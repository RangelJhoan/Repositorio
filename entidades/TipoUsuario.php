<?php

class TipoUsuario{
    private $idTipoUsuario;
    private $descripcion;

    public function __construct(){}

    public function getIdTipoUsuario(){
        return $this->idTipoUsuario;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setIdTipoUsuario($idTipoUsuario){
        $this->idTipoUsuario = $idTipoUsuario;
    }

    public function setDescripcion($descripcion){
        $this->$descripcion = $descripcion;
    }

}

?>