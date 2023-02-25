<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/usuarioModelo.php";
    require_once "../entidades/Persona.php";
    require_once "../entidades/TipoDocumento.php";
    require_once "../utilidades/EstadosEnum.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/usuarioModelo.php";
    require_once "./entidades/Persona.php";
    require_once "./entidades/TipoDocumento.php";
    require_once "./utilidades/EstadosEnum.php";
}

class usuarioControlador extends usuarioModelo{

    /*---------- Controlador para agregar usuario ----------*/
    public function agregar_usuario_controlador(){
        $persona = new Persona();
        $persona->setNombre($_POST['nombre']);
        $persona->setApellido($_POST['apellido']);
        $persona->setCorreo($_POST['correo']);
        $persona->setDocumento($_POST['documento']);
        $persona->setClave($_POST['clave']);
        $persona->setIdTipoUsuario($_POST['tipoUsuario']);
        $persona->setEstado($_POST['estado']);
        $confirmarClave = $_POST['confirmarClave'];

        $persona->setEstado(EstadosEnum::ACTIVO->value);
        $persona->setEstadoPersona(EstadosEnum::ACTIVO->value);

        $tipoDocumento = new TipoDocumento();
        $tipoDocumento->setIdTipoDocumento($_POST['tipoDocumento']);

        $persona->setTipoDocumento($tipoDocumento);

        if($persona->getNombre() == "" || $persona->getApellido() == "" || $persona->getCorreo() == "" || $persona->getTipoDocumento() == "" ||
            $persona->getDocumento() == "" || $persona->getClave() == "" || $persona->getIdTipoUsuario() == "" || $persona->getEstado() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if($persona->getClave() != $confirmarClave){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Las claves ingresadas no coinciden",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $check_documento = mainModel::ejecutar_consulta_simple("SELECT documento FROM persona WHERE documento = '".$persona->getDocumento()."';");

        if($check_documento->rowCount() > 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Documento de indentidad ya se encuentra registrado en el repositorio",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $persona->setClave(mainModel::encryption($persona->getClave()));
            $agregar_usuario = usuarioModelo::agregar_usuario_modelo($persona);

            if($agregar_usuario != 1){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Error al crear el usuario",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Usuario creado correctamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
        }
    }

    /*---------- Controlador para iniciar sesion usuario ----------*/
    public function iniciarSesion_usuario_controlador(){
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];

        if($correo == "" || $clave == ""){
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Por favor llene todos los campos requeridos",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                exit();
        }

        $clave = mainModel::encryption($clave);
        $check_account = mainModel::ejecutar_consulta_simple("SELECT p.id, p.nombre, p.apellido, p.documento, p.id_usuario, td.descripcion as tipoDocumento, u.correo, u.estado, tu.descripcion 
        FROM persona p JOIN tipo_documento td ON td.id = p.id_tipo_documento JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE correo = '$correo' AND clave = '$clave';");

        if($check_account->rowCount() > 0){
            $row = $check_account->fetch();
            if($row['estado'] != EstadosEnum::ACTIVO->value){
                echo '<script>
                    Swal.fire({
                        title:"Error",
                        text:"Cuenta inactiva. Por favor contacte a un administrador",
                        icon:"error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                exit();
            }


            session_start(['name'=>'REPO']);
            $_SESSION['id_persona'] = $row['id'];
            $_SESSION['nombre_usuario'] = $row['nombre'];
            $_SESSION['apellido_usuario'] = $row['apellido'];
            $_SESSION['tipo_documento'] = $row['tipoDocumento'];
            $_SESSION['documento_usuario'] = $row['documento'];
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['correo_usuario'] = $row['correo'];
            $_SESSION['estado_usuario'] = $row['estado'];
            $_SESSION['tipo_usuario'] = $row['descripcion'];

            if($row['descripcion'] == "Administrador"){
                echo "<script>window.location.href='".SERVER_URL."adminDashboard/';</script>";
            }elseif($row['descripcion'] == "Docente"){
                echo "<script>window.location.href='".SERVER_URL."docenteDashboard/';</script>";
            }elseif($row['descripcion'] == "Estudiante"){
                echo "<script>window.location.href='".SERVER_URL."estudianteDashboard/';</script>";
            }
        }else{
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Error al validar credenciales del usuario",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
        }
    }

    /*---------- Controlador para forzar cierre sesión usuario ----------*/
    public function forzar_cierre_sesion_controlador(){
        session_unset();
        session_destroy();
        echo "<script>window.location.href='".SERVER_URL."login/';</script>";
    }

    /*---------- Controlador para cerrar sesión usuario ----------*/
    public function cerrar_sesion_controlador(){
        session_start(['name' => 'REPO']);
        $id_persona = mainModel::decryption($_POST['id_persona']);
        $correo = mainModel::decryption($_POST['correo_usuario']);

        if($id_persona == $_SESSION['id_persona'] && $correo == $_SESSION['correo_usuario']){
            session_unset();
            session_destroy();

            $alerta=[
                "Alerta"=>"redireccionar",
                "URL"=>SERVER_URL
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"No se pudo cerrar la sesión en el sistema",
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

    /*---------- Controlador para eliminar usuario ----------*/
    public function eliminar_usuario_controlador(){
        $persona = new Persona();
        $persona->setIdPersona(mainModel::decryption($_POST['idPersona']));
        $persona->setIdUsuario(mainModel::decryption($_POST['idUsuario']));
        $persona->setEstadoPersona(EstadosEnum::ELIMINADO->value);
        $persona->setEstado(EstadosEnum::ELIMINADO->value);

        $editarPersona = usuarioModelo::editar_estado_persona_modelo($persona);

        if(is_string($editarPersona) || $editarPersona < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo eliminar la persona",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $editarUsuario = usuarioModelo::editar_estado_usuario_modelo($persona);

        if(is_string($editarUsuario) || $editarUsuario < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo eliminar el usuario",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $alerta=[
            "Alerta"=>"recargar",
            "Titulo"=>"Exitoso",
            "Texto"=>"Usuario eliminado exitosamente",
            "Tipo"=>"success"
        ];
        echo json_encode($alerta);

        /*$idPersona = mainModel::decryption($_POST['idPersona']);
        $idUsuario = mainModel::decryption($_POST['idUsuario']);

        $eliminarUsuario = usuarioModelo::eliminar_usuario_modelo($idPersona, $idUsuario);

        if($eliminarUsuario->rowCount() == 1){
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Usuario eliminado exitosamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se pudo eliminar el usuario. Intente nuevamente",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }*/
    }

    /*---------- Controlador datos usuario ----------*/
    public function datos_usuario_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return usuarioModelo::datos_usuario_modelo($tipo, $id);
    }

    /*---------- Controlador editar usuario ----------*/
    public function editar_usuario_controlador(){
        $persona = new Persona();
        $tipoDocumento = new TipoDocumento();
        //Recibiendo el ID del usuario a editar
        $persona->setIdPersona(mainModel::decryption($_POST['id_usuario_editar']));

        //Comprobar que el usuario exista en la BD
        $check_person = mainModel::ejecutar_consulta_simple("SELECT * FROM persona WHERE id = '". $persona->getIdPersona() ."'");
        if($check_person->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el usuario a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        $datos_person = $check_person->fetch();

        $persona->setIdUsuario($datos_person['id_usuario']);
        $persona->setNombre($_POST['nombre']);
        $persona->setApellido($_POST['apellido']);
        $persona->setDocumento($_POST['documento']);
        $persona->setEstado($_POST['estado']);

        $tipoDocumento->setIdTipoDocumento($_POST['tipoDocumento']);
        $persona->setTipoDocumento($tipoDocumento);

        $check_user = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE id = '". $persona->getIdUsuario() ."'");

        if($check_user->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el usuario a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_user = $check_user->fetch();

        if($persona->getNombre() == "" || $persona->getApellido() == "" || $persona->getTipoDocumento() == "" || $persona->getDocumento() == "" || $persona->getEstado() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if($_POST['clave'] != "" && $_POST['confirmarClave'] != ""){
            $persona->setClave($_POST['clave']);
            $confirmarClave = $_POST['confirmarClave'];
            if($persona->getClave() != $confirmarClave){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Las claves ingresadas no coinciden",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $persona->setClave(mainModel::encryption($persona->getClave()));
        }else{
            $persona->setClave($datos_user['clave']);
        }

        $editarPersona = usuarioModelo::editar_persona_modelo($persona);

        if(is_string($editarPersona) || $editarPersona < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo actualizar la información de la persona",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        $editarUsuario = usuarioModelo::editar_usuario_modelo($persona);
        if(is_string($editarUsuario) || $editarUsuario < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo actualizar la información del usuario",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $alerta=[
            "Alerta"=>"redireccionar",
            "Titulo"=>"Datos actualizados",
            "URL"=>SERVER_URL."adminUsuarios/",
            "Texto"=>"Los datos han sido actualizados con éxito",
            "Tipo"=>"success"
        ];
        echo json_encode($alerta);
    }

    /*---------- Controlador editar usuario ----------*/
    public function editar_perfil_controlador(){
        $persona = new Persona();
        //Recibiendo el ID del usuario a editar
        $persona->setIdPersona(mainModel::decryption($_POST['id_usuario_edit_perfil']));

        //Comprobar que el usuario exista en la BD
        $check_person = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM persona WHERE id = '". $persona->getIdPersona() ."'");
        if($check_person->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el perfil a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_person = $check_person->fetch();

        $persona->setIdUsuario($datos_person['id_usuario']);
        $persona->setNombre($_POST['nombre_edit_perfil']);
        $persona->setApellido($_POST['apellido_edit_perfil']);

        $check_user = mainModel::ejecutar_consulta_simple("SELECT clave FROM usuario WHERE id = '". $persona->getIdUsuario() ."'");

        if($check_user->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el usuario a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_user = $check_user->fetch();

        if($persona->getNombre() == "" || $persona->getApellido() == "" ){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        if($_POST['clave_edit_perfil'] != "" && $_POST['confirmarClave_edit_perfil'] != ""){
            $persona->setClave($_POST['clave_edit_perfil']);
            $confirmarClave = $_POST['confirmarClave_edit_perfil'];
            if($persona->getClave() != $confirmarClave){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Las claves ingresadas no coinciden",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $persona->setClave(mainModel::encryption($persona->getClave()));
        }else{
            $persona->setClave($datos_user['clave']);
        }

        $editarPersona = usuarioModelo::editar_persona_perfil_modelo($persona);

        if(is_string($editarPersona) || $editarPersona < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo actualizar la información de perfil",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        $editarUsuario = usuarioModelo::editar_usuario_perfil_modelo($persona);
        if(is_string($editarUsuario) || $editarUsuario < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo actualizar la contraseña",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $check_account = mainModel::ejecutar_consulta_simple("SELECT p.nombre, p.apellido 
        FROM persona p JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE p.id = '{$persona->getIdPersona()}';");

        $row = $check_account->fetch();

        session_start(['name'=>'REPO']);
        $_SESSION['nombre_usuario'] = $row['nombre'];
        $_SESSION['apellido_usuario'] = $row['apellido'];

        $alerta=[
            "Alerta"=>"recargar",
            "Titulo"=>"Datos actualizados",
            "Texto"=>"Los datos han sido actualizados con éxito",
            "Tipo"=>"success"
        ];
        echo json_encode($alerta);
    }

    /**
     * Paginador de usuarios, vista principal Admin
     *
     * @return array Lista de usuarios de la base de datos
     */
    public function paginador_usuario_controlador(){

        $consulta = "SELECT SQL_CALC_FOUND_ROWS p.id, p.nombre, p.apellido, td.descripcion as documento, p.id_usuario, u.estado, tu.descripcion 
        FROM persona p JOIN tipo_documento td ON td.id = p.id_tipo_documento JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE u.correo != 'admin.repositorioinstitucional@gmail.com' 
        ORDER BY p.nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        return $datos;
    }

}

?>