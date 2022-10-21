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

        $check_documento = mainModel::ejecutar_consulta_simple("SELECT documento FROM persona WHERE documento = '$documento';");

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

            $datos_usuario_reg = [
                "tipoDocumento" => $tipoDocumento,
                "documento" => $documento,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "correo" => $correo,
                "clave" => $clave,
                "idTipoUsuario" => 3
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
                        text: "Por favor llene todos los campos requeridos",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
            exit();
        }

        $check_documento = mainModel::ejecutar_consulta_simple("SELECT documento FROM persona WHERE documento = '$documento';");

        if($check_documento->rowCount() > 0){
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Documento de indentidad ya se encuentra registrado en el repositorio",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
        }else{
            $datos_usuario_reg = [
                "tipoDocumento" => $tipoDocumento,
                "documento" => $documento,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "correo" => $correo,
                "clave" => $clave,
                "idTipoUsuario" => 3
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

    /*---------- Controlador enlistar usuarios ----------*/
    public function paginador_usuario_controlador($pagina, $registros, $id, $url, $busqueda){
        $url = SERVER_URL.$url."/";
        $tabla = "";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

        if(isset($busqueda) && $busqueda != ""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE id != '$id' AND (documento LIKE '%$busqueda%' OR nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%') ORDER BY documento ASC LIMIT $inicio,$registros";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * FROM persona WHERE id != '$id' ORDER BY nombre ASC LIMIT $inicio,$registros";
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
                $tabla.='<tr>
                            <td data-titulo="#">'.$contador.'</td>
                            <td data-titulo="NOMBRE">'.$rows['nombre'].' '.$rows['apellido'].'</td>
                            <td data-titulo="DOCUMENTO">'.$rows['documento'].'</td>
                            <td data-titulo="TIPO">Estudiante</td>
                            <td data-titulo="ESTADO"><span class="active"></span></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                        </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                        </div>
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