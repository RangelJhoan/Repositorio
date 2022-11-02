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


        if($persona->getNombre() == "" || $persona->getApellido() == "" || $persona->getCorreo() == "" || $persona->getTipoDocumento() == "" || $persona->getDocumento() == "" || $persona->getEstado() == ""){
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
    }

    /*---------- Controlador para agregar usuario ----------*/
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
        $check_account = mainModel::ejecutar_consulta_simple("SELECT correo FROM usuario WHERE correo = '$correo' && clave = '$clave';");

        if($check_account->rowCount() > 0){
            echo "<script>window.location.href='".SERVER_URL."adminDashboard/';</script>";
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

    /*---------- Controlador enlistar usuarios ----------*/
    public function paginador_usuario_controlador($pagina, $registros, $id, $url, $busqueda){
        $url = SERVER_URL.$url."/";
        $tabla = "";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

        if(isset($busqueda) && $busqueda != ""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona p JOIN usuario u ON u.id = p.id_usuario WHERE p.id != '$id' AND (p.documento LIKE '%$busqueda%' OR p.nombre LIKE '%$busqueda%' OR p.apellido LIKE '%$busqueda%') ORDER BY p.documento ASC LIMIT $inicio,$registros";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona p JOIN usuario u ON u.id = p.id_usuario WHERE p.id != '$id' ORDER BY p.nombre ASC LIMIT $inicio,$registros";
        }

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $Npaginas = ceil($total/$registros);

        $tabla .= '<div class="tablaUsuariosContainer">
                    <!-- <table id="tablaUsuarios" class="table table-striped display responsive nowrap" style="width:100%"> -->
                    <table id="tablaUsuarios" class="tbUsuarios" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Documento</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>';

        if($total >= 1 && $pagina <= $Npaginas){
            $contador = $inicio+1;
            foreach($datos as $rows){
                $estado = "";
                if($rows['estado'] == "0"){
                    $estado = "inactive";
                }else{
                    $estado = "active";
                }
                $tabla.='<tr>
                            <td data-titulo="#">'.$contador.'</td>
                            <td data-titulo="NOMBRE">'.$rows['nombre'].' '.$rows['apellido'].'</td>
                            <td data-titulo="DOCUMENTO">'.$rows['documento'].'</td>
                            <td data-titulo="TIPO">Estudiante</td>
                            <td data-titulo="ESTADO"><span class="'.$estado.'"></span></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <label for="btn-modal-editar-usuario" class="btn-editar-usuario"><i class="uil uil-edit"></i></label>
                                    </div>
                                    <form class="FormularioAjax" action="'.SERVER_URL.'ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="idPersona" value="'.mainModel::encryption($rows['id']).'">
                                            <input type="hidden" name="idUsuario" value="'.mainModel::encryption($rows['id_usuario']).'">
                                            <button type="submit" class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>';
                        $contador++;
            }
        }else{
            $tabla.='<tr><td colspan="6">No hay registros en la base de datos</td></tr>';
        }

        $tabla .= '</tbody></table></div>';

        return $tabla;

    }

}

?>