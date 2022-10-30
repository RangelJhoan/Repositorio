<?php

require_once "TipoUsuario.php";

class Usuario extends TipoUsuario{

    private $idUsuario;
    private $correo;
    private $clave;

    public function __construct(){}

    //Getters
    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function getCorreo(){
        return $this->correo;
    }

    public function getClave(){
        return $this->clave;
    }

    //Setters
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function setCorreo($correo){
        $this->correo = $correo;
    }

    public function setClave($clave){
        $this->clave = $clave;
    }

}

?>