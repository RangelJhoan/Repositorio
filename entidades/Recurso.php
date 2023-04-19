<?php

class Recurso {
    private $idRecurso;
    private $internalID;
    private $titulo;
    private $autor;
    private $etiqueta;
    private $curso;
    private $resumen;
    private $fecha;
    private $enlace;
    private $isbn;
    private $editorial;
    private $archivo;
    private $estado;

    public function __construct(){}

    //Getters

    public function getIdRecurso(){
        return $this->idRecurso;
    }

    public function getInternalID(){
        return $this->internalID;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function getAutor(){
        return $this->autor;
    }

    public function getEtiqueta(){
        return $this->etiqueta;
    }

    public function getCurso(){
        return $this->curso;
    }

    public function getResumen(){
        return $this->resumen;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function getEnlace(){
        return $this->enlace;
    }

    public function getArchivo(){
        return $this->archivo;
    }

    public function getEstado(){
        return $this->estado;
    }

    //Setters
    public function setIdRecurso($idRecurso){
        $this->idRecurso = $idRecurso;
    }
    
    public function setInternalID($internalID){
        $this->internalID = $internalID;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    public function setAutor($autor){
        $this->autor = $autor;
    }

    public function setEtiqueta($etiqueta){
        $this->etiqueta = $etiqueta;
    }

    public function setCurso($curso){
        $this->curso = $curso;
    }

    public function setResumen($resumen){
        $this->resumen = $resumen;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function setEnlace($enlace){
        $this->enlace = $enlace;
    }

    public function setArchivo($archivo){
        $this->archivo = $archivo;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getISBN(){
        return $this->isbn;
    }

    public function setISBN($isbn){
        $this->isbn = $isbn;
    }

    public function getEditorial(){
        return $this->editorial;
    }

    public function setEditorial($editorial){
        $this->editorial = $editorial;
    }
}

?>