<?php

class vistasModelo{
    /*----- Modelo para obtener vistas -----*/
    protected static function obtener_vistas_modelo($vistas){
        $listaBlancaAdmin = ["adminDashboard","adminUsuarios","adminEditarUsuario","editarPerfil","adminProgramas","adminEditarPrograma","adminCursos","adminEditarCurso"];
        $listaBlancaDocente = [];
        $listaBlancaEstudiante = [];
        $listaBlancaHome = ["preguntasFreq"];

        if(isset($_SESSION['tipo_usuario'])){
            if(in_array($vistas, $listaBlancaAdmin) && $_SESSION['tipo_usuario'] == "Administrador"){
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "404";
                }
            }elseif(in_array($vistas, $listaBlancaHome)){
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido = "./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido = "404";
                }
            }elseif($vistas == "home"){
                $contenido = "home";
            }elseif($vistas == "login"){
                $contenido = "login";
            }else{
                $contenido = "404";
            }
        }elseif(in_array($vistas, $listaBlancaHome)){
            if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                $contenido = "./vistas/contenidos/".$vistas."-view.php";
            }else{
                $contenido = "404";
            }
        }elseif($vistas == "home"){
            $contenido = "home";
        }else{
            $contenido = "login";
        }
        return $contenido;
    }
}

?>