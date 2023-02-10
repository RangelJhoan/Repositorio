<?php

class TipoDocumento {

    private $idTipoDocumento;
    private $descripcion;

    public function __construct(){}

    //Getters
    public function getIdTipoDocumento(){
        return $this->idTipoDocumento;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    //Setters
    public function setIdTipoDocumento($idTipoDocumento){
        $this->idTipoDocumento = $idTipoDocumento;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

}

?>