<?php

$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['correo']) || isset($_POST['idUsuario']) || isset($_POST['id_usuario_editar']) || isset($_POST['id_persona']) || isset($_POST['id_usuario_edit_perfil']) || 
isset($_POST['correo_recuperar_clave']) || isset($_POST['correo_registrarme']) || isset($_POST['graficar_admin_usuarios'])){
    /*--- Instancia al controlador ---*/
    require_once "../controladores/usuarioControlador.php";
    $insUsuario = new usuarioControlador();

    /*--- Agregar un usuario ---*/
    if(isset($_POST['correo']) && isset($_POST['documento'])){
        echo $insUsuario->agregarUsuarioControlador();
    }

    /*--- Agregar un estudiante desde la vista del loguin ---*/
    if(isset($_POST['correo_registrarme']) && isset($_POST['documento_registrarme'])){
        echo $insUsuario->agregarEstudianteControlador();
    }

    /*--- Eliminar un usuario ---*/
    if(isset($_POST['idUsuario'])){
        echo $insUsuario->eliminarUsuarioControlador();
    }

    /*--- Editar un usuario ---*/
    if(isset($_POST['id_usuario_editar'])){
        echo $insUsuario->editarUsuarioControlador();
    }

    /*--- Cerrar sesión ---*/
    if(isset($_POST['id_persona']) && isset($_POST['correo_usuario'])){
        echo $insUsuario->cerrarSesionControlador();
    }

    /*--- Editar perfil ---*/
    if(isset($_POST['id_usuario_edit_perfil']) && isset($_POST['correo_edit_perfil'])){
        echo $insUsuario->editarPerfilControlador();
    }

    /*--- Recuperar contraseña ---*/
    if(isset($_POST['correo_recuperar_clave'])){
        echo $insUsuario->recuperarClaveControlador();
    }

    /*--- Contar la cantidad de usuarios por tipo de usuario ---*/
    if(isset($_POST['graficar_admin_usuarios'])){
        echo $insUsuario->contarCantidadUsuariosXTipo();
    }

}else{
    session_start(['name' => 'REPO']);
    session_unset();
    session_destroy();
    header("Location: " . SERVER_URL."login/");
    exit();
}

?>