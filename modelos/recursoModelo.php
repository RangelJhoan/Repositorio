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
            session_start(['name'=>"REPO"]);
            $sql = mainModel::conectar()->prepare("INSERT INTO recurso(titulo, fecha_publicacion_profesor, fecha_publicacion_recurso, resumen, estado, id_docente) VALUES(?, ?, ?, ?, ?, ?);");
            $sql->execute([$recurso->getTitulo(), date("Y-m-d H:i:s"), $recurso->getFecha(), $recurso->getResumen(), '1', $_SESSION['id_persona']]);

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
        }

        /*---------- Modelo para agregar Recurso ----------*/
        protected static function agregar_archivo_modelo(Recurso $recurso){
            try {
                $sqlQuery = mainModel::conectar()->prepare("SELECT MAX(id) AS id FROM recurso");
                $sqlQuery->execute();

                $codrecurso = $sqlQuery->fetch();
                $id_recurso = $codrecurso['id'];

                $sql = mainModel::conectar()->prepare("INSERT INTO archivo(ruta, tamano, nombre, isbn, editorial, estado, id_recurso, id_formato) VALUES(?, ?, ?, ?, ?, ?, ?, ?);");
                $sql->execute([$recurso->getArchivo(),'','',$recurso->getIsbn(),$recurso->getEditorial(),'1',$id_recurso,'1']);

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

    }

?>