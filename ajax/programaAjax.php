<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre_ins']) || isset($_POST['id_programa_del']) || isset($_POST['id_programa_edit'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/programaControlador.php";
    $insPrograma = new programaControlador();

    /*--- Agregar un programa ---*/
    if(isset($_POST['nombre_ins'])){
        echo $insPrograma->agregarProgramaControlador();
    }

    /*--- Eliminar un programa ---*/
    if(isset($_POST['id_programa_del'])){
        echo $insPrograma->eliminarProgramaControlador();
    }

    /*--- Editar un programa ---*/
    if(isset($_POST['id_programa_edit'])){
        echo $insPrograma->editarProgramaControlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>