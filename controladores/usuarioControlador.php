<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/usuarioModelo.php";
    require_once "../entidades/Persona.php";
    require_once "../entidades/TipoDocumento.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/usuarioModelo.php";
    require_once "./entidades/Persona.php";
    require_once "./entidades/TipoDocumento.php";
}

class usuarioControlador extends usuarioModelo{

    /*---------- Controlador para agregar usuario ----------*/
    public function agregarUsuarioControlador(){
        session_start(['name'=>'REPO']);
        //Validamos que sólo el super admin pueda crear administradores
        if($_POST['tipoUsuario'] == 1 && $_SESSION['correo_usuario'] != SUPER_ADMIN_EMAIL){
            return Utilidades::getAlertaErrorJSON("simple", "Usted no cuenta con los permisos necesarios para realizar esta acción");
        }
        $persona = new Persona();
        $persona->setNombre(mainModel::limpiarCadena($_POST['nombre']));
        $persona->setApellido(mainModel::limpiarCadena($_POST['apellido']));
        $persona->setCorreo(mainModel::limpiarCadena($_POST['correo']));
        $persona->setDocumento(mainModel::limpiarCadena($_POST['documento']));
        $persona->setClave($persona->getDocumento());
        $persona->setIdTipoUsuario(mainModel::limpiarCadena($_POST['tipoUsuario']));

        $persona->setEstado(mainModel::limpiarCadena($_POST['estado']));
        $persona->setEstadoPersona(mainModel::limpiarCadena($_POST['estado']));

        $tipoDocumento = new TipoDocumento();
        $tipoDocumento->setIdTipoDocumento(mainModel::limpiarCadena($_POST['tipoDocumento']));

        $persona->setTipoDocumento($tipoDocumento);

        if($persona->getNombre() == "" || $persona->getApellido() == "" || $persona->getCorreo() == "" || $persona->getTipoDocumento()->getIdTipoDocumento() == "" ||
            $persona->getDocumento() == "" || $persona->getClave() == "" || $persona->getIdTipoUsuario() == "" || $persona->getEstado() == ""){
                echo Utilidades::getAlertaErrorJSON("simple", "Por favor complete todos los campos requeridos");
                exit();
        }

        if(!self::validarInputsPersona($persona) || !mainModel::verificarDatos("[^@]+@[^@]+\.[a-zA-Z]{2,}", $persona->getCorreo())){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor, ingrese información válida");
            exit();
        }

        $check_documento = mainModel::ejecutar_consulta_simple("SELECT documento FROM persona WHERE documento = '".$persona->getDocumento()."';");

        if($check_documento->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El número de documento de indentidad ya se encuentra registrado en el repositorio");
            exit();
        }else{
            $persona->setClave(mainModel::encryption($persona->getClave()));
            $agregar_usuario = usuarioModelo::agregarUsuarioModelo($persona);

            if($agregar_usuario != 1){
                return Utilidades::getAlertaErrorJSON("simple", "Error al crear el usuario");
            }

            return Utilidades::getAlertaExitosoJSON("recargar", "Usuario creado correctamente");
        }
    }

    /*---------- Controlador para crear estudiante desde el loguin (registrarme) ----------*/
    public function agregarEstudianteControlador(){
        session_start(['name'=>'REPO']);
        $persona = new Persona();
        $persona->setNombre(mainModel::limpiarCadena($_POST['nombre']));
        $persona->setApellido(mainModel::limpiarCadena($_POST['apellido']));
        $persona->setCorreo(mainModel::limpiarCadena($_POST['correo_registrarme']));
        $persona->setDocumento(mainModel::limpiarCadena($_POST['documento_registrarme']));
        $persona->setClave(mainModel::limpiarCadena($_POST['clave']));
        $persona->setIdTipoUsuario(3);
        $confirmarClave = mainModel::limpiarCadena($_POST['confirmarClave']);

        $persona->setEstado(Utilidades::getIdEstado("PENDIENTE ACTIVACION"));
        $persona->setEstadoPersona(Utilidades::getIdEstado("PENDIENTE ACTIVACION"));

        $tipoDocumento = new TipoDocumento();
        $tipoDocumento->setIdTipoDocumento(mainModel::limpiarCadena($_POST['tipoDocumento']));

        $persona->setTipoDocumento($tipoDocumento);

        if($persona->getNombre() == "" || $persona->getApellido() == "" || $persona->getCorreo() == "" || $persona->getTipoDocumento()->getIdTipoDocumento() == "" ||
            $persona->getDocumento() == "" || $persona->getClave() == "" || $persona->getIdTipoUsuario() == "" || $persona->getEstado() == ""){
                echo Utilidades::getAlertaErrorJSON("simple", "Por favor complete todos los campos requeridos");
                exit();
        }

        if($persona->getClave() != $confirmarClave){
            echo Utilidades::getAlertaErrorJSON("simple", "Las contraseñas ingresadas no coinciden");
            exit();
        }

        if(!self::validarInputsPersona($persona) || !self::validarInputsUsuario($persona)){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor, ingrese información válida");
            exit();
        }

        $check_documento = mainModel::ejecutar_consulta_simple("SELECT documento FROM persona WHERE documento = '".$persona->getDocumento()."';");

        if($check_documento->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El número de documento de indentidad ya se encuentra registrado en el repositorio");
            exit();
        }else{
            $persona->setClave(mainModel::encryption($persona->getClave()));
            $agregar_usuario = usuarioModelo::agregarUsuarioModelo($persona);

            if($agregar_usuario != 1){
                echo Utilidades::getAlertaErrorJSON("simple", "Error al crear el usuario");
                exit();
            }

            echo Utilidades::getAlertaExitosoJSON("recargar", "Usuario creado correctamente");
        }
    }

    /*---------- Controlador para iniciar sesion usuario ----------*/
    public function iniciarSesionUsuarioControlador(){
        $correo = mainModel::limpiarCadena($_POST['correo']);
        $clave = mainModel::limpiarCadena($_POST['clave']);

        if($correo == "" || $clave == ""){
            return '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Por favor complete todos los campos requeridos",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
        }

        $clave = mainModel::encryption($clave);
        $check_account = mainModel::ejecutar_consulta_simple("SELECT p.id, p.nombre, p.apellido, p.documento, p.id_usuario, td.descripcion as tipoDocumento, u.correo, u.estado, tu.descripcion 
        FROM persona p JOIN tipo_documento td ON td.id = p.id_tipo_documento JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE correo = '$correo' AND clave = '$clave';");

        if($check_account->rowCount() > 0){
            $row = $check_account->fetch();
            if($row['estado'] == Utilidades::getIdEstado("INACTIVO")){
                return '<script>
                    Swal.fire({
                        title:"Error",
                        text:"Cuenta inactiva. Por favor contacte a un administrador.",
                        icon:"error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
            }

            if($row['estado'] == Utilidades::getIdEstado("PENDIENTE ACTIVACION")){
                return '<script>
                    Swal.fire({
                        title:"Error",
                        text:"Su cuenta se encuentra pendiente de activación.",
                        icon:"error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
            }

            if($row['estado'] == Utilidades::getIdEstado("ELIMINADO")){
                return '<script>
                    Swal.fire({
                        title:"Error",
                        text:"Su cuenta se encuentra eliminada. Por favor contacte a un administrador.",
                        icon:"error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
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
                return "<script>window.location.href='".SERVER_URL."admin-dashboard/';</script>";
            }elseif($row['descripcion'] == "Docente"){
                return "<script>window.location.href='".SERVER_URL."docente-dashboard/';</script>";
            }elseif($row['descripcion'] == "Estudiante"){
                return "<script>window.location.href='".SERVER_URL."estudiante-dashboard/';</script>";
            }
        }else{
            return '<script>
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
    public function forzarCierreSesionControlador(){
        session_unset();
        session_destroy();
        echo "<script>window.location.href='".SERVER_URL."login/';</script>";
    }

    /*---------- Controlador para cerrar sesión usuario ----------*/
    public function cerrarSesionControlador(){
        session_start(['name' => 'REPO']);
        $id_persona = mainModel::limpiarCadena(mainModel::decryption($_POST['id_persona']));
        $correo = mainModel::limpiarCadena(mainModel::decryption($_POST['correo_usuario']));

        if($id_persona == $_SESSION['id_persona'] && $correo == $_SESSION['correo_usuario']){
            session_unset();
            session_destroy();

            $alerta = [
                "Alerta" => "redireccionar",
                "URL" => SERVER_URL
            ];
            echo json_encode($alerta);
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo cerrar la sesión en el sistema");
        }
    }

    /*---------- Controlador para eliminar usuario ----------*/
    public function eliminarUsuarioControlador(){
        $persona = new Persona();
        $persona->setIdPersona(mainModel::limpiarCadena(mainModel::decryption($_POST['idPersona'])));
        $persona->setIdUsuario(mainModel::limpiarCadena(mainModel::decryption($_POST['idUsuario'])));
        $persona->setEstadoPersona(Utilidades::getIdEstado("ELIMINADO"));
        $persona->setEstado(Utilidades::getIdEstado("ELIMINADO"));

        $editarPersona = usuarioModelo::editarEstadoPersonaModelo($persona);

        if(is_string($editarPersona) || $editarPersona < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar la persona");
            exit();
        }

        $editarUsuario = usuarioModelo::editarEstadoUsuarioModelo($persona);

        if(is_string($editarUsuario) || $editarUsuario < 0){
            return Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el usuario");
        }

        return Utilidades::getAlertaExitosoJSON("recargar", "Usuario eliminado exitosamente");
    }

    /*---------- Controlador datos usuario ----------*/
    public function datosUsuarioControlador($tipo, $id){
        $id = mainModel::decryption($id);

        return usuarioModelo::datosUsuarioModelo($tipo, $id);
    }

    /*---------- Controlador editar usuario ----------*/
    public function editarUsuarioControlador(){
        session_start(['name'=>'REPO']);
        if($_SESSION['correo_usuario'] != SUPER_ADMIN_EMAIL && $_POST['estado'] == Utilidades::getIdEstado("ELIMINADO")){
            echo Utilidades::getAlertaErrorJSON("simple", "Usted no cuenta con los permisos necesarios para realizar esta acción");
            exit();
        }

        $persona = new Persona();
        $tipoDocumento = new TipoDocumento();
        //Recibiendo el ID del usuario a editar
        $persona->setIdPersona(mainModel::limpiarCadena(mainModel::decryption($_POST['id_usuario_editar'])));

        //Comprobar que el usuario exista en la BD
        $check_person = mainModel::ejecutar_consulta_simple("SELECT id as id_usuario FROM persona WHERE id = '". $persona->getIdPersona() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($check_person->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el usuario a editar");
            exit();
        }
        $datos_person = $check_person->fetch();

        $persona->setIdUsuario($datos_person['id_usuario']);
        $persona->setNombre(mainModel::limpiarCadena($_POST['nombre']));
        $persona->setApellido(mainModel::limpiarCadena($_POST['apellido']));
        $persona->setDocumento(mainModel::limpiarCadena($_POST['documento']));
        $persona->setEstado(mainModel::limpiarCadena($_POST['estado']));

        $tipoDocumento->setIdTipoDocumento(mainModel::limpiarCadena($_POST['tipoDocumento']));
        $persona->setTipoDocumento($tipoDocumento);

        $check_user = mainModel::ejecutar_consulta_simple("SELECT * FROM usuario WHERE id = '". $persona->getIdUsuario() ."'");

        if($check_user->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el usuario a editar");
            exit();
        }

        $datos_user = $check_user->fetch();

        if($persona->getNombre() == "" || $persona->getApellido() == "" || $persona->getTipoDocumento() == "" || $persona->getDocumento() == "" || $persona->getEstado() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor complete todos los campos requeridos");
            exit();
        }

        if($_POST['clave'] != "" && $_POST['confirmarClave'] != ""){
            $persona->setClave(mainModel::limpiarCadena($_POST['clave']));
            $confirmarClave = mainModel::limpiarCadena($_POST['confirmarClave']);
            if($persona->getClave() != $confirmarClave){
                echo Utilidades::getAlertaErrorJSON("simple", "Las contraseñas ingresadas no coinciden");
                exit();
            }
            $persona->setClave(mainModel::encryption($persona->getClave()));
        }else{
            $persona->setClave($datos_user['clave']);
        }

        $editarPersona = usuarioModelo::editarPersonaModelo($persona);

        if(is_string($editarPersona) || $editarPersona < 0){
            return Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información de la persona");
        }
        $editarUsuario = usuarioModelo::editarUsuarioModelo($persona);
        if(is_string($editarUsuario) || $editarUsuario < 0){
            return Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información del usuario");
        }

        return Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados exitosamente", SERVER_URL."admin-usuarios/");
    }

    /*---------- Controlador editar usuario ----------*/
    public function editarPerfilControlador(){
        $persona = new Persona();
        //Recibiendo el ID del usuario a editar
        $persona->setIdPersona(mainModel::limpiarCadena(mainModel::decryption($_POST['id_usuario_edit_perfil'])));

        //Comprobar que el usuario exista en la BD
        $check_person = mainModel::ejecutar_consulta_simple("SELECT id_usuario FROM persona WHERE id = '". $persona->getIdPersona() ."'");
        if($check_person->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el perfil a editar");
            exit();
        }

        $datos_person = $check_person->fetch();

        $persona->setIdUsuario($datos_person['id_usuario']);
        $persona->setNombre(mainModel::limpiarCadena($_POST['nombre_edit_perfil']));
        $persona->setApellido(mainModel::limpiarCadena($_POST['apellido_edit_perfil']));

        $check_user = mainModel::ejecutar_consulta_simple("SELECT clave FROM usuario WHERE id = '". $persona->getIdUsuario() ."'");

        if($check_user->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el usuario a editar");
            exit();
        }

        $datos_user = $check_user->fetch();

        if($persona->getNombre() == "" || $persona->getApellido() == "" ){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor complete todos los campos requeridos");
            exit();
        }

        if($_POST['clave_edit_perfil'] != "" && $_POST['confirmarClave_edit_perfil'] != ""){
            $persona->setClave(mainModel::limpiarCadena($_POST['clave_edit_perfil']));
            $confirmarClave = mainModel::limpiarCadena($_POST['confirmarClave_edit_perfil']);
            if($persona->getClave() != $confirmarClave){
                echo Utilidades::getAlertaErrorJSON("simple", "Las contraseñas ingresadas no coinciden");
                exit();
            }
            $persona->setClave(mainModel::encryption($persona->getClave()));
        }else{
            $persona->setClave($datos_user['clave']);
        }

        $editarPersona = usuarioModelo::editarPersonaPerfilModelo($persona);

        if(is_string($editarPersona) || $editarPersona < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información de perfil");
            exit();
        }
        $editarUsuario = usuarioModelo::editarUsuarioPerfilModelo($persona);
        if(is_string($editarUsuario) || $editarUsuario < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la contraseña");
            exit();
        }

        $check_account = mainModel::ejecutar_consulta_simple("SELECT p.nombre, p.apellido 
        FROM persona p JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE p.id = '{$persona->getIdPersona()}';");

        $row = $check_account->fetch();

        session_start(['name'=>'REPO']);
        $_SESSION['nombre_usuario'] = $row['nombre'];
        $_SESSION['apellido_usuario'] = $row['apellido'];

        echo Utilidades::getAlertaExitosoJSON("retroceder", "Los datos han sido actualizados exitosamente");
    }

    /**
     * Paginador de usuarios, vista principal Admin
     *
     * @return array Lista de usuarios de la base de datos
     */
    public function paginadorUsuarioControlador(){

        $consulta = "SELECT SQL_CALC_FOUND_ROWS p.id, p.nombre, p.apellido, p.documento as numeroDocumento, td.descripcion as documento, tu.descripcion as tipoUsuario, p.id_usuario, u.estado, tu.descripcion 
        FROM persona p JOIN tipo_documento td ON td.id = p.id_tipo_documento JOIN usuario u ON u.id = p.id_usuario JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE u.correo != '" . SUPER_ADMIN_EMAIL . "' and u.correo != '". $_SESSION['correo_usuario'] ."' and u.estado != ". Utilidades::getIdEstado("ELIMINADO") ." 
        ORDER BY p.nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        return $datos;
    }

    /**
     * Retorna la lista de personas de un tipo de usuario
     *
     * @return array Lista de usuarios de la base de datos
     */
    public function obtenerPersonasXTipoUsuario($tipoUsuario){

        $consulta = "SELECT p.* 
        FROM persona p 
        JOIN usuario u ON u.id = p.id_usuario 
        JOIN tipo_usuario tu ON tu.id = u.id_tipo_usuario 
        WHERE u.correo != '" . SUPER_ADMIN_EMAIL . "' and u.estado = ". Utilidades::getIdEstado("ACTIVO") ." and UPPER(tu.descripcion) = UPPER('". $tipoUsuario ."') 
        ORDER BY p.nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        return $datos;
    }

    /**
     * Envia al correo del usuario la nueva clave para autorizar el inicio de sesión
     */
    public function recuperarClaveControlador(){
        if(!isset($_POST['correo_recuperar_clave']) || $_POST['correo_recuperar_clave'] == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene la información requerida");
            exit();
        }

        $validarCorreo = mainModel::ejecutar_consulta_simple("SELECT id FROM usuario WHERE correo = '" . $_POST['correo_recuperar_clave'] . "' AND estado = " . Utilidades::getIdEstado("ACTIVO") . " AND correo != '" . SUPER_ADMIN_EMAIL . "'");
        if($validarCorreo->rowCount() < 1){
            echo Utilidades::getAlertaErrorJSON("simple", "No se ha encontrado un usuario relacionado al correo electrónico ingresado o su cuenta no está activa");
            exit();
        }

        $persona = new Persona();
        $persona->setIdUsuario($validarCorreo->fetch()['id']);
        $claveNueva = Utilidades::generarClaveAleatoria();

        $email = $_POST['correo_recuperar_clave'];
        $asunto = "Recuperación de contraseña (Repositorio Institucional)";
        $puede_contactar = "Si aún sigue teniendo problemas para ingresar a su cuenta, por favor póngase en contacto con nosotros al correo <a href='mailto:" . SUPER_ADMIN_EMAIL . "'>" . SUPER_ADMIN_EMAIL . "</a>";
        $msg = '<html>'.
        '<head>'.
        '<title>Recuperación de contraseña (Repositorio Institucional)</title>'.
        '<style>'.
            'body {'.
                'font-family: "Poppins", sans-serif;'.
                'text-align: center;'.
                'background-color: #f2f2f2;'.
                'padding: 20px;'.
            '}'.
            '.container {'.
                'max-width: 600px;'.
                'margin: 0 auto;'.
                'background-color: #fff;'.
                'padding: 20px;'.
                'border-radius: 10px;'.
            '}'.
            'h2 {'.
                'color: #506591;'.
            '}'.
            'p {'.
                'margin-bottom: 20px;'.
            '}'.
            'span {'.
                'color: #506591;'.
                'font-weight: 700;'.
                'padding-left: 10px;'.
                'font-size: 18px;'.
            '}'.
            'contact{'.
                'font-size:small;'.
                'color:gray;'.
            '}'.
            '.img-container {'.
                'margin: 0 auto;'.
                'max-width: 300px;'.
            '}'.
            'img {'.
                'width:100px;'.
            '}'.
        '</style>'.
        '</head>'.
        '<body>'.
        '<div class="container">'.
        '<h2>¡Hola! La contraseña ha sido restablecida</h2>'.
        '<p>Hemos recibido una solicitud para recuperar la contraseña de su usuario con correo ' . $email . '.</p>'.
        '<p>Su nueva contraseña es: <span>' . $claveNueva . '</span></p>'.
        '<p>Se recomienda que una vez haya ingresado a su cuenta, modifique la contraseña de forma que esta sea segura y fácil de ser recordada.</p>'.
        '<p>Muchas gracias por usar el Repositorio Institucional.</p>'.
        '<hr>'.
        '<p class="contact">' . $puede_contactar . '</p>'.
        '</div>'.
        '</body>'.
        '</html>';
        $header = "From: noreply@example.com". "\r\n";
        $header .= "Reply-To: noreply@example.com" . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-Type: text/html; charset=UTF-8\r\n";
        $mail = @mail($email, $asunto, $msg, $header);

        if(!$mail){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo realizar el envío del correo de recuperación");
            exit();
        }

        $persona->setClave(mainModel::encryption($claveNueva));
        $editarUsuario = usuarioModelo::editarUsuarioPerfilModelo($persona);
        if(is_string($editarUsuario) || $editarUsuario < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "Hubo un error inesperado al restablecer la contraseña");
            exit();
        }

        echo Utilidades::getAlertaExitosoJSON("recargar", "Contraseña restablecida. Por favor revisar el correo electrónico donde se envió la nueva clave");
    }

    /**
     * Obtiene la cantidad total de usuarios por tipo de usuario e imprime en pantalla un array con estas cantidades
     * para ser recibidas por medio de AJAX
     * 
     * @return void
     */
    public function contarCantidadUsuariosXTipo(){
        $cantidadEstudiantes = count(self::obtenerPersonasXTipoUsuario("Estudiante"));
        $cantidadDocentes = count(self::obtenerPersonasXTipoUsuario("Docente"));
        $cantidadAdmins = count(self::obtenerPersonasXTipoUsuario("Administrador"));

        $miArray = array($cantidadEstudiantes, $cantidadDocentes, $cantidadAdmins);
        echo json_encode($miArray);
    }

    // VALIDACIONES

    private function validarInputsPersona(Persona $persona){
        if(!mainModel::verificarDatos("[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}", $persona->getNombre()))
            return false;

        if(!mainModel::verificarDatos("[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}", $persona->getApellido()))
            return false;

        if(!mainModel::verificarDatos("[0-9]+", $persona->getDocumento()))
            return false;

        return true;
    }

    private function validarInputsUsuario(Persona $persona){
        if(!mainModel::verificarDatos("(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}", $persona->getClave()))
            return false;

        if(!mainModel::verificarDatos("[^@]+@[^@]+\.[a-zA-Z]{2,}", $persona->getCorreo()))
            return false;

        return true;
    }

}

?>