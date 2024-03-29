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
    public function agregarProgramaControlador(){
        $programa = new Programa();
        $programa->setNombre(mainModel::limpiarCadena($_POST['nombre_ins']));
        $programa->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_ins']));
        $programa->setEstado(Utilidades::getIdEstado("ACTIVO"));

        if($programa->getNombre() == "" || $programa->getDescripcion() == ""){
            return Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
        }

        $check_programa = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE nombre = '".$programa->getNombre()."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));

        if($check_programa->rowCount() > 0){
            return Utilidades::getAlertaErrorJSON("simple", "El programa ya se encuentra registrado en el repositorio");
        }else{
            $agregar_programa = programaModelo::agregarProgramaModelo($programa);

            if($agregar_programa->rowCount() == 1){
                return Utilidades::getAlertaExitosoJSON("recargar", "Programa creado correctamente");
            }else{
                return Utilidades::getAlertaErrorJSON("simple", "Error al crear el programa");
            }
        }
    }

    public function eliminarProgramaControlador(){
        $programa = new Programa();
        $programa->setIdPrograma(mainModel::limpiarCadena(mainModel::decryption($_POST['id_programa_del'])));
        $programa->setEstado(Utilidades::getIdEstado("ELIMINADO"));

        //Comprobar que el programa exista en la BD
        $check_program = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE id = '". $programa->getIdPrograma() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($check_program->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el programa a editar");
            exit();
        }

        $editarPrograma = programaModelo::editarEstadoProgramaModelo($programa);

        if(is_string($editarPrograma) || $editarPrograma < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el programa");
            exit();
        }

        return Utilidades::getAlertaExitosoJSON("recargar", "Programa eliminado exitosamente");
    }

    /*---------- Controlador datos programa ----------*/
    public function datosProgramaControlador($tipo, $id){
        $id = mainModel::decryption($id);

        return programaModelo::datosProgramaModelo($tipo, $id);
    }

    /*---------- Controlador editar programa ----------*/
    public function editarProgramaControlador(){
        $programa = new Programa();
        //Recibiendo el ID del programa a editar
        $programa->setIdPrograma(mainModel::limpiarCadena(mainModel::decryption($_POST['id_programa_edit'])));

        //Comprobar que el programa exista en la BD
        $check_program = mainModel::ejecutar_consulta_simple("SELECT * FROM programa WHERE id = '". $programa->getIdPrograma() ."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));
        if($check_program->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el programa a editar");
            exit();
        }

        $programa->setNombre(mainModel::limpiarCadena($_POST['nombre_edit']));
        $programa->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_edit']));
        $programa->setEstado(mainModel::limpiarCadena($_POST['estado']));

        if($programa->getNombre() == "" || $programa->getDescripcion() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $check_programa = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE nombre = '".$programa->getNombre()."' and id != '".$programa->getIdPrograma()."' AND estado != " . Utilidades::getIdEstado("ELIMINADO"));

        if($check_programa->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El programa ya se encuentra registrado en el repositorio");
        }else{
            $editarPrograma = programaModelo::editarProgramaModelo($programa);
            if($editarPrograma->rowCount() > 0){
                return Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-programas/");
            }else{
                return Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información");
            }
        }
    }

    /**
     * Paginador de programas, vista principal Admin
     *
     */
    public function paginadorProgramaControlador(){
        $consulta = "SELECT * 
        FROM programa 
        WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") ." 
        ORDER BY nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        return $datos;
    }

    public function listarProgramasControlador(){
        $sql = mainModel::ejecutar_consulta_simple("SELECT * FROM programa WHERE estado = ". Utilidades::getIdEstado("ACTIVO") .";");
        return $sql->fetchAll();
    }

}

?>