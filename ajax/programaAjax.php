<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre']) || isset($_POST['idPrograma'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/programaControlador.php";
    $ins_programa = new programaControlador();

    /*--- Agregar un programa ---*/
    if(isset($_POST['nombre'])){
        echo $ins_programa->agregar_programa_controlador();
    }

    /*--- Agregar un programa ---*/
    if(isset($_POST['idPrograma'])){
        echo $ins_programa->eliminar_programa_controlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>