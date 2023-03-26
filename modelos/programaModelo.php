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
            $sql = mainModel::conectar()->prepare("INSERT INTO programa(nombre, descripcion, estado) VALUES(?, ?, ?);");
            $sql->execute([$programa->getNombre(), $programa->getDescripcion(), $programa->getEstado()]);

            return $sql;
        }

        /*---------- Modelo para eliminar programa ----------*/
        protected static function eliminar_programa_modelo($idPrograma){
            $sqlEliminarPrograma = mainModel::conectar()->prepare("DELETE FROM programa WHERE id = ?");
            $sqlEliminarPrograma->execute([$idPrograma]);

            return $sqlEliminarPrograma;
        }

        /*---------- Modelo editar programa usuario ----------*/
        protected static function editar_estado_programa_modelo(Programa $programa){
            try {
                $sql = mainModel::conectar()->prepare("UPDATE programa SET estado = ? WHERE id = ?");
                $sql->execute([$programa->getEstado(), $programa->getIdPrograma()]);

                return $sql->rowCount();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo datos programa ----------*/
        protected static function datos_programa_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * 
                FROM programa 
                WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") ." AND id = :ID;");
                $sql->bindParam(":ID", $id);
            }elseif($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id
                FROM programa
                WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") .";");
            }
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo editar programa ----------*/
        protected static function editar_programa_modelo(Programa $programa){
            $sql = mainModel::conectar()->prepare("UPDATE programa SET nombre=?, descripcion=?, estado=? WHERE id=?");

            $sql->execute([$programa->getNombre(), $programa->getDescripcion(), $programa->getEstado(), $programa->getIdPrograma()]);

            return $sql;
        }

    }

?>