<?php

class Curso {
    private $idCurso;
    private $nombre;
    private $descripcion;
    private $estado;
    private $listaProgramas;

    public function __construct(){}

    //Getters
    public function getIdCurso(){
        return $this->idCurso;
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

    public function getListaProgramas(){
        return $this->listaProgramas;
    }

    //Setters
    public function setIdCurso($idCurso){
        $this->idCurso = $idCurso;
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

    public function setListaProgramas($listaProgramas){
        $this->listaProgramas = $listaProgramas;
    }
}

?>