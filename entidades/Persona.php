<?php

require_once "Usuario.php";
require_once "TipoDocumento.php";

class Persona extends Usuario{
    private $idPersona;
    private $documento;
    private $nombre;
    private $apellido;
    private $estadoPersona;
    private TipoDocumento $tipoDocumento;

    public function __construct(){}

    //Getters
    public function getIdPersona(){
        return $this->idPersona;
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

    public function getEstadoPersona(){
        return $this->estadoPersona;
    }

    public function getTipoDocumento(){
        return $this->tipoDocumento;
    }

    //Setters
    public function setIdPersona($idPersona){
        $this->idPersona = $idPersona;
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

    public function setEstadoPersona($estadoPersona){
        $this->estadoPersona = $estadoPersona;
    }

    public function setTipoDocumento($tipoDocumento){
        $this->tipoDocumento = $tipoDocumento;
    }
}

?>