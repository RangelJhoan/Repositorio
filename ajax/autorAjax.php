<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre_ins']) || isset($_POST['apellido_ins']) || isset($_POST['id_autor_del']) || isset($_POST['nombre_edit']) || isset($_POST['apellido_edit']) || isset($_POST['apellido_doc_edit'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/autorControlador.php";
    $insAutor = new autorControlador();

    /*--- ADMINISTRADOR ---*/
    /*--- Agregar un autor ---*/
    if(isset($_POST['nombre_ins']) && isset($_POST['apellido_ins'])){
        echo $insAutor->agregarAutorControlador();
    }

    /*--- Eliminar un autor ---*/
    if(isset($_POST['id_autor_del'])){
        echo $insAutor->eliminarAutorControlador();
    }

    /*--- Editar un autor ---*/
    if(isset($_POST['nombre_edit']) && isset($_POST['apellido_edit'])){
        echo $insAutor->editarAutorControlador();
    }

    /*--- DOCENTE ---*/
    /*--- Editar un autor ---*/
    if(isset($_POST['apellido_doc_edit'])){
        echo $insAutor->editarDocenteAutorControlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>