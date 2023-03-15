<?php 
    require_once "mainModel.php";

    class homeModelo extends mainModel{

        protected static function filtrar_recursos($pTipo, $pBuscar){
            
            
            if($pTipo == "Busqueda"){
                $arrayParametro = explode("¡", $pBuscar);
                $search = "";
                foreach($arrayParametro AS $dato){
                    if(strpos($dato, '~~') != ""){
                        if($search!=""){
                            $search .= "%";
                        }
                    }
                    
                    $search .= mainModel::decryption($dato);
                }
                $search = str_replace("~~","",$search);
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor JOIN etiqueta_recurso er ON er.id_recurso = r.id JOIN etiqueta e ON er.id_etiqueta = e.id
                JOIN curso_recurso cr ON cr.id_recurso = r.id JOIN curso c ON c.id=cr.id_curso
                WHERE r.titulo LIKE '%".$search."%' OR CONCAT(a.nombre,' ',a.apellido) LIKE '%".$search."%' OR CONCAT(a.apellido,' ',a.nombre) LIKE '%".$search."%' OR e.descripcion LIKE '%".$search."%' OR r.fecha_publicacion_recurso LIKE '%".$search."%' OR c.nombre LIKE '%".$search."%';");    
            }else if($pTipo=="Autor"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,apellido,id FROM autor ORDER BY apellido");
            }else if($pTipo=="Titulo"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor ORDER BY r.titulo");
            }else if($pTipo=="Fecha"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor ORDER BY r.fecha_publicacion_recurso");
            }else if($pTipo=="Curso"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,id FROM curso ORDER BY nombre");
            }else if($pTipo=="Cursofiltrar"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,id FROM curso WHERE nombre LIKE '".$pBuscar."%' ORDER BY nombre");
            }else if($pTipo=="Titulofiltrar"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar 
                ON r.id=ar.id_recurso JOIN autor a ON a.id = ar.id_autor WHERE r.titulo LIKE '".$pBuscar."%' ORDER BY r.titulo");            
            }else if($pTipo=="Autorfiltrar"){
                $sql = mainModel::conectar()->prepare("SELECT nombre,apellido,id FROM autor WHERE apellido LIKE '".$pBuscar."%' ORDER BY apellido");
            }else if($pTipo=="Fechafiltrar"){
                $pBuscar = mainModel::decryption($pBuscar);
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id),r.titulo,r.fecha_publicacion_recurso FROM recurso r WHERE r.fecha_publicacion_recurso LIKE '".$pBuscar."%' ORDER BY r.fecha_publicacion_recurso");
            }else if($pTipo == "Titulonumero"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar ON r.id = ar.id_recurso JOIN autor a ON a.id = ar.id_autor 
                WHERE r.titulo REGEXP '^[0-9]' ORDER BY r.titulo;");
            }else if($pTipo == "filtroAutor"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar ON r.id = ar.id_recurso JOIN autor a ON a.id = ar.id_autor 
                WHERE a.id = '".$pBuscar."' ORDER BY r.titulo;");
            }else if($pTipo == "filtroCurso"){
                $sql = mainModel::conectar()->prepare("SELECT DISTINCT (r.id), r.titulo, r.fecha_publicacion_recurso FROM recurso r JOIN autor_recurso ar ON r.id = ar.id_recurso JOIN autor a ON a.id = ar.id_autor
                    JOIN curso_recurso cr ON cr.id_recurso = r.id JOIN curso c ON c.id = cr.id_curso
                WHERE c.id = '".$pBuscar."' ORDER BY r.titulo;");
            }
            $sql->execute();

            return $sql;
        }

        protected static function cargar_autores($pId){
            $sql = mainModel::conectar()->prepare("SELECT a.nombre,a.apellido,a.id FROM autor a JOIN autor_recurso ar ON a.id = ar.id_autor WHERE ar.id_recurso = '".$pId."'ORDER BY a.apellido");
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function cargar_recursos($pId){
            $sql = mainModel::conectar()->prepare("SELECT COUNT(*) AS recursos FROM autor_recurso WHERE id_autor = '".$pId."'");
            $sql->execute();

            return $sql->fetchColumn();
        }

        protected static function cargar_curso($pId){
            $sql = mainModel::conectar()->prepare("SELECT COUNT(*) AS recursos FROM curso_recurso WHERE id_curso = '".$pId."'");
            $sql->execute();

            return $sql->fetchColumn();
        }

        protected static function fechas_recurso(){
            $sql = mainModel::conectar()->prepare("SELECT DISTINCT(fecha_publicacion_recurso) AS fecha FROM recurso ORDER BY fecha_publicacion_recurso");
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function detalles_recurso($pId){
            $sql = mainModel::conectar()->prepare("SELECT r.id,r.titulo,r.fecha_publicacion_recurso,r.resumen,d.nombre,d.apellido,r.fecha_publicacion_profesor,r.enlace FROM recurso r JOIN persona d ON d.id = r.id_docente
            WHERE r.id='".$pId."'");
            $sql->execute();

            return $sql->fetch();
        }

        protected static function cursos_recurso($pId){
            $sql = mainModel::conectar()->prepare("SELECT c.id,c.nombre FROM recurso r JOIN curso_recurso cr ON r.id = cr.id_recurso JOIN curso c ON c.id = cr.id_curso WHERE r.id = '".$pId."'");
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function cargar_etiquetas($pId){
            $sql = mainModel::conectar()->prepare("SELECT e.descripcion FROM etiqueta e JOIN etiqueta_recurso r ON e.id = r.id_etiqueta WHERE r.id_recurso = '".$pId."'");
            $sql->execute();

            return $sql->fetchAll();
        }

        protected static function cargar_archivos($pId){
            $sql = mainModel::conectar()->prepare("SELECT ruta,tamano,nombre,isbn,editorial FROM archivo WHERE id_recurso = '".$pId."'");
            $sql->execute();

            return $sql->fetch();
        }

        protected static function evaluar_recurso($pId, $pRespuesta){
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
        
    }
?>