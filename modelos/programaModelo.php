<?php

    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
        require_once "../entidades/Programa.php";
    }else{
        //Modelo llamado desde la vista Index
        require_once "./entidades/Programa.php";
    }

    class programaModelo extends mainModel{

        /*---------- Modelo para agregar programa ----------*/
        protected static function agregar_programa_modelo(Programa $programa){
            $sql = mainModel::conectar()->prepare("INSERT INTO programa(nombre, descripcion) VALUES(?, ?);");
            $sql->execute([$programa->getNombre(), $programa->getDescripcion()]);

            return $sql;
        }

    }

?>