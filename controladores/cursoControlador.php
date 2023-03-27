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
        $curso->setEstado(Utilidades::getIdEstado("ACTIVO"));
        if(isset($_POST['programas_ins'])){
            $curso->setListaProgramas($_POST['programas_ins']);
        }

        if(isset($_POST['docentes_ins'])){
            $curso->setListaDocentes($_POST['docentes_ins']);
        }

        if($curso->getNombre() == "" || $curso->getDescripcion() == "" || count($curso->getListaProgramas())<=0){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $agregar_curso = cursoModelo::agregar_curso_modelo($curso);

        if($agregar_curso->rowCount() == 1){
            echo Utilidades::getAlertaExitosoJSON("recargar", "Curso creado correctamente");
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "Error al crear el curso");
        }
    }

    /*---------- Controlador para editar curso ----------*/
    public function editar_curso_controlador(){
        if(!isset($_POST['programas_edit'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos");
            exit();
        }

        if(!isset($_POST['docentes_edit'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos");
            exit();
        }

        $curso = new Curso();
        $curso->setIdCurso(mainModel::decryption($_POST['id_curso_edit']));
        $curso->setNombre($_POST['nombre_edit']);
        $curso->setDescripcion($_POST['descripcion_edit']);
        $curso->setEstado($_POST['estado']);
        $curso->setListaProgramas($_POST['programas_edit']);
        $curso->setListaDocentes($_POST['docentes_edit']);

        //Obtener los programas seleccionados (agregar nuevos y eliminar no seleccionados)
        $programasActuales = cursoModelo::id_programas_curso_modelo($curso->getIdCurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $programasAgregados = array_diff($curso->getListaProgramas(), $programasActuales);
        $programasEliminados = array_diff($programasActuales, $curso->getListaProgramas());

        //Obtener los docentes seleccionados (agregar nuevos y eliminar no seleccionados)
        $docentesActuales = cursoModelo::id_docentes_curso_modelo($curso->getIdCurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $docentesAgregados = array_diff($curso->getListaDocente(), $docentesActuales);
        $docentesEliminados = array_diff($docentesActuales, $curso->getListaDocente());

        $editarCurso = cursoModelo::editar_curso_modelo($curso, $programasAgregados, $programasEliminados, $docentesAgregados, $docentesEliminados);

        if($editarCurso->rowCount()>0){
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."adminCursos/");
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información");
        }
    }

    /*---------- Controlador para eliminar curso ----------*/
    public function eliminar_curso_controlador(){
        $curso = new Curso();
        $curso->setIdCurso(mainModel::decryption($_POST['id_curso_del']));
        $curso->setEstado(Utilidades::getIdEstado("ELIMINADO"));

        $eliminarCurso = cursoModelo::editar_estado_curso_modelo($curso);

        if(is_string($eliminarCurso) || $eliminarCurso < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el curso");
            exit();
        }

        echo Utilidades::getAlertaExitosoJSON("recargar", "Curso eliminado exitosamente");
    }

    /**
     * Paginador de cursos, vista principal Admin
     *
     * @return Object código HTML con la lista de cursos en una tabla
     */
    public function paginador_curso_controlador(){
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
        FROM curso
        WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") ." 
        ORDER BY nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        return $datos;
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

    /*---------- Controlador docentes por curso ----------*/
    public function docentes_curso_controlador($id){
        return cursoModelo::docentes_curso_modelo($id)->fetchAll();
    }

    /*---------- Controlador cursos de un recurso en específico ----------*/
    public function cursosXRecursoControlador($id){
        return cursoModelo::cursosXRecursoModelo($id)->fetchAll();
    }

}

?>