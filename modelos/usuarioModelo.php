<?php

    require_once "mainModel.php";

    class usuarioModelo extends mainModel{

        /*---------- Modelo para agregar usuario ----------*/
        protected static function agregar_usuario_modelo($datos){
            $sql = mainModel::conectar()->prepare("INSERT INTO usuario(correo, clave, idTipoUsuario) VALUES(:correo, :clave, :idTipoUsuario)");

            $sql->bindParam(":correo", $datos['correo']);
            $sql->bindParam(":clave", $datos['clave']);
            $sql->bindParam(":idTipoUsuario", $datos['idTipoUsuario']);

            $sql->execute();

            $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM usuario WHERE correo = :correo;");
            $sqlQuery->bindParam(":correo", $datos['correo']);
            $sqlQuery->execute();
            $row = $sqlQuery->fetch();
            $idUsuario = $row['id'];

            if($sql->rowCount() == 1){
                $sql = mainModel::conectar()->prepare("INSERT INTO persona(tipoDocumento, documento, nombre, apellido, idUsuario) VALUES(:tipoDocumento, :documento, :nombre, :apellido, :idUsuario)");

                $sql->bindParam(":tipoDocumento", $datos['tipoDocumento']);
                $sql->bindParam(":documento", $datos['documento']);
                $sql->bindParam(":nombre", $datos['nombre']);
                $sql->bindParam(":apellido", $datos['apellido']);
                $sql->bindParam(":idUsuario", $idUsuario);

                $sql->execute();

                return $sql;
            }else{
                return $sql;
            }
        }

    }

?>