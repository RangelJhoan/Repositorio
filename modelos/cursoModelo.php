<?php

    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
    }else{
        //Modelo llamado desde la vista Index
    }

    class cursoModelo extends mainModel{

        /*---------- Modelo datos curso ----------*/
        protected static function datos_curso_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * 
                FROM curso 
                WHERE id = :ID;");
                $sql->bindParam(":ID", $id);
            }elseif($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id 
                FROM curso;");
            }
            $sql->execute();
            return $sql;
        }

    }

?>