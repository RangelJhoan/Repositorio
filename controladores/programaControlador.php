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
        $programa->setNombre(mainModel::limpiarCadena($_POST['nombre_ins']));
        $programa->setDescripcion(mainModel::limpiarCadena($_POST['descripcion_ins']));
        $programa->setEstado(Utilidades::getIdEstado("ACTIVO"));

        if($programa->getNombre() == "" || $programa->getDescripcion() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }

        $check_programa = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE nombre = '".$programa->getNombre()."';");

        if($check_programa->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El programa ya se encuentra registrado en el repositorio");
            exit();
        }else{
            $agregar_programa = programaModelo::agregar_programa_modelo($programa);

            if($agregar_programa->rowCount() == 1){
                echo Utilidades::getAlertaExitosoJSON("recargar", "Programa creado correctamente");
                exit();
            }else{
                echo Utilidades::getAlertaErrorJSON("simple", "Error al crear el programa");
                exit();
            }
        }
    }

    public function eliminar_programa_controlador(){
        $programa = new Programa();
        $programa->setIdPrograma(mainModel::limpiarCadena(mainModel::decryption($_POST['id_programa_del'])));
        $programa->setEstado(Utilidades::getIdEstado("ELIMINADO"));

        $editarPrograma = programaModelo::editar_estado_programa_modelo($programa);

        if(is_string($editarPrograma) || $editarPrograma < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el programa");
            exit();
        }

        echo Utilidades::getAlertaExitosoJSON("recargar", "Programa eliminado exitosamente");
    }

    /*---------- Controlador datos programa ----------*/
    public function datos_programa_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return programaModelo::datos_programa_modelo($tipo, $id);
    }

    /*---------- Controlador editar programa ----------*/
    public function editar_programa_controlador(){
        $programa = new Programa();
        //Recibiendo el ID del programa a editar
        $programa->setIdPrograma(mainModel::limpiarCadena(mainModel::decryption($_POST['id_programa_edit'])));

        //Comprobar que el programa exista en la BD
        $check_program = mainModel::ejecutar_consulta_simple("SELECT * FROM programa WHERE id = '". $programa->getIdPrograma() ."'");
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

        $check_programa = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE nombre = '".$programa->getNombre()."' and id != '".$programa->getIdPrograma()."';");

        if($check_programa->rowCount() > 0){
            echo Utilidades::getAlertaErrorJSON("simple", "El programa ya se encuentra registrado en el repositorio");
            exit();
        }else{
            $editarPrograma = programaModelo::editar_programa_modelo($programa);
            if($editarPrograma->rowCount() > 0){
                echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."adminProgramas/");
            }else{
                echo Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información");
            }
        }
    }

    /**
     * Paginador de programas, vista principal Admin
     *
     */
    public function paginador_programa_controlador(){
        $consulta = "SELECT * 
        FROM programa 
        WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") ." 
        ORDER BY nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();

        return $datos;
    }

    public function listar_programas_controlador(){
        $sql = mainModel::ejecutar_consulta_simple("SELECT * FROM programa;");
        return $sql->fetchAll();
    }

}

?>