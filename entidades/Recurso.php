<?php

class Recurso {
    private $idRecurso;
    private $titulo;
    private $autor;
    private $etiqueta;
    private $curso;
    private $resumen;
    private $fecha;
    private $editorial;
    private $isbn;
    private $enlace;
    private $archivo;


    public function __construct(){}

    //Getters

    public function getIdRecurso(){
        return $this->idRecurso;
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

    public function getEditorial(){
        return $this->editorial;
    }

    public function getIsbn(){
        return $this->isbn;
    }

    public function getArchivo(){
        return $this->archivo;
    }

    public function getEnlace(){
        return $this->enlace;
    }

    //Setters
    public function setIdRecurso($idRecurso){
        $this->idRecurso = $idRecurso;
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

    public function setEditorial($editorial){
        $this->editorial = $editorial;
    }

    public function setIsbn($isbn){
        $this->isbn = $isbn;
    }

    public function setArchivo($archivo){
        $this->archivo = $archivo;
    }

    public function setEnlace($enlace){
        $this->enlace = $enlace;
    }
}

?>