<?php

require_once "./modelos/vistasModelo.php";

class vistasControlador extends vistasModelo{

    /*----- Controlador para obtener plantilla -----*/
    public function obtener_plantilla_controlador(){
        session_start(['name'=>'REPO']);

        if(isset($_SESSION['tipo_usuario']) && isset($_GET['views'])){
            $ruta = explode("/", $_GET['views']);
            if($ruta[0] == "home" || $ruta[0] == "login"){
                return require_once "./vistas/plantilla-Home.php";
            }

            if($_SESSION['tipo_usuario'] == "Administrador"){
                return require_once "./vistas/plantilla-Admin.php";
            }elseif($_SESSION['tipo_usuario'] == "Docente"){
                return require_once "./vistas/plantilla-Docente.php";
            }elseif($_SESSION['tipo_usuario'] == "Estudiante"){
                return require_once "./vistas/plantilla-Estudiante.php";
            }
        }else{
            return require_once "./vistas/plantilla-Home.php";
        }
    }

    /*----- Controlador para obtener vistas -----*/
    public function obtener_vistas_controlador(){
        if(isset($_GET['views'])){
            $ruta = explode("/", $_GET['views']);
            $respuesta = vistasModelo::obtener_vistas_modelo($ruta[0]);
        }else{
            $respuesta = "home";
        }
        return $respuesta;
    }
}

?>