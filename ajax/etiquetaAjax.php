<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['descripcion_ins']) || isset($_POST['id_etiqueta_del']) || isset($_POST['id_etiqueta_edit']) || isset($_POST['id_docente_etiqueta_edit'])){
    require_once "../controladores/etiquetaControlador.php";
    $insEtiqueta = new etiquetaControlador();

    /*--- ADMINISTRADOR ---*/
    if(isset($_POST['descripcion_ins'])){
        echo $insEtiqueta->agregarEtiquetaControlador();
    }

    if(isset($_POST['id_etiqueta_edit'])){
        echo $insEtiqueta->editarEtiquetaControlador();
    }

    if(isset($_POST['id_etiqueta_del'])){
        echo $insEtiqueta->eliminarEtiquetaControlador();
    }

    /*--- DOCENTE ---*/
    if(isset($_POST['id_docente_etiqueta_edit'])){
        echo $insEtiqueta->editarDocenteEtiquetaControlador();
    }
}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>