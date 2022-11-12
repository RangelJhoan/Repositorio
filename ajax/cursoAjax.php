<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['nombre_ins'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/cursoControlador.php";
    $ins_curso = new cursoControlador();

    /*--- Agregar un curso ---*/
    if(isset($_POST['nombre_ins'])){
        echo $ins_curso->agregar_curso_controlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>