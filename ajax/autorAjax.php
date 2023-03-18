<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre_ins']) || isset($_POST['apellido_ins']) || isset($_POST['id_autor_del']) || isset($_POST['nombre_edit']) || isset($_POST['apellido_edit']) || isset($_POST['apellido_doc_edit'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/autorControlador.php";
    $ins_autor = new autorControlador();

    /*--- ADMINISTRADOR ---*/

    /*--- Agregar un autor ---*/
    if(isset($_POST['nombre_ins']) && isset($_POST['apellido_ins'])){
        echo $ins_autor->agregar_autor_controlador();
    }

    /*--- Eliminar un autor ---*/
    if(isset($_POST['id_autor_del'])){
        echo $ins_autor->eliminar_autor_controlador();
    }

    /*--- Editar un autor ---*/
    if(isset($_POST['nombre_edit']) && isset($_POST['apellido_edit'])){
        echo $ins_autor->editar_autor_controlador();
    }

    /*--- DOCENTE ---*/
    /*--- Editar un autor ---*/
    if(isset($_POST['apellido_doc_edit'])){
        echo $ins_autor->editar_docente_autor_controlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>