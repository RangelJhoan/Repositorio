<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/programaModelo.php";
    require_once "../entidades/Programa.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/programaModelo.php";
    require_once "./entidades/Programa.php";
}

class programaControlador extends programaModelo{

    /*---------- Controlador para agregar programa ----------*/
    public function agregar_programa_controlador(){
        $programa = new Programa();
        $programa->setNombre($_POST['nombre_ins']);
        $programa->setDescripcion($_POST['descripcion_ins']);

        if($programa->getNombre() == "" || $programa->getDescripcion() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $check_programa = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE nombre = '".$programa->getNombre()."';");

        if($check_programa->rowCount() > 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"El programa ya se encuentra registrado en el repositorio",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $agregar_programa = programaModelo::agregar_programa_modelo($programa);

            if($agregar_programa->rowCount() == 1){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Exitoso",
                    "Texto"=>"Programa creado correctamente",
                    "Tipo"=>"success"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Error al crear el programa",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
        }
    }

    public function eliminar_programa_controlador(){
        $idPrograma = mainModel::decryption($_POST['id_programa_del']);

        $eliminarPrograma = programaModelo::eliminar_programa_modelo($idPrograma);

        if($eliminarPrograma->rowCount() == 1){
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Programa eliminado exitosamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se pudo eliminar el programa. Intente nuevamente",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /*---------- Controlador datos programa ----------*/
    public function datos_programa_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return programaModelo::datos_programa_modelo($tipo, $id);
    }

    /*---------- Controlador editar programa ----------*/
    public function editar_usuario_controlador(){
        $programa = new Programa();
        //Recibiendo el ID del programa a editar
        $programa->setIdPrograma(mainModel::decryption($_POST['id_programa_edit']));

        //Comprobar que el programa exista en la BD
        $check_program = mainModel::ejecutar_consulta_simple("SELECT * FROM programa WHERE id = '". $programa->getIdPrograma() ."'");
        if($check_program->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el programa a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $programa->setNombre($_POST['nombre_edit']);
        $programa->setDescripcion($_POST['descripcion_edit']);

        if($programa->getNombre() == "" || $programa->getDescripcion() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $check_programa = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE nombre = '".$programa->getNombre()."';");

        if($check_programa->rowCount() > 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"El programa ya se encuentra registrado en el repositorio",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $editarPrograma = programaModelo::editar_programa_modelo($programa);
            if($editarPrograma->rowCount() > 0){
                $alerta=[
                    "Alerta"=>"redireccionar",
                    "Titulo"=>"Datos actualizados",
                    "URL"=>"http://localhost/Repositorio/adminProgramas/",
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
    }

    /**
     * Paginador de programas, vista principal Admin
     *
     * @param String $pagina Numero pagina actual
     * @param String $registros Cantidad de registros a buscar
     * @param String $id ID del administrador logueado
     * @param String $url Direccion URL actual
     * @param String $busqueda Parametro de busqueda
     *
     * @return Object código HTML con la lista de programas en una tabla
     */
    public function paginador_programa_controlador($pagina, $registros, $id, $url, $busqueda){
        $url = SERVER_URL.$url."/";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

        if(isset($busqueda) && $busqueda != ""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
            FROM programa 
            WHERE id != '$id' AND (nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%') 
            ORDER BY nombre ASC LIMIT $inicio,$registros";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
            FROM programa 
            ORDER BY nombre ASC LIMIT $inicio,$registros";
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