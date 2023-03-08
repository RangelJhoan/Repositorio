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
                $sql = mainModel::conectar()->prepare("INSERT INTO recurso(titulo, fecha_publicacion_profesor, fecha_publicacion_recurso, resumen, estado, enlace, id_docente) VALUES(?, ?, ?, ?, ?, ?, ?);");
                $sql->execute([$recurso->getTitulo(), date("Y-m-d H:i:s"), $recurso->getFecha(), $recurso->getResumen(), 1, $recurso->getEnlace(), $_SESSION['id_persona']]);

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
                FROM recurso 
                WHERE estado != ". 3 ." AND id = :ID;");
                $sql->bindParam(":ID", $id);
            }elseif($tipo == "Conteo"){
                $sql = mainModel::conectar()->prepare("SELECT id 
                FROM recurso
                WHERE estado != ". 3 .";");
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

    }

?>