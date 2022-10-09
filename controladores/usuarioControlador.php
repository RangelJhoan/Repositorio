<?php

require_once "../modelos/usuarioModelo.php";

class usuarioControlador extends usuarioModelo{

    /*---------- Controlador para agregar usuario ----------*/
    public function agregar_usuario_controlador(){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $tipoDocumento = $_POST['tipoDocumento'];
        $documento = $_POST['documento'];

        $datos_usuario_reg = [
            "tipoDocumento" => $tipoDocumento,
            "documento" => $documento,
            "nombre" => $nombre,
            "apellido" => $apellido
        ];

        $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

        if($agregar_usuario->rowCount() == 1){
            echo "<script>console.log('Usuario agregado correctamente');</script>";
        }else{
            echo "<script>console.log('Error al agregar usuario');</script>";
        }

    }

}

?>