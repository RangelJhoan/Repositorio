<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre_ins']) || isset($_POST['id_curso_del']) || isset($_POST['id_curso_edit'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/cursoControlador.php";
    $insCurso = new cursoControlador();

    /*--- Agregar un curso ---*/
    if(isset($_POST['nombre_ins'])){
        echo $insCurso->agregarCursoControlador();
    }

    /*--- Editar un curso ---*/
    if(isset($_POST['id_curso_edit'])){
        echo $insCurso->editarCursoControlador();
    }

    /*--- Eliminar un curso ---*/
    if(isset($_POST['id_curso_del'])){
        echo $insCurso->eliminarCursoControlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>