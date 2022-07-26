<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/usuarioModelo.php";
    require_once "../entidades/Persona.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/usuarioModelo.php";
    require_once "./entidades/Persona.php";
}

class usuarioControlador extends usuarioModelo{

    /*---------- Controlador para agregar usuario ----------*/
    public function agregar_usuario_controlador(){
        $persona = new Persona();
        $persona->setNombre($_POST['nombre']);
        $persona->setApellido($_POST['apellido']);
        $persona->setCorreo($_POST['correo']);
        $persona->setTipoDocumento($_POST['tipoDocumento']);
        $persona->setDocumento($_POST['documento']);
        $persona->setClave($_POST['clave']);
        $persona->setIdTipoUsuario($_POST['tipoUsuario']);
        $persona->setEstado($_POST['estado']);
        $confirmarClave = $_POST['confirmarClave'];


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

            if($agregar_usuario->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Exitoso",
                    "Texto"=>"Usuario creado correctamente",
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
        $check_account = mainModel::ejecutar_consulta_simple("SELECT p.id, p.nombre, p.apellido, p.documento, p.id_usuario, u.correo, u.estado, tu.descripcion 
        FROM persona p JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE correo = '$correo' AND clave = '$clave' AND estado = '1';");

        if($check_account->rowCount() > 0){
            $row = $check_account->fetch();

            session_start(['name'=>'REPO']);
            $_SESSION['id_persona'] = $row['id'];
            $_SESSION['nombre_usuario'] = $row['nombre'];
            $_SESSION['apellido_usuario'] = $row['apellido'];
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

    /*---------- Controlador para eliminar usuario ----------*/
    public function eliminar_usuario_controlador(){
        $idPersona = mainModel::decryption($_POST['idPersona']);
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
        }
    }

    /*---------- Controlador datos usuario ----------*/
    public function datos_usuario_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return usuarioModelo::datos_usuario_modelo($tipo, $id);
    }

    /*---------- Controlador editar usuario ----------*/
    public function editar_usuario_controlador(){
        $persona = new Persona();
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
        $persona->setTipoDocumento($_POST['tipoDocumento']);
        $persona->setDocumento($_POST['documento']);
        $persona->setEstado($_POST['estado']);

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
        $editarUsuario = usuarioModelo::editar_usuario_modelo($persona);
        if($editarPersona->rowCount() > 0 || $editarUsuario->rowCount() > 0){
            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Datos actualizados",
                "URL"=>"http://localhost/Repositorio/adminUsuarios/",
                "Texto"=>"Los datos han sido actualizados con éxito",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo actualizar la información",
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

    /**
     * Paginador de usuarios, vista principal Admin
     *
     * @param String $pagina Numero pagina actual
     * @param String $registros Cantidad de registros a buscar
     * @param String $id ID del administrador logueado
     * @param String $url Direccion URL actual
     * @param String $busqueda Parametro de busqueda
     *
     * @return Object código HTML con la lista de usuarios en una tabla
     */
    public function paginador_usuario_controlador($pagina, $registros, $id, $url, $busqueda){
        $url = SERVER_URL.$url."/";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

        if(isset($busqueda) && $busqueda != ""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS p.id, p.nombre, p.apellido, p.documento, p.tipo_documento, p.id_usuario, u.estado, tu.descripcion 
            FROM persona p JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
            WHERE p.id != '$id' AND (p.documento LIKE '%$busqueda%' OR p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%') 
            ORDER BY p.nombre ASC LIMIT $inicio,$registros";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS p.id, p.nombre, p.apellido, p.documento, p.tipo_documento, p.id_usuario, u.estado, tu.descripcion 
            FROM persona p JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
            WHERE p.id != '$id' 
            ORDER BY p.nombre ASC LIMIT $inicio,$registros";
        }

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total/$registros);

        if($total >= 1 && $pagina <= $Npaginas){
            return $datos;
        }else{
            return 0;
        }
    }

}

?>