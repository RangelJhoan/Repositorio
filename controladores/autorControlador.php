<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/autorModelo.php";
    require_once "../entidades/Autor.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/autorModelo.php";
    require_once "./entidades/Autor.php";
}

class autorControlador extends autorModelo{

    /*---------- Controlador para agregar autor ----------*/
    public function agregarAutorControlador(){
        $autor = new Autor();
        $autor->setNombre(mainModel::limpiarCadena($_POST['nombre_ins']));
        $autor->setApellido(mainModel::limpiarCadena($_POST['apellido_ins']));
        $autor->setEstado(Utilidades::getIdEstado("ACTIVO"));

        $checkAutor = mainModel::ejecutar_consulta_simple("SELECT id FROM autor WHERE nombre = '{$autor->getNombre()}' AND apellido = '{$autor->getApellido()}' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkAutor->rowCount() > 0){
            return Utilidades::getAlertaErrorJSON("simple", "El autor a crear ya está registrado en el repositorio");
        }

        session_start(['name'=>'REPO']);
        $autor->setIdDocente($_SESSION['id_persona']);

        if($autor->getApellido() == ""){
            return Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
        }

        $agregar_autor = autorModelo::agregarAutorModelo($autor);

        if($agregar_autor == 1){
            return Utilidades::getAlertaExitosoJSON("recargar", "Autor creado correctamente");
        }else{
            return Utilidades::getAlertaErrorJSON("simple", "Error al crear el autor " . $agregar_autor);
        }
    }

    public function eliminarAutorControlador(){
        try {
            $autor = new Autor();
            $autor->setIdAutor(mainModel::limpiarCadena(mainModel::decryption($_POST['id_autor_del'])));
            $autor->setEstado(Utilidades::getIdEstado("ELIMINADO"));

            $eliminarAutor = autorModelo::eliminarAutorModelo($autor);

            if(is_string($eliminarAutor) || $eliminarAutor < 0){
                return Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el autor");
            }else{
                return Utilidades::getAlertaExitosoJSON("recargar", "Autor eliminado exitosamente");
            }
        } catch (\Throwable $th) {
            return Utilidades::getAlertaErrorJSON("simple", $th->getMessage());
        }
    }

    /*---------- Controlador datos autor ----------*/
    public function datosAutorControlador($tipo, $id){
        $id = mainModel::decryption($id);

        return autorModelo::datosAutorModelo($tipo, $id);
    }

    /*---------- Controlador editar autor ----------*/
    public function editarAutorControlador(){
        $autor = new autor();
        $autor->setIdAutor(mainModel::limpiarCadena(mainModel::decryption($_POST['id_autor_edit'])));

        //Comprobar que el autor exista en la BD
        $check_autor = mainModel::ejecutar_consulta_simple("SELECT * FROM autor WHERE id = '". $autor->getIdAutor() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($check_autor->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el autor a editar");
            exit();
        }

        $autor->setNombre(mainModel::limpiarCadena($_POST['nombre_edit']));
        $autor->setApellido(mainModel::limpiarCadena($_POST['apellido_edit']));
        $autor->setEstado(mainModel::limpiarCadena($_POST['estado']));

        $checkAutor = mainModel::ejecutar_consulta_simple("SELECT id FROM autor WHERE nombre = '{$autor->getNombre()}' AND apellido = '{$autor->getApellido()}' AND id != '{$autor->getIdAutor()}' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkAutor->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El autor ya está registrado en el repositorio");
            exit();
        }

        if($autor->getApellido() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }
        $editarAutor = autorModelo::editarAutorModelo($autor);

        if($editarAutor == 1){
            return Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-autores/");
        }else{
            return Utilidades::getAlertaErrorJSON("simple", "No se pudo editar el autor");
        }
    }

    /**
     * Paginador de autores, vista dentro de Recursos en panel de Admin
     *
     * @return Object Lista de los autores consultados
     */
    public function paginadorAutorControlador($idPersona, $isActivo = false){
        $consulta = "SELECT a.id, a.nombre, a.apellido, a.fecha_creacion, a.estado, p.nombre as nombreDocente, p.apellido as apellidoDocente 
        FROM autor a
        JOIN persona p ON p.id = a.id_docente
        WHERE a.estado != ". Utilidades::getIdEstado("ELIMINADO"). " ";

        if($idPersona != null)
            $consulta .= " AND id_docente = " . $idPersona;

        if($isActivo)
            $consulta .= " AND a.estado = ". Utilidades::getIdEstado("ACTIVO");

        $consulta .= " ORDER BY nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

    /*---------- Controlador datos autor ----------*/
    public function autoresXRecursoControlador($id){
        return autorModelo::autoresXRecursoModelo($id)->fetchAll();
    }

    /*---------- Controlador editar autor desde el perfil de docente ----------*/
    public function editarDocenteAutorControlador(){
        $autor = new autor();
        $autor->setIdAutor(mainModel::limpiarCadena(mainModel::decryption($_POST['id_autor_edit'])));

        //Comprobar que el autor exista en la BD
        $check_autor = mainModel::ejecutar_consulta_simple("SELECT * FROM autor WHERE id = '". $autor->getIdAutor() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($check_autor->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el autor a editar");
            exit();
        }

        $autor->setNombre(mainModel::limpiarCadena($_POST['nombre_doc_edit']));
        $autor->setApellido(mainModel::limpiarCadena($_POST['apellido_doc_edit']));
        $autor->setEstado(mainModel::limpiarCadena($_POST['estado']));

        $checkAutor = mainModel::ejecutar_consulta_simple("SELECT id FROM autor WHERE nombre = '{$autor->getNombre()}' AND apellido = '{$autor->getApellido()}' AND id != '{$autor->getIdAutor()}' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($checkAutor->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El autor ya está registrado en el repositorio");
            exit();
        }

        if($autor->getApellido() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $editarAutor = autorModelo::editarAutorModelo($autor);

        if($editarAutor == 1){
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."docente-mis-autores/");
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo editar la información del autor");
        }
    }

}

?>