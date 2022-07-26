<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre_ins']) || isset($_POST['id_programa_del']) || isset($_POST['id_programa_edit'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/programaControlador.php";
    $ins_programa = new programaControlador();

    /*--- Agregar un programa ---*/
    if(isset($_POST['nombre_ins'])){
        echo $ins_programa->agregar_programa_controlador();
    }

    /*--- Eliminar un programa ---*/
    if(isset($_POST['id_programa_del'])){
        echo $ins_programa->eliminar_programa_controlador();
    }

    /*--- Editar un programa ---*/
    if(isset($_POST['id_programa_edit'])){
        echo $ins_programa->editar_usuario_controlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>