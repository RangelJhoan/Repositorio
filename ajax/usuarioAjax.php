<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['correo']) || isset($_POST['idUsuario']) || isset($_POST['id_usuario_editar']) || isset($_POST['id_persona'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();

    /*--- Agregar un usuario ---*/
    if(isset($_POST['correo']) && isset($_POST['documento'])){
        echo $ins_usuario->agregar_usuario_controlador();
    }

    /*--- Eliminar un usuario ---*/
    if(isset($_POST['idUsuario'])){
        echo $ins_usuario->eliminar_usuario_controlador();
    }

    /*--- Editar un usuario ---*/
    if(isset($_POST['id_usuario_editar'])){
        echo $ins_usuario->editar_usuario_controlador();
    }

    /*--- Cerrar sesión ---*/
    if(isset($_POST['id_persona']) && isset($_POST['correo_usuario'])){
        echo $ins_usuario->cerrar_sesion_controlador();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>