<?php

    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
        require_once "../entidades/Curso.php";
    }else{
        //Modelo llamado desde la vista Index
        require_once "./entidades/Curso.php";
    }

    class cursoModelo extends mainModel{

        /*---------- Modelo para agregar programa ----------*/
        protected static function agregar_curso_modelo(Curso $curso){
            $sql = mainModel::conectar()->prepare("INSERT INTO curso(nombre, descripcion) VALUES(?, ?);");
            $sql->execute([$curso->getNombre(), $curso->getDescripcion()]);
            $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM curso WHERE nombre = ?;");
            $sqlQuery->execute([$curso->getNombre()]);
            $row = $sqlQuery->fetch();
            $idCurso = $row['id'];

            if($sql->rowCount() == 1){
                foreach($curso->getListaProgramas() as $programaID){
                    $sql = mainModel::conectar()->prepare("INSERT INTO curso_programa(id_curso, id_programa) VALUES(?, ?)");
                    $sql->execute([$idCurso, $programaID]);
                }
                return $sql;
            }
            return $sql;
        }

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