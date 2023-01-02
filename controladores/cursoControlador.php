<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/cursoModelo.php";
    require_once "../entidades/Curso.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/cursoModelo.php";
    require_once "./entidades/Curso.php";
}

class cursoControlador extends cursoModelo{

    /*---------- Controlador para agregar curso ----------*/
    public function agregar_curso_controlador(){
        $curso = new Curso();
        $curso->setNombre($_POST['nombre_ins']);
        $curso->setDescripcion($_POST['descripcion_ins']);
        $curso->setListaProgramas([]);
        if(isset($_POST['programas_ins'])){
            $curso->setListaProgramas($_POST['programas_ins']);
        }

        if($curso->getNombre() == "" || $curso->getDescripcion() == "" || count($curso->getListaProgramas())<=0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $agregar_curso = cursoModelo::agregar_curso_modelo($curso);

        if($agregar_curso->rowCount() == 1){
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Curso creado correctamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Error al crear el curso",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /*---------- Controlador para editar curso ----------*/
    public function editar_curso_controlador(){
        $idCurso = mainModel::decryption($_POST['id_curso_edit']);
        $programasNuevos = $_POST['programas_edit'];
        $programasActuales = call_user_func_array('array_merge', cursoModelo::id_programas_curso_modelo($idCurso)->fetchAll());

        $programasAgregados = array_diff($programasNuevos, $programasActuales);
        $programasEliminados = array_diff($programasActuales, $programasNuevos);

        if(count($programasAgregados)<1 && count($programasEliminados)<1){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=> "No hay cambios",
                "Texto"=>"No hay programas nuevos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

//        $editarCurso = cursoModelo::editar_curso_modelo($idCurso, $programasAgregados, $programasEliminados);

        if(true){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Exito",
                "Texto"=>"Bien",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se pudo editar el curso. Intente nuevamente",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /*---------- Controlador para eliminar curso ----------*/
    public function eliminar_curso_controlador(){
        $idCurso = mainModel::decryption($_POST['id_curso_del']);

        $eliminarCurso = cursoModelo::eliminar_curso_modelo($idCurso);

        if($eliminarCurso->rowCount() > 0){
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Curso eliminado exitosamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se pudo eliminar el curso. Intente nuevamente",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /**
     * Paginador de cursos, vista principal Admin
     *
     * @param String $pagina Numero pagina actual
     * @param String $registros Cantidad de registros a buscar
     * @param String $id ID del administrador logueado
     * @param String $url Direccion URL actual
     * @param String $busqueda Parametro de busqueda
     *
     * @return Object código HTML con la lista de cursos en una tabla
     */
    public function paginador_curso_controlador($pagina, $registros, $id, $url, $busqueda){
        $url = SERVER_URL.$url."/";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

        if(isset($busqueda) && $busqueda != ""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS cp.id_curso, cp.id_programa, c.nombre nombre_curso, c.descripcion descripcion_curso, p.nombre nombre_programa 
            FROM curso c JOIN curso_programa cp ON cp.id_curso = c.id JOIN programa p ON p.id = cp.id_programa 
            WHERE id != '$id' AND (nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%') 
            ORDER BY c.nombre ASC LIMIT $inicio,$registros";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
            FROM curso
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

    /*---------- Controlador datos curso ----------*/
    public function datos_curso_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return cursoModelo::datos_curso_modelo($tipo, $id);
    }

    /*---------- Controlador datos curso ----------*/
    public function programas_curso_controlador($id){
        return cursoModelo::programas_curso_modelo($id)->fetchAll();
    }

}

?>