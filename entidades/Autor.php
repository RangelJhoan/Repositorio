<?php

class Autor {
    private $idAutor;
    private $nombre;
    private $apellido;
    private $estado;
    private $idDocente;

    public function __construct(){}

    //Getters
    public function getIdAutor(){
        return $this->idAutor;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function getIdDocente(){
        return $this->idDocente;
    }


    //Setters
    public function setIdAutor($idAutor){
        $this->idAutor = $idAutor;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function setIdDocente($idDocente){
        $this->idDocente = $idDocente;
    }
}

?>