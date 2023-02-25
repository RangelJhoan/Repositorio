<?php

class Etiqueta{
    private $idEtiqueta;
    private $descripcion;
    private $estado;

    public function getIdEtiqueta(){
        return $this->idEtiqueta;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setIdEtiqueta($idEtiqueta){
        $this->idEtiqueta = $idEtiqueta;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

}

?>