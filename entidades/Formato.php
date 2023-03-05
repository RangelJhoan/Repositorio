<?php

class Formato{
    private $idFormato;
    private $descripcion;

    public function getIdFormato(){
        return $this->idFormato;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setIdFormato($idFormato){
        $this->idFormato = $idFormato;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

}

?>