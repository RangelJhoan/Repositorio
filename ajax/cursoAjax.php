<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre_ins']) || isset($_POST['id_curso_del']) || isset($_POST['id_curso_edit'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/cursoControlador.php";
    $ins_curso = new cursoControlador();

    /*--- Agregar un curso ---*/
    if(isset($_POST['nombre_ins'])){
        echo $ins_curso->agregar_curso_controlador();
    }

    /*--- Editar un curso ---*/
    if(isset($_POST['id_curso_edit'])){
        echo $ins_curso->editar_curso_controlador();
    }

    /*--- Eliminar un curso ---*/
    if(isset($_POST['id_curso_del'])){
        echo $ins_curso->eliminar_curso_controlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>