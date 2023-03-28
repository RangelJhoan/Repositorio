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
    public function agregar_autor_controlador(){
        $autor = new Autor();
        $autor->setNombre(mainModel::limpiarCadena($_POST['nombre_ins']));
        $autor->setApellido(mainModel::limpiarCadena($_POST['apellido_ins']));
        $autor->setEstado(Utilidades::getIdEstado("ACTIVO"));
        session_start(['name'=>'REPO']);
        $autor->setIdDocente($_SESSION['id_persona']);

        if($autor->getApellido() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $agregar_autor = autorModelo::agregar_autor_modelo($autor);

        if($agregar_autor == 1){
            echo Utilidades::getAlertaExitosoJSON("recargar", "Autor creado correctamente");
            exit();
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "Error al crear el autor");
            exit();
        }
    }

    public function eliminar_autor_controlador(){
        try {
            $autor = new Autor();
            $autor->setIdAutor(mainModel::limpiarCadena(mainModel::decryption($_POST['id_autor_del'])));
            $autor->setEstado(Utilidades::getIdEstado("ELIMINADO"));

            $eliminarAutor = autorModelo::eliminar_autor_modelo($autor);

            if(is_string($eliminarAutor) || $eliminarAutor < 0){
                echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el autor");
                exit();
            }else{
                echo Utilidades::getAlertaExitosoJSON("recargar", "Autor eliminado exitosamente");
                exit();
            }
        } catch (\Throwable $th) {
            echo Utilidades::getAlertaErrorJSON("simple", $th->getMessage());
            exit();
        }
    }

    /*---------- Controlador datos autor ----------*/
    public function datos_autor_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return autorModelo::datos_autor_modelo($tipo, $id);
    }

    /*---------- Controlador editar autor ----------*/
    public function editar_autor_controlador(){
        $autor = new autor();
        $autor->setIdAutor(mainModel::limpiarCadena(mainModel::decryption($_POST['id_autor_edit'])));

        //Comprobar que el autor exista en la BD
        $check_autor = mainModel::ejecutar_consulta_simple("SELECT * FROM autor WHERE id = '". $autor->getIdAutor() ."'");
        if($check_autor->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el autor a editar");
            exit();
        }

        $autor->setNombre(mainModel::limpiarCadena($_POST['nombre_edit']));
        $autor->setApellido(mainModel::limpiarCadena($_POST['apellido_edit']));
        $autor->setEstado(mainModel::limpiarCadena($_POST['estado']));

        if($autor->getApellido() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }
        $editarAutor = autorModelo::editar_autor_modelo($autor);

        if($editarAutor == 1){
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."adminAutores/");
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo editar el autor");
        }
    }

    /**
     * Paginador de autores, vista dentro de Recursos en panel de Admin
     *
     * @return Object Lista de los autores consultados
     */
    public function paginador_autor_controlador($idPersona){
        $consulta = "SELECT a.id, a.nombre, a.apellido, a.fecha_creacion, a.estado, p.nombre as nombreDocente, p.apellido as apellidoDocente 
        FROM autor a
        JOIN persona p ON p.id = a.id_docente
        WHERE a.estado != ". Utilidades::getIdEstado("ELIMINADO"). " ";

        if($idPersona != null)
            $consulta .= " AND id_docente = " . $idPersona;

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
    public function editar_docente_autor_controlador(){
        $autor = new autor();
        $autor->setIdAutor(mainModel::limpiarCadena(mainModel::decryption($_POST['id_autor_edit'])));

        //Comprobar que el autor exista en la BD
        $check_autor = mainModel::ejecutar_consulta_simple("SELECT * FROM autor WHERE id = '". $autor->getIdAutor() ."'");
        if($check_autor->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el autor a editar");
            exit();
        }

        $autor->setNombre(mainModel::limpiarCadena($_POST['nombre_doc_edit']));
        $autor->setApellido(mainModel::limpiarCadena($_POST['apellido_doc_edit']));
        $autor->setEstado(mainModel::limpiarCadena($_POST['estado']));

        if($autor->getApellido() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $editarAutor = autorModelo::editar_autor_modelo($autor);

        if($editarAutor == 1){
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."docenteMisAutores/");
        }else{
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo editar la información del autor");
        }
    }

}

?>