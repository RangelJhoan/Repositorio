<?php

class vistasModelo{
    /*----- Modelo para obtener vistas -----*/
    protected static function obtener_vistas_modelo($vistas){
        $listaBlancaAdmin = ["adminDashboard","adminUsuarios","adminEditarUsuario","editarPerfil","adminProgramas","adminEditarPrograma","adminCursos","adminEditarCurso","adminRecursos","adminAutores","adminEditarAutor","adminReportes","panelPalabrasClave","editarPalabraClave","editarRecurso"];
        $listaBlancaDocente = ["docenteDashboard","docenteRecursos","docenteMisRecursos","docenteCrearRecurso","docenteEditarRecurso","docenteAutores","docenteMisAutores","docenteEditarAutor","docentePalabrasClave","docenteMisPalabrasClave","docenteEditarPalabraClave","editarPerfil"];
        $listaBlancaEstudiante = ["estudianteDashboard","estudianteFavoritos","editarPerfil","estudianteFeedbacks"];
        $listaBlancaHome = ["preguntasFreq","recursosBusqueda","asideHomeFilters","recursosVisualizacion"];

        //?VERIFICACIÓN TIPO DE USUARIO
        if(isset($_SESSION['tipo_usuario'])){
            //!SI ES ADMINISTRADOR ENTONCES
            if(in_array($vistas, $listaBlancaAdmin) && $_SESSION['tipo_usuario'] == "Administrador"){
                //*Puede acceder a las siguientes rutas: contenidos, etiquetas
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else if(is_file("./vistas/contenidos/palabrasClave/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/palabrasClave/".$vistas."-view.php";
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
                }else if(is_file("./vistas/contenidos/palabrasClave/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/palabrasClave/".$vistas."-view.php";
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