<?php

    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
        require_once "../entidades/Autor.php";
    }else{
        //Modelo llamado desde la vista Index
        require_once "./entidades/Autor.php";
    }

    class autorModelo extends mainModel{

        /**
         * Agrega registro de autor en la base de datos
         * 
         * @param Autor Entidad que contiene la información del autor
         * 
         * @return int Cantidad de filas afectadas en la sentencia insert
         * @throws string Mensaje de error capturado en el try catch
         * 
         */
        protected static function agregar_autor_modelo(Autor $autor){
            try {

                $sql = mainModel::conectar()->prepare("INSERT INTO autor(nombre, apellido, estado) VALUES(?, ?, ?);");
                $sql->execute([$autor->getNombre(), $autor->getApellido(), $autor->getEstado()]);

                return $sql->rowCount();

            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo para eliminar autor ----------*/
        protected static function eliminar_autor_modelo(Autor $autor){
            try {
                $sql = mainModel::conectar()->prepare("UPDATE autor SET estado=? WHERE id=?");
                $sql->execute([$autor->getEstado(), $autor->getIdAutor()]);
                return $sql->rowCount();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo para editar información de autor ----------*/
        protected static function editar_autor_modelo(Autor $autor){
            try {
                $sql = mainModel::conectar()->prepare("UPDATE autor SET nombre=?, apellido=?, estado=? WHERE id=?");
                $sql->execute([$autor->getNombre(), $autor->getApellido(), $autor->getEstado(), $autor->getIdAutor()]);

                return $sql->rowCount();
            } catch (Exception $e) {
                return "Error " . $e->getMessage();
            }
        }

        /*---------- Modelo datos autor ----------*/
        protected static function datos_autor_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * 
                FROM autor 
                WHERE estado != ". 3 ." AND id = :ID;");
                $sql->bindParam(":ID", $id);
            }elseif($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id 
                FROM autor
                WHERE estado != ". 3 .";");
            }
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo autores por recurso ----------*/
        protected static function autoresXRecursoModelo($id){
            $sql = mainModel::conectar()->prepare("SELECT a.nombre, a.apellido 
            FROM autor a 
            JOIN autor_recurso ar ON a.id = ar.id_autor 
            JOIN recurso r ON r.id = ar.id_recurso 
            WHERE r.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

    }

?>