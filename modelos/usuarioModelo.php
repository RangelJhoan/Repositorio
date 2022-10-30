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
            $sql = mainModel::conectar()->prepare("INSERT INTO usuario(correo, clave, idTipoUsuario) VALUES(?, ?, ?);");
            $sql->execute([$persona->getCorreo(), $persona->getClave(), $persona->getIdTipoUsuario()]);

            $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM usuario WHERE correo = ?;");
            $sqlQuery->execute([$persona->getCorreo()]);
            $row = $sqlQuery->fetch();
            $idUsuario = $row['id'];

            if($sql->rowCount() == 1){
                $sql = mainModel::conectar()->prepare("INSERT INTO persona(tipoDocumento, documento, nombre, apellido, idUsuario) VALUES(?, ?, ?, ?, ?)");
                $sql->execute([$persona->getTipoDocumento(), $persona->getDocumento(), $persona->getNombre(), $persona->getApellido(), $idUsuario]);

                return $sql;
            }else{
                return $sql;
            }
        }

    }

?>