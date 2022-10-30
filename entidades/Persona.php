<?php

require_once "Usuario.php";

class Persona extends Usuario{
    private $idPersona;
    private $tipoDocumento;
    private $documento;
    private $nombre;
    private $apellido;

    public function __construct(){}

    //Getters
    public function getIdPersona(){
        return $this->idPersona;
    }

    public function getTipoDocumento(){
        return $this->tipoDocumento;
    }

    public function getDocumento(){
        return $this->documento;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getApellido(){
        return $this->apellido;
    }

    //Setters
    public function setIdPersona($idPersona){
        $this->idPersona = $idPersona;
    }

    public function setTipoDocumento($tipoDocumento){
        $this->tipoDocumento = $tipoDocumento;
    }

    public function setDocumento($documento){
        $this->documento = $documento;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setApellido($apellido){
        $this->apellido = $apellido;
    }
}

?>