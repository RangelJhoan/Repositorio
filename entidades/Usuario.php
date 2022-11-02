<?php

require_once "TipoUsuario.php";

class Usuario extends TipoUsuario{

    private $idUsuario;
    private $correo;
    private $clave;
    private $estado;

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

    public function getEstado(){
        return $this->estado;
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

    public function setEstado($estado){
        $this->estado = $estado;
    }

}

?>