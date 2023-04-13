<?php

class vistasModelo{
    /*----- Modelo para obtener vistas -----*/
    protected static function obtener_vistas_modelo($vistas){
        $listaBlancaAdmin = ["admin-dashboard","admin-usuarios","admin-editar-usuario","editar-perfil","admin-programas","admin-editar-programa","admin-cursos","admin-editar-curso","admin-recursos","admin-autores","admin-editar-autor","adminReportes","panel-palabras-clave","editar-palabra-clave","editar-recurso"];
        $listaBlancaDocente = ["docente-dashboard","docente-recursos","docente-mis-recursos","docente-crear-recurso","docente-editar-recurso","docente-autores","docente-mis-autores","docente-editar-autor","docente-palabras-clave","docente-mis-palabras-clave","docente-editar-palabra-clave","editar-perfil", "estudiante-feedbacks"];
        $listaBlancaEstudiante = ["estudiante-dashboard","estudiante-favoritos","editar-perfil","estudiante-feedbacks"];
        $listaBlancaHome = ["preguntas-frecuentes","busqueda","asideHomeFilters","handle"];

        //?VERIFICACIÓN TIPO DE USUARIO
        if(isset($_SESSION['tipo_usuario'])){
            //!SI ES ADMINISTRADOR ENTONCES
            if(in_array($vistas, $listaBlancaAdmin) && $_SESSION['tipo_usuario'] == "Administrador"){
                //*Puede acceder a las siguientes rutas: contenidos, etiquetas
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "404";
                }
            //! SI ES ESTUDIANTE ENTONCES
            }elseif(in_array($vistas, $listaBlancaEstudiante) && $_SESSION['tipo_usuario'] == "Estudiante"){
                //*Puede acceder a las siguientes rutas: contenidos
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "404";
                }
            //! SI ES DOCENTE ENTONCES
            }elseif(in_array($vistas, $listaBlancaDocente) && $_SESSION['tipo_usuario'] == "Docente"){
                //*Puede acceder a las siguientes rutas: contenidos
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "404";
                }
            //! SI ES LISTA BLANCA (NO ES)
            }elseif(in_array($vistas, $listaBlancaHome)){
                //*Puede acceder a las siguientes rutas: contenidos, home
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "404";
                }
            //! SI NO ES NINGUNO 
            }elseif($vistas == "home"){
                //* Estará en home
                $contenido = "home";
                //* Estará en login
            }elseif($vistas == "login"){
                $contenido = "login";
                //* Sino, muestra error 404
            }else{
                $contenido = "404";
            }
            //! SI ES LISTA BLANCA (NO ES)
        }elseif(in_array($vistas, $listaBlancaHome)){
            if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                $contenido = "./vistas/contenidos/".$vistas."-view.php";
            }else{
                $contenido = "404";
            }
        }elseif($vistas == "home"){
            $contenido = "home";
        }elseif($vistas == "404"){
            $contenido = "404";
        }else{
            $contenido = "login";
        }
        return $contenido;
    }
}

?>