<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['descripcion_ins']) || isset($_POST['id_etiqueta_del']) || isset($_POST['id_etiqueta_edit']) || isset($_POST['id_docente_etiqueta_edit'])){
    require_once "../controladores/etiquetaControlador.php";
    $ins_etiqueta = new etiquetaControlador();

    /*--- ADMINISTRADOR ---*/
    if(isset($_POST['descripcion_ins'])){
        echo $ins_etiqueta->agregar_etiqueta_controlador();
    }

    if(isset($_POST['id_etiqueta_edit'])){
        echo $ins_etiqueta->editar_etiqueta_controlador();
    }

    if(isset($_POST['id_etiqueta_del'])){
        echo $ins_etiqueta->eliminar_etiqueta_controlador();
    }

    /*--- DOCENTE ---*/
    if(isset($_POST['id_docente_etiqueta_edit'])){
        echo $ins_etiqueta->editar_docente_etiqueta_controlador();
    }
}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>