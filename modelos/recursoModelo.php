<?php

    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
        require_once "../entidades/Recurso.php";
    }else{
        //Modelo llamado desde la vista Index
        require_once "./entidades/Recurso.php";
    }

    class recursoModelo extends mainModel{

        /*---------- Modelo para agregar Recurso ----------*/
        protected static function agregar_recurso_modelo(Recurso $recurso){
            try{
                session_start(['name'=>"REPO"]);
                $sql = mainModel::conectar()->prepare("INSERT INTO recurso(titulo, fecha_publicacion_profesor, fecha_publicacion_recurso, resumen, puntos_positivos, puntos_negativos, estado, enlace, id_docente) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $sql->execute([$recurso->getTitulo(), date("Y-m-d H:i:s"), $recurso->getFecha(), $recurso->getResumen(), 0, 0, $recurso->getEstado(), $recurso->getEnlace(), $_SESSION['id_persona']]);

                $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM recurso WHERE titulo = ?;");
                $sqlQuery->execute([$recurso->getTitulo()]);
                $row = $sqlQuery->fetch();
                $idRecurso = $row['id'];

                if($sql->rowCount() == 1){
                    foreach($recurso->getAutor() as $autorID){
                        $sql = mainModel::conectar()->prepare("INSERT INTO autor_recurso(id_recurso, id_autor) VALUES(?, ?)");
                        $sql->execute([$idRecurso, $autorID]);
                    }

                    foreach($recurso->getEtiqueta() as $etiquetaID){
                        $sql = mainModel::conectar()->prepare("INSERT INTO etiqueta_recurso(id_recurso, id_etiqueta) VALUES(?, ?)");
                        $sql->execute([$idRecurso, $etiquetaID]);
                    }

                    foreach($recurso->getCurso() as $cursoID){
                        $sql = mainModel::conectar()->prepare("INSERT INTO curso_recurso(id_recurso, id_curso) VALUES(?, ?)");
                        $sql->execute([$idRecurso, $cursoID]);
                    }
                    return $sql;
                }
                return $sql;
            }catch(Exception $e){
                return $e->getMessage();
            }
        }

        /*---------- Modelo para agregar Recurso ----------*/
        protected static function agregar_archivo_modelo(Recurso $recurso){
            try {
                $sqlQuery = mainModel::conectar()->prepare("SELECT MAX(id) AS id FROM recurso");
                $sqlQuery->execute();

                $codrecurso = $sqlQuery->fetch();
                $id_recurso = $codrecurso['id'];

                $sql = mainModel::conectar()->prepare("INSERT INTO archivo(ruta, tamano, nombre, isbn, editorial, estado, id_recurso, id_formato) VALUES(?, ?, ?, ?, ?, ?, ?, ?);");
                $sql->execute([$recurso->getArchivo()->getRuta(), $recurso->getArchivo()->getTamano(), $recurso->getArchivo()->getNombre() ,$recurso->getArchivo()->getISBN(),$recurso->getArchivo()->getEditorial(),$recurso->getArchivo()->getEstado(), $id_recurso, '1']);

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        /*---------- Modelo datos recurso ----------*/
        protected static function datos_recurso_modelo($tipo, $id){
            if($tipo == "Unico"){
                $sql = mainModel::conectar()->prepare("SELECT * 
                FROM recurso r
                LEFT JOIN archivo a ON a.id_recurso = r.id
                WHERE r.estado != ". Utilidades::getIdEstado("ELIMINADO") ." AND r.id = :ID;");
                $sql->bindParam(":ID", $id);
            }elseif($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id 
                FROM recurso
                WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") .";");
            }
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo archivo por recurso ----------*/
        protected static function archivoXRecursoModelo($id){
            $sql = mainModel::conectar()->prepare("SELECT a.nombre 
            FROM archivo a 
            JOIN recurso r ON r.id = a.id_recurso 
            WHERE r.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        protected static function editar_estado_recurso_modelo(Recurso $recurso){
            try {
                $sql = mainModel::conectar()->prepare("UPDATE recurso SET estado=? WHERE id=?");
                $sql->execute([$recurso->getEstado(), $recurso->getIdRecurso()]);
                return $sql->rowCount();
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo id de autores por recurso ----------*/
        protected static function idAutoresRecurso($id){
            $sql = mainModel::conectar()->prepare("SELECT ar.id_autor 
            FROM recurso r 
            JOIN autor_recurso ar ON r.id = ar.id_recurso 
            WHERE r.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo id de etiquetas por recurso ----------*/
        protected static function idEtiquetasRecurso($id){
            $sql = mainModel::conectar()->prepare("SELECT er.id_etiqueta 
            FROM recurso r 
            JOIN etiqueta_recurso er ON r.id = er.id_recurso 
            WHERE r.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo id de cursos por recurso ----------*/
        protected static function idCursosRecurso($id){
            $sql = mainModel::conectar()->prepare("SELECT cr.id_curso 
            FROM recurso r 
            JOIN curso_recurso cr ON r.id = cr.id_recurso 
            WHERE r.id = :ID;");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        /*---------- Modelo para editar información de recurso ----------*/
        protected static function editar_recurso_modelo($recurso, $cursosAgregados, $cursosEliminados){
            try {
                $sql = mainModel::conectar()->prepare("UPDATE recurso SET titulo=?, fecha_publicacion_recurso=?, resumen=?, estado=?, enlace=? WHERE id=?");
                $sql->execute([$recurso->getTitulo(), $recurso->getFecha(), $recurso->getResumen(), $recurso->getEstado(), $recurso->getEnlace(), $recurso->getIdRecurso()]);

                foreach ($cursosAgregados as $cursoNuevo) {
                    $sql = mainModel::conectar()->prepare("INSERT INTO curso_recurso(id_recurso, id_curso) VALUES(?, ?);");
                    $sql->execute([$recurso->getIdRecurso(), $cursoNuevo]);
                }

                foreach ($cursosEliminados as $cursoEliminar) {
                    $sql = mainModel::conectar()->prepare("DELETE FROM curso_recurso WHERE id_recurso = ? and id_curso = ?");
                    $sql->execute([$recurso->getIdRecurso(), $cursoEliminar]);
                }

                return $sql;
            } catch (Exception $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo para editar información de recurso ----------*/
        protected static function editar_recurso_etiqueta_modelo($recurso, $etiquetasAgregadas, $etiquetasEliminadas){
            try {
                foreach ($etiquetasAgregadas as $etiquetaNueva) {
                    $sql = mainModel::conectar()->prepare("INSERT INTO etiqueta_recurso(id_recurso, id_etiqueta) VALUES(?, ?);");
                    $sql->execute([$recurso->getIdRecurso(), $etiquetaNueva]);
                }

                foreach ($etiquetasEliminadas as $etiquetaEliminar) {
                    $sql = mainModel::conectar()->prepare("DELETE FROM etiqueta_recurso WHERE id_recurso = ? and id_etiqueta = ?");
                    $sql->execute([$recurso->getIdRecurso(), $etiquetaEliminar]);
                }
            } catch (Exception $th) {
                return $th->getMessage();
            }
        }

        /*---------- Modelo para editar información de recurso ----------*/
        protected static function editar_recurso_autor_modelo($recurso, $autoresAgregados, $autoresEliminados){
            try {
                foreach ($autoresAgregados as $autorNuevo) {
                    $sql = mainModel::conectar()->prepare("INSERT INTO autor_recurso(id_recurso, id_autor) VALUES(?, ?);");
                    $sql->execute([$recurso->getIdRecurso(), $autorNuevo]);
                }

                foreach ($autoresEliminados as $autorEliminar) {
                    $sql = mainModel::conectar()->prepare("DELETE FROM autor_recurso WHERE id_recurso = ? and id_autor = ?");
                    $sql->execute([$recurso->getIdRecurso(), $autorEliminar]);
                }
            } catch (Exception $th) {
                return $th->getMessage();
            }
        }

    }

?>