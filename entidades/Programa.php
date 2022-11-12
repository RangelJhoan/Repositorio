<?php

class Programa {
    private $idPrograma;
    private $nombre;
    private $descripcion;

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
}

?>