<?php 
    require_once "mainModel.php";

    class homeModelo extends mainModel{

        protected static function filtrar_recursos($pTipo, $pBuscar){
            $pBuscar = str_replace("-"," ",$pBuscar);
            if($pTipo == "Busqueda"){
                $sql = mainModel::conectar()->prepare("SELECT r.titulo,r.fecha_publicacion_recurso,a.nombre,a.apellido FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor 
                WHERE r.titulo LIKE '%".$pBuscar."%' OR a.nombre LIKE '%".$pBuscar."%' OR a.apellido LIKE '%".$pBuscar."%';");    
            }else if($pTipo=="Autor"){
                $sql = mainModel::conectar()->prepare("SELECT r.titulo,r.fecha_publicacion_recurso,a.nombre,a.apellido FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor ORDER BY a.nombre");
            }else if($pTipo=="Titulo"){
                $sql = mainModel::conectar()->prepare("SELECT r.titulo,r.fecha_publicacion_recurso,a.nombre,a.apellido FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor ORDER BY r.titulo");
            }else if($pTipo=="Fecha"){
                $sql = mainModel::conectar()->prepare("SELECT r.titulo,r.fecha_publicacion_recurso,a.nombre,a.apellido FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor ORDER BY r.fecha_publicacion_recurso");
            }else if($pTipo=="Curso"){
                $sql = mainModel::conectar()->prepare("SELECT r.titulo,r.fecha_publicacion_recurso,a.nombre,a.apellido FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor ORDER BY a.nombre");
            }
            $sql->execute();

            return $sql;
        }
    }
?>