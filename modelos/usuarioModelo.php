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
            try {
                $sql = mainModel::conectar()->prepare("INSERT INTO usuario(correo, clave, estado, id_tipo_usuario) VALUES(?, ?, ?, ?);");
                $sql->execute([$persona->getCorreo(), $persona->getClave(), $persona->getEstado(), $persona->getIdTipoUsuario()]);
                $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM usuario WHERE correo = ?;");
                $sqlQuery->execute([$persona->getCorreo()]);
                $row = $sqlQuery->fetch();
                $idUsuario = $row['id'];

                if($sql->rowCount() == 1){
                    $sql = mainModel::conectar()->prepare("INSERT INTO persona(documento, nombre, apellido, estado, id_tipo_documento, id_usuario) VALUES(?, ?, ?, ?, ?, ?)");
                    $sql->execute([$persona->getDocumento(), $persona->getNombre(), $persona->getApellido(), $persona->getEstadoPersona(), $persona->getTipoDocumento()->getIdTipoDocumento(), $idUsuario]);

                    return $sql->rowCount();
                }else{
                    return $sql->rowCount();
                }
            } catch (Exception $e) {
                return $e->getMessage();
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

        /*---------- Modelo datos usuario ----------*/
        protected static function datos_usuario_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT p.id, p.nombre, p.apellido, p.documento, td.descripcion as descripcionTipoDocumento, u.correo, u.clave, u.estado, tu.descripcion 
                FROM persona p JOIN tipo_documento td ON td.id = p.id_tipo_documento JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
                WHERE p.id = :ID;");
                $sql->bindParam(":ID", $id);
            }elseif($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT p.id 
                FROM persona p JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario;");
            }
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo editar persona ----------*/
        protected static function editar_persona_modelo(Persona $persona){
            try {
                $sql = mainModel::conectar()->prepare("UPDATE persona SET id_tipo_documento=?, documento=?, nombre=?, apellido=? WHERE id=?");

                $sql->execute([$persona->getTipoDocumento()->getIdTipoDocumento(), $persona->getDocumento(), $persona->getNombre(), $persona->getApellido(), 
                $persona->getIdPersona()]);

                return $sql->rowCount();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo editar usuario ----------*/
        protected static function editar_usuario_modelo(Persona $persona){
            try {
                $sql_usuario = mainModel::conectar()->prepare("UPDATE usuario SET estado=?, clave=? WHERE id=?");
                $sql_usuario->execute([$persona->getEstado(), $persona->getClave(), $persona->getIdUsuario()]);

                return $sql_usuario->rowCount();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

    }

?>