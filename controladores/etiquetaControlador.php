<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/etiquetaModelo.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/etiquetaModelo.php";
}

class etiquetaControlador extends etiquetaModelo{

    public function agregarEtiquetaControlador(){
        $etiqueta = new Etiqueta();
        $etiqueta->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_ins']));
        $etiqueta->setEstado(Utilidades::getIdEstado("ACTIVO"));
        session_start(['name'=>'REPO']);
        $etiqueta->setIdDocente($_SESSION['id_persona']);

        $checkEtiqueta = mainModel::ejecutar_consulta_simple("SELECT id FROM etiqueta WHERE descripcion = '{$etiqueta->getDescripcion()}' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkEtiqueta->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "La palabra clave a crear ya está registrada en el repositorio");
            exit();
        }

        if($etiqueta->getDescripcion() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $agregar_etiqueta = etiquetaModelo::agregarEtiquetaModelo($etiqueta);

        if(is_string($agregar_etiqueta) || $agregar_etiqueta < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "Error al crear la etiqueta");
            exit();
        }

        echo Utilidades::getAlertaExitosoJSON("recargar", "Etiqueta creada correctamente");
    }

    /*---------- Controlador editar etiqueta ----------*/
    public function editarEtiquetaControlador(){
        $etiqueta = new Etiqueta();
        $etiqueta->setIdEtiqueta(mainModel::limpiarCadena(mainModel::decryption($_POST['id_etiqueta_edit'])));

        //Comprobar que la etiqueta exista en la BD
        $check_etiqueta = mainModel::ejecutar_consulta_simple("SELECT * FROM etiqueta WHERE id = '". $etiqueta->getIdEtiqueta() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($check_etiqueta->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró la etiqueta a editar");
            exit();
        }

        $etiqueta->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_edit']));
        $etiqueta->setEstado(mainModel::limpiarCadena($_POST['estado']));

        $checkEtiqueta = mainModel::ejecutar_consulta_simple("SELECT id FROM etiqueta WHERE descripcion = '{$etiqueta->getDescripcion()}' AND id != {$etiqueta->getIdEtiqueta()} AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkEtiqueta->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "La palabra clave ya está registrada en el repositorio");
            exit();
        }

        if($etiqueta->getDescripcion() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }
        $editarEtiqueta = etiquetaModelo::editarEtiquetaModelo($etiqueta);

        if($editarEtiqueta == 1){
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."panel-palabras-clave/");
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo editar la información de la etiqueta");
        }
    }

    public function eliminarEtiquetaControlador(){
        try {
            $etiqueta = new Etiqueta();
            $etiqueta->setIdEtiqueta(mainModel::limpiarCadena(mainModel::decryption($_POST['id_etiqueta_del'])));
            $etiqueta->setEstado(Utilidades::getIdEstado("ELIMINADO"));

            $eliminarEtiqueta = etiquetaModelo::eliminarEtiquetaModelo($etiqueta);

            if(is_string($eliminarEtiqueta) || $eliminarEtiqueta < 0){
                echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar la palabra clave");
                exit();
            }

            echo Utilidades::getAlertaExitosoJSON("recargar", "Etiqueta eliminada exitosamente");
        } catch (\Throwable $th) {
            echo Utilidades::getAlertaErrorJSON("simple", $th->getMessage());
            exit();
        }
    }

    /*---------- Controlador datos etiqueta ----------*/
    public function datosEtiquetaControlador($tipo, $id){
        $id = mainModel::decryption($id);

        return etiquetaModelo::datosEtiquetaModelo($tipo, $id);
    }

    /**
     * Paginador de etiquetas, vista dentro de Etiqueta en panel de Recursos de Admin
     *
     * @return Object Lista de las etiquetas consultadas
     */
    public function paginadorEtiquetaControlador($idPersona, $isActivo = false){
        $consulta = "SELECT e.id as idEtiqueta, e.descripcion, e.estado as estadoEtiqueta, e.fecha_creacion as fechaCreacionEtiqueta, p.nombre, p.apellido 
        FROM etiqueta e
        JOIN persona p ON p.id = e.id_docente
        WHERE e.estado != ". Utilidades::getIdEstado("ELIMINADO") ." ";

        if($idPersona != null)
            $consulta .= " AND id_docente = " . $idPersona;

        if($isActivo)
            $consulta .= " AND e.estado = " . Utilidades::getIdEstado("ACTIVO");

        $consulta .= " ORDER BY descripcion ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

    /*---------- Controlador etiquetas de un recurso en específico ----------*/
    public function etiquetasXRecursoControlador($id){
        return etiquetaModelo::etiquetasXRecursoModelo($id)->fetchAll();
    }

    /*---------- Controlador editar etiqueta desde el perfil del docente ----------*/
    public function editarDocenteEtiquetaControlador(){
        $etiqueta = new Etiqueta();
        $etiqueta->setIdEtiqueta(mainModel::limpiarCadena(mainModel::decryption($_POST['id_docente_etiqueta_edit'])));

        //Comprobar que la etiqueta exista en la BD
        $check_etiqueta = mainModel::ejecutar_consulta_simple("SELECT * FROM etiqueta WHERE id = '". $etiqueta->getIdEtiqueta() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($check_etiqueta->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró la etiqueta a editar");
            exit();
        }

        $etiqueta->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_docente_edit']));
        $etiqueta->setEstado(mainModel::limpiarCadena($_POST['estado']));

        $checkEtiqueta = mainModel::ejecutar_consulta_simple("SELECT id FROM etiqueta WHERE descripcion = '{$etiqueta->getDescripcion()}' AND id != {$etiqueta->getIdEtiqueta()} AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkEtiqueta->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "La palabra clave ya está registrado en el repositorio");
            exit();
        }

        if($etiqueta->getDescripcion() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }
        $editarEtiqueta = etiquetaModelo::editarEtiquetaModelo($etiqueta);

        if($editarEtiqueta == 1){
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."docente-mis-palabras-clave/");
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información de la palabra clave");
        }
    }
}

?>