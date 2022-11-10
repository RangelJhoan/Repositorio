<?php

class vistasModelo{
    /*----- Modelo para obtener vistas -----*/
    protected static function obtener_vistas_modelo($vistas){
        $listaBlanca = ["registrar","adminDashboard","adminUsuarios","adminEditarUsuario","editarPerfil","adminProgramas","adminEditarPrograma"];
        if(in_array($vistas, $listaBlanca)){
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
        return $contenido;
    }
}

?>