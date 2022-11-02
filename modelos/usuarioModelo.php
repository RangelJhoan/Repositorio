<?php

    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
        require_once "../entidades/Persona.php";
    }else{
        //Modelo llamado desde la vista Index
        require_once "./entidades/Persona.php";
    }

    class usuarioModelo extends mainModel{

        /*---------- Modelo para agregar usuario ----------*/
        protected static function agregar_usuario_modelo(Persona $persona){
            $sql = mainModel::conectar()->prepare("INSERT INTO usuario(correo, clave, estado, id_tipo_usuario) VALUES(?, ?, ?, ?);");
            $sql->execute([$persona->getCorreo(), $persona->getClave(), $persona->getEstado(), $persona->getIdTipoUsuario()]);
            $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM usuario WHERE correo = ?;");
            $sqlQuery->execute([$persona->getCorreo()]);
            $row = $sqlQuery->fetch();
            $idUsuario = $row['id'];

            if($sql->rowCount() == 1){
                $sql = mainModel::conectar()->prepare("INSERT INTO persona(tipo_documento, documento, nombre, apellido, id_usuario) VALUES(?, ?, ?, ?, ?)");
                $sql->execute([$persona->getTipoDocumento(), $persona->getDocumento(), $persona->getNombre(), $persona->getApellido(), $idUsuario]);

                return $sql;
            }else{
                return $sql;
            }
        }

        /*---------- Modelo para eliminar usuario ----------*/
        protected static function eliminar_usuario_modelo($idPersona, $idUsuario){
            $sqlEliminarPersona = mainModel::conectar()->prepare("DELETE FROM persona WHERE id = ?");
            $sqlEliminarPersona->execute([$idPersona]);

            if($sqlEliminarPersona->rowCount() > 0){
                $sqlEliminarUsuario = mainModel::conectar()->prepare("DELETE FROM usuario WHERE id = ?");
                $sqlEliminarUsuario->execute([$idUsuario]);

                return $sqlEliminarUsuario;
            }else{
                return $sqlEliminarPersona;
            }
        }

    }

?>