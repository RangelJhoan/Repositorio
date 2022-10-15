<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/usuarioModelo.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/usuarioModelo.php";
}

class usuarioControlador extends usuarioModelo{

    /*---------- Controlador para agregar usuario ----------*/
    public function agregar_usuario_controlador(){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $tipoDocumento = $_POST['tipoDocumento'];
        $documento = $_POST['documento'];
        $clave = $_POST['clave'];
        $confirmarClave = $_POST['confirmarClave'];

        if($nombre=="" || $apellido=="" || $correo =="" || $tipoDocumento=="" || $documento==""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_usuario_reg = [
            "tipoDocumento" => $tipoDocumento,
            "documento" => $documento,
            "nombre" => $nombre,
            "apellido" => $apellido
        ];

        $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

        if($agregar_usuario->rowCount() == 1){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Exitoso",
                "Texto"=>"Usuario creado correctamente por favor espere activar el usuario",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Error al crear el usuario",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /*---------- Controlador para agregar usuario desde el formulario de registro e iniciar sesión ----------*/
    public function agregar_usuario_loginReg_controlador(){
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $tipoDocumento = $_POST['tipoDocumento'];
        $documento = $_POST['documento'];
        $clave = $_POST['clave'];
        $confirmarClave = $_POST['confirmarClave'];

        if($nombre=="" || $apellido=="" || $correo =="" || $tipoDocumento=="" || $documento==""){
            echo '<script>
                    Swal.fire({
                        title: "Ocurrió un error",
                        text: "Por favor llene los campos",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
        }

        $datos_usuario_reg = [
            "tipoDocumento" => $tipoDocumento,
            "documento" => $documento,
            "nombre" => $nombre,
            "apellido" => $apellido
        ];

        $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

        if($agregar_usuario->rowCount() == 1){
            echo '<script>
                    Swal.fire({
                        title: "Exitoso",
                        text: "Usuario creado correctamente por favor espere activar el usuario",
                        icon: "success",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
        }else{
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Error al crear el usuario",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
        }

    }

}

?>