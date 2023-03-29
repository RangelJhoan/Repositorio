<?php

class Archivo{
    private $idArchivo;
    private $ruta;
    private $tamano;
    private $nombre;
    private $estado;


    public function getIdArchivo(){
        return $this->idArchivo;
    }

    public function setIdArchivo($idArchivo){
        $this->idArchivo = $idArchivo;
    }

    public function getRuta(){
        return $this->ruta;
    }

    public function setRuta($ruta){
        $this->ruta = $ruta;
    }

    public function getTamano(){
        return $this->tamano;
    }

    public function setTamano($tamano){
        $this->tamano = $tamano;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

}

?>