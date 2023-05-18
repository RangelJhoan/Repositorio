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
    public function agregarCursoControlador(){
        $curso = new Curso();
        $curso->setNombre(mainModel::limpiarCadena($_POST['nombre_ins']));
        $curso->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_ins']));
        $curso->setListaProgramas([]);
        $curso->setListaDocentes([]);
        $curso->setEstado(Utilidades::getIdEstado("ACTIVO"));
        if(isset($_POST['programas_ins'])){
            $curso->setListaProgramas($_POST['programas_ins']);
        }

        if(isset($_POST['docentes_ins'])){
            $curso->setListaDocentes($_POST['docentes_ins']);
        }

        $checkCurso = mainModel::ejecutar_consulta_simple("SELECT id FROM curso WHERE nombre = '{$curso->getNombre()}' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkCurso->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El curso a crear ya está registrado en el repositorio");
            exit();
        }

        if($curso->getNombre() == "" || $curso->getDescripcion() == "" || count($curso->getListaProgramas())<=0 || count($curso->getListaDocente())<=0){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $agregar_curso = cursoModelo::agregarCursoModelo($curso);

        if(is_string($agregar_curso) || $agregar_curso < 0){
            return Utilidades::getAlertaErrorJSON("simple", "Error al crear el curso " . $agregar_curso);
        }

        return Utilidades::getAlertaExitosoJSON("recargar", "Curso creado correctamente");
    }

    /*---------- Controlador para editar curso ----------*/
    public function editarCursoControlador(){
        $curso = new Curso();
        $curso->setIdCurso(mainModel::limpiarCadena(mainModel::decryption($_POST['id_curso_edit'])));

        //Comprobar que el curso exista en la BD
        $checkCurso = mainModel::ejecutar_consulta_simple("SELECT id FROM curso WHERE id = '". $curso->getIdCurso() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkCurso->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el curso a editar");
            exit();
        }

        if(!isset($_POST['programas_edit'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos");
            exit();
        }

        if(!isset($_POST['docentes_edit'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos");
            exit();
        }

        $curso->setNombre(mainModel::limpiarCadena($_POST['nombre_edit']));
        $curso->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_edit']));
        $curso->setEstado(mainModel::limpiarCadena($_POST['estado']));
        $curso->setListaProgramas($_POST['programas_edit']);
        $curso->setListaDocentes($_POST['docentes_edit']);

        $checkCurso = mainModel::ejecutar_consulta_simple("SELECT id FROM curso WHERE nombre = '{$curso->getNombre()}' AND id != {$curso->getIdCurso()} AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkCurso->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El curso ya está registrado en el repositorio");
            exit();
        }

        //Obtener los programas seleccionados (agregar nuevos y eliminar no seleccionados)
        $programasActuales = cursoModelo::idProgramasCursoModelo($curso->getIdCurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $programasAgregados = array_diff($curso->getListaProgramas(), $programasActuales);
        $programasEliminados = array_diff($programasActuales, $curso->getListaProgramas());

        //Obtener los docentes seleccionados (agregar nuevos y eliminar no seleccionados)
        $docentesActuales = cursoModelo::idDocentesCursoModelo($curso->getIdCurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $docentesAgregados = array_diff($curso->getListaDocente(), $docentesActuales);
        $docentesEliminados = array_diff($docentesActuales, $curso->getListaDocente());

        $editarCurso = cursoModelo::editarCursoModelo($curso, $programasAgregados, $programasEliminados, $docentesAgregados, $docentesEliminados);

        if($editarCurso->rowCount()>0){
            return Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-cursos/");
        }else{
            return Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información");
        }
    }

    /*---------- Controlador para eliminar curso ----------*/
    public function eliminarCursoControlador(){
        $curso = new Curso();
        $curso->setIdCurso(mainModel::limpiarCadena(mainModel::decryption($_POST['id_curso_del'])));
        $curso->setEstado(Utilidades::getIdEstado("ELIMINADO"));

        $eliminarCurso = cursoModelo::editarEstadoCursoModelo($curso);

        if(is_string($eliminarCurso) || $eliminarCurso < 0){
            return Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el curso");
        }

        return Utilidades::getAlertaExitosoJSON("recargar", "Curso eliminado exitosamente");
    }

    /**
     * Paginador de cursos, vista principal Admin
     *
     * @return Object código HTML con la lista de cursos en una tabla
     */
    public function paginadorCursoControlador($isActivo = false){
        $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
        FROM curso
        WHERE estado != ". Utilidades::getIdEstado("ELIMINADO");

        if($isActivo)
            $consulta .= " AND estado = ". Utilidades::getIdEstado("ACTIVO");

        $consulta .= " ORDER BY nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        return $datos;
    }

    /*---------- Controlador datos curso ----------*/
    public function datosCursoControlador($tipo, $id){
        $id = mainModel::decryption($id);

        return cursoModelo::datosCursoModelo($tipo, $id);
    }

    /*---------- Controlador datos curso ----------*/
    public function programasCursoControlador($id){
        return cursoModelo::programasCursoModelo($id)->fetchAll();
    }

    /*---------- Controlador docentes por curso ----------*/
    public function docentesCursoControlador($id){
        return cursoModelo::docentesCursoModelo($id)->fetchAll();
    }

    /*---------- Controlador cursos de un recurso en específico ----------*/
    public function cursosXRecursoControlador($id){
        return cursoModelo::cursosXRecursoModelo($id)->fetchAll();
    }

}

?>