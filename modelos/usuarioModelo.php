<?php

    require_once "mainModel.php";

    class usuarioModelo extends mainModel{

        /*---------- Modelo para agregar usuario ----------*/
        protected static function agregar_usuario_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO persona(tipoDocumento, documento, nombre, apellido, idUsuario) VALUES(:tipoDocumento, :documento, :nombre, :apellido, :idUsuario)");

            $sql->bindParam(":tipoDocumento", $datos['tipoDocumento']);
            $sql->bindParam(":documento", $datos['documento']);
            $sql->bindParam(":nombre", $datos['nombre']);
            $sql->bindParam(":apellido", $datos['apellido']);
            $variableQuemada = 1;
            $sql->bindParam(":idUsuario", $variableQuemada);

            $sql->execute();

            return $sql;
        }

    }

?>