<?php 
    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
        require_once "../utilidades/Utilidades.php";
    }else{
        //Modelo llamado desde la vista Index
        require_once "./utilidades/Utilidades.php";
    }

    class homeModelo extends mainModel{

        protected static function filtrarRecursos($pTipo, $pBuscar){
            if($pTipo == "Busqueda"){
                $arrayParametro = explode("¡", $pBuscar);
                $search = "";
                foreach($arrayParametro AS $dato){
                    $varDato = mainModel::decryption($dato);
                    if(strpos($varDato, '~~') == ""){
                        if($search!=""){
                            $search .= " ";
                        }
                    }
                    $search .= $varDato;
                }
                $search = str_replace("~~","",$search);
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r LEFT JOIN autor_recurso ar 
                ON r.id=ar.id_recurso LEFT JOIN autor a ON a.id = ar.id_autor LEFT JOIN etiqueta_recurso er ON er.id_recurso = r.id LEFT JOIN etiqueta e ON er.id_etiqueta = e.id
                JOIN curso_recurso cr ON cr.id_recurso = r.id JOIN curso c ON c.id=cr.id_curso
                WHERE (r.titulo LIKE '%".$search."%' OR CONCAT(a.nombre,' ',a.apellido) LIKE '%".$search."%' OR CONCAT(a.apellido,' ',a.nombre) LIKE '%".$search."%' OR e.descripcion LIKE '%".$search."%' OR r.fecha_publicacion_recurso LIKE '%".$search."%' OR c.nombre LIKE '%".$search."%' OR r.internal_id LIKE '%".$search."%') AND r.estado='".Utilidades::getIdEstado("ACTIVO")."';");    
            }else if($pTipo=="Autor"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,apellido,id FROM autor WHERE estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY apellido");
            }else if($pTipo=="Titulo"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r LEFT JOIN autor_recurso ar 
                ON r.id=ar.id_recurso LEFT JOIN autor a ON a.id = ar.id_autor WHERE r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.titulo");
            }else if($pTipo=="Fecha"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r LEFT JOIN autor_recurso ar 
                ON r.id=ar.id_recurso LEFT JOIN autor a ON a.id = ar.id_autor WHERE r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.fecha_publicacion_recurso");
            }else if($pTipo=="Curso"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,id FROM curso WHERE estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY nombre");
            }else if($pTipo=="Cursofiltrar"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,id FROM curso WHERE nombre LIKE '".$pBuscar."%' AND estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY nombre");
            }else if($pTipo=="Titulofiltrar"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor WHERE r.titulo LIKE '".$pBuscar."%' AND r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.titulo");            
            }else if($pTipo=="Autorfiltrar"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,apellido,id FROM autor WHERE apellido LIKE '".$pBuscar."%' AND estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY apellido");
            }else if($pTipo=="Fechafiltrar"){
                $pBuscar = mainModel::decryption($pBuscar);
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r WHERE r.fecha_publicacion_recurso LIKE '".$pBuscar."%' AND r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.fecha_publicacion_recurso");
            }else if($pTipo == "Titulonumero"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar ON r.id = ar.id_recurso JOIN autor a ON a.id = ar.id_autor 
                WHERE r.titulo REGEXP '^[0-9]' AND r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.titulo;");
            }else if($pTipo == "filtroAutor"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso FROM recurso r LEFT JOIN autor_recurso ar ON r.id = ar.id_recurso LEFT JOIN autor a ON a.id = ar.id_autor 
                WHERE a.id = '".$pBuscar."' AND r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.titulo;");
            }else if($pTipo == "filtroCurso"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso FROM recurso r LEFT JOIN autor_recurso ar ON r.id = ar.id_recurso LEFT JOIN autor a ON a.id = ar.id_autor
                    JOIN curso_recurso cr ON cr.id_recurso = r.id JOIN curso c ON c.id = cr.id_curso
                WHERE c.id = '".$pBuscar."' AND r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.titulo;");
            }else if($pTipo == "Archivos"){
                if($pBuscar=="Si"){
                    $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso FROM recurso r JOIN archivo a ON r.id=a.id_recurso WHERE r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.titulo");
                }else{
                    $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso,a.id_recurso FROM recurso r LEFT JOIN archivo a ON r.id=a.id_recurso WHERE a.id_recurso IS NULL AND r.estado='".Utilidades::getIdEstado("ACTIVO")."' ORDER BY r.titulo;");
                }
            }
            $sql->execute();

            return $sql;
        }

        protected static function cargarAutores($pId){
            $sql = mainModel::conectar()->prepare("SELECT a.nombre,a.apellido,a.id FROM autor a JOIN autor_recurso ar ON a.id = ar.id_autor WHERE ar.id_recurso = '".$pId."' AND a.estado = " . Utilidades::getIdEstado("ACTIVO") . " ORDER BY a.apellido");
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function cargarRecursos($pId){
            $sql = mainModel::conectar()->prepare("SELECT COUNT(*) AS recursos FROM autor_recurso ar JOIN recurso r ON r.id=ar.id_recurso WHERE id_autor = '".$pId."' AND r.estado='".Utilidades::getIdEstado("ACTIVO")."'");
            $sql->execute();

            return $sql->fetchColumn();
        }

        protected static function cargarCurso($pId){
            $sql = mainModel::conectar()->prepare("SELECT COUNT(*) AS recursos FROM curso_recurso cr JOIN recurso r ON r.id=cr.id_recurso WHERE id_curso = '".$pId."' AND r.estado='".Utilidades::getIdEstado("ACTIVO")."'");
            $sql->execute();

            return $sql->fetchColumn();
        }

        protected static function fechasRecurso(){
            $sql = mainModel::conectar()->prepare("SELECT DISTINCT(fecha_publicacion_recurso) AS fecha FROM recurso ORDER BY fecha_publicacion_recurso DESC");
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function detallesRecurso($pId){
            $sql = mainModel::conectar()->prepare("SELECT r.id, r.internal_id, r.titulo, r.fecha_publicacion_recurso, r.resumen, d.nombre, d.apellido, r.fecha_publicacion_profesor, r.enlace, r.editorial, r.isbn, r.estado FROM recurso r JOIN persona d ON d.id = r.id_docente
            WHERE r.id='".$pId."'");
            $sql->execute();

            return $sql->fetch();
        }

        protected static function cursosRecurso($pId){
            $sql = mainModel::conectar()->prepare("SELECT c.id,c.nombre FROM recurso r JOIN curso_recurso cr ON r.id = cr.id_recurso JOIN curso c ON c.id = cr.id_curso WHERE r.id = '".$pId."' AND c.estado = " . Utilidades::getIdEstado("ACTIVO"));
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function cargarEtiquetas($pId){
            $sql = mainModel::conectar()->prepare("SELECT e.descripcion FROM etiqueta e JOIN etiqueta_recurso r ON e.id = r.id_etiqueta WHERE r.id_recurso = '".$pId."' AND e.estado = " . Utilidades::getIdEstado("ACTIVO"));
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function cargarArchivos($pId){
            $sql = mainModel::conectar()->prepare("SELECT ruta,tamano,nombre FROM archivo WHERE id_recurso = '".$pId."'");
            $sql->execute();

            return $sql->fetch();
        }

        protected static function evaluarRecurso($pId, $pRespuesta){
            try {
                $recurso = mainModel::decryption($pId);
                if($pRespuesta=="Si"){
                    $sql = mainModel::conectar()->prepare("UPDATE recurso SET puntos_positivos = puntos_positivos + 1 WHERE id = '".$recurso."'");
                }else{
                    $sql = mainModel::conectar()->prepare("UPDATE recurso SET puntos_negativos = puntos_negativos + 1 WHERE id = '".$recurso."'");
                }

                $sql->execute();

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
            
        }

        protected static function quitarPunto($pId, $pRespuesta){
            try {
                $recurso = mainModel::decryption($pId);
                if($pRespuesta!="Si"){
                    $sql = mainModel::conectar()->prepare("UPDATE recurso SET puntos_positivos = puntos_positivos - 1 WHERE id = '".$recurso."'");
                }else{
                    $sql = mainModel::conectar()->prepare("UPDATE recurso SET puntos_negativos = puntos_negativos - 1 WHERE id = '".$recurso."'");
                }

                $sql->execute();

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        protected static function registrarVoto($pId, $pRespuesta){
            try {
                $recurso = mainModel::decryption($pId);
                if($pRespuesta=="Si"){
                    $voto = 1;
                }else{
                    $voto = 0;
                }
                $sql = mainModel::conectar()->prepare("INSERT INTO puntuacion_recurso(tipo_voto, id_recurso, id_estudiante) VALUES(?,?,?)");
                $sql->execute([$voto, $recurso, $_SESSION['id_persona']]);

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        protected static function editarVoto($pId, $pRespuesta){
            try {
                if($pRespuesta=="Si"){
                    $voto = 1;
                }else{
                    $voto = 0;
                }
                $sql = mainModel::conectar()->prepare("UPDATE puntuacion_recurso SET tipo_voto='".$voto."' WHERE id='".$pId."'");
                $sql->execute();

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        protected static function validarRegistroVoto($pId){
            $recurso = mainModel::decryption($pId);
            $sql = mainModel::conectar()->prepare("SELECT id FROM puntuacion_recurso WHERE id_recurso = '".$recurso."' AND id_estudiante='".$_SESSION['id_persona']."'");
            $sql->execute();

            return $sql->fetch();
        }
        
        protected static function rutaArchivo($pId){
            $recurso = mainModel::decryption($pId);
            $sql = mainModel::conectar()->prepare("SELECT ruta,nombre FROM archivo WHERE id_recurso='".$recurso."'");
            $sql->execute();

            return $sql->fetch();
        }

        protected static function recursosConArchivo(){
            $listado = mainModel::conectar()->prepare("SELECT id_recurso FROM archivo");
            $listado->execute();
            $archivos = $listado->fetchAll();
            $id_recursos = "";
            foreach($archivos AS $id){
                $id_recursos .= "'".$id."'";
            }
        }

        protected static function validarFavorito($pId){
            $recurso = mainModel::decryption($pId);
            $sql = mainModel::conectar()->prepare("SELECT id FROM recurso_favorito WHERE id_recurso = '".$recurso."' AND id_persona='".$_SESSION['id_persona']."'");
            $sql->execute();

            return $sql->fetch();
        }

        protected static function registrarFavorito($pId){
            try {
                $recurso = mainModel::decryption($pId);
                $sql = mainModel::conectar()->prepare("INSERT INTO recurso_favorito(id_recurso, id_persona) VALUES(?,?)");
                $sql->execute([$recurso, $_SESSION['id_persona']]);

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        protected static function eliminarFavorito($pId){
            try {
                $sql = mainModel::conectar()->prepare("DELETE FROM recurso_favorito WHERE id = '".$pId."'");
                $sql->execute();

                return $sql->rowCount();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
?>