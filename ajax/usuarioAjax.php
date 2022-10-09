<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(true){
    require_once "../controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();
    echo $ins_usuario->agregar_usuario_controlador();

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."home/");
    exit();
}

?>