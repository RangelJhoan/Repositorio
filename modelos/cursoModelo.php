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

        /*---------- Modelo para agregar curso ----------*/
        protected static function agregar_curso_modelo(Curso $curso){
            $sql = mainModel::conectar()->prepare("INSERT INTO curso(nombre, descripcion, estado) VALUES(?, ?, ?);");
            $sql->execute([$curso->getNombre(), $curso->getDescripcion(), $curso->getEstado()]);
            $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM curso WHERE nombre = ?;");
            $sqlQuery->execute([$curso->getNombre()]);
            $row = $sqlQuery->fetch();
            $idCurso = $row['id'];

            if($sql->rowCount() == 1){
                foreach($curso->getListaProgramas() as $programaID){
                    $sql = mainModel::conectar()->prepare("INSERT INTO curso_programa(id_curso, id_programa) VALUES(?, ?)");
                    $sql->execute([$idCurso, $programaID]);
                }

                foreach($curso->getListaDocente() as $docenteID){
                    $sql = mainModel::conectar()->prepare("INSERT INTO docente_curso(id_curso, id_docente) VALUES(?, ?)");
                    $sql->execute([$idCurso, $docenteID]);
                }
                return $sql;
            }
            return $sql;
        }

        /*---------- Modelo para eliminar curso ----------*/
        protected static function eliminar_curso_modelo($idCurso){
            $sqlEliminarFkCurso = mainModel::conectar()->prepare("DELETE FROM curso_programa WHERE id_curso = ?");
            $sqlEliminarFkCurso->execute([$idCurso]);

            if($sqlEliminarFkCurso->rowCount() > 0){
                $sqlEliminarUsuario = mainModel::conectar()->prepare("DELETE FROM curso WHERE id = ?");
                $sqlEliminarUsuario->execute([$idCurso]);

                return $sqlEliminarUsuario;
            }else{
                return $sqlEliminarFkCurso;
            }
        }

        /*---------- Modelo para editar estado del curso ----------*/
        protected static function editar_estado_curso_modelo(Curso $curso){
            try {
                $sql = mainModel::conectar()->prepare("UPDATE curso SET estado=? WHERE id=?");
                $sql->execute([$curso->getEstado(), $curso->getIdCurso()]);
                return $sql->rowCount();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo para editar información de curso ----------*/
        protected static function editar_curso_modelo($curso, $programasAgregados, $programasEliminados, $docentesAgregados, $docentesEliminados){
            $sql = mainModel::conectar()->prepare("UPDATE curso SET nombre=?, descripcion=?, estado=? WHERE id=?");
            $sql->execute([$curso->getNombre(), $curso->getDescripcion(), $curso->getEstado() ,$curso->getIdCurso()]);

            foreach ($programasAgregados as $programaNuevo) {
                $sql = mainModel::conectar()->prepare("INSERT INTO curso_programa(id_curso, id_programa) VALUES(?, ?);");
                $sql->execute([$curso->getIdCurso(), $programaNuevo]);
            }

            foreach ($programasEliminados as $programaEliminar) {
                $sql = mainModel::conectar()->prepare("DELETE FROM curso_programa WHERE id_curso = ? and id_programa = ?");
                $sql->execute([$curso->getIdCurso(), $programaEliminar]);
            }

            foreach ($docentesAgregados as $docenteNuevo) {
                $sql = mainModel::conectar()->prepare("INSERT INTO docente_curso(id_curso, id_docente) VALUES(?, ?);");
                $sql->execute([$curso->getIdCurso(), $docenteNuevo]);
            }

            foreach ($docentesEliminados as $docenteEliminar) {
                $sql = mainModel::conectar()->prepare("DELETE FROM docente_curso WHERE id_curso = ? and id_docente = ?");
                $sql->execute([$curso->getIdCurso(), $docenteEliminar]);
            }

            return $sql;
        }

        /*---------- Modelo datos curso ----------*/
        protected static function datos_curso_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * 
                FROM curso 
                WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") ." AND id = :ID;");
                $sql->bindParam(":ID", $id);
            }elseif($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id 
                FROM curso 
                WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") .";");
            }
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo programas por curso ----------*/
        protected static function programas_curso_modelo($id){
            $sql = mainModel::conectar()->prepare("SELECT c.id curso_id, c.nombre curso_nombre, c.descripcion curso_desc, cp.id curpro_id, p.id programa_id, p.nombre programa_nombre, p.descripcion programa_desc 
            FROM curso c JOIN curso_programa cp ON c.id = cp.id_curso JOIN programa p ON p.id = cp.id_programa 
            WHERE c.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo docentes por curso ----------*/
        protected static function docentes_curso_modelo($id){
            $sql = mainModel::conectar()->prepare("SELECT c.id curso_id, c.nombre curso_nombre, c.descripcion curso_desc, p.id idPersona, p.nombre nombrePersona, p.apellido apeliidoDocente 
            FROM curso c 
            JOIN docente_curso dc ON c.id = dc.id_curso 
            JOIN persona p ON p.id = dc.id_docente 
            WHERE c.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo id de programas por curso ----------*/
        protected static function id_programas_curso_modelo($id){
            $sql = mainModel::conectar()->prepare("SELECT p.id programa_id 
            FROM curso c JOIN curso_programa cp ON c.id = cp.id_curso JOIN programa p ON p.id = cp.id_programa 
            WHERE c.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo id de docentes por curso ----------*/
        protected static function id_docentes_curso_modelo($id){
            $sql = mainModel::conectar()->prepare("SELECT dc.id_docente docente 
            FROM curso c 
            JOIN docente_curso dc ON c.id = dc.id_curso 
            WHERE c.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo cursos por recurso ----------*/
        protected static function cursosXRecursoModelo($id){
            $sql = mainModel::conectar()->prepare("SELECT c.id, c.nombre 
            FROM curso c 
            JOIN curso_recurso cr ON c.id = cr.id_curso 
            JOIN recurso r ON r.id = cr.id_recurso 
            WHERE r.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

    }

?>