<?php

class Programa {
    private $idPrograma;
    private $nombre;
    private $descripcion;
    private $estado;

    public function __construct(){}

    //Getters
    public function getIdPrograma(){
        return $this->idPrograma;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function getEstado(){
        return $this->estado;
    }

    //Setters
    public function setIdPrograma($idPrograma){
        $this->idPrograma = $idPrograma;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }
}

?>