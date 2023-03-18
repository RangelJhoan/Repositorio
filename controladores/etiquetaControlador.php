<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/etiquetaModelo.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/etiquetaModelo.php";
}

class etiquetaControlador extends etiquetaModelo{

    public function agregar_etiqueta_controlador(){
        $etiqueta = new Etiqueta();
        $etiqueta->setDescripcion($_POST['descripcion_ins']);
        $etiqueta->setEstado(Utilidades::getIdEstado("ACTIVO"));
        session_start(['name'=>'REPO']);
        $etiqueta->setIdDocente($_SESSION['id_persona']);

        if($etiqueta->getDescripcion() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $agregar_etiqueta = etiquetaModelo::agregar_etiqueta_modelo($etiqueta);

        if(is_string($agregar_etiqueta) || $agregar_etiqueta < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Error al crear la etiqueta",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $alerta=[
            "Alerta"=>"recargar",
            "Titulo"=>"Exitoso",
            "Texto"=>"Etiqueta creada correctamente",
            "Tipo"=>"success"
        ];
        echo json_encode($alerta);
        exit();
    }

    /*---------- Controlador editar etiqueta ----------*/
    public function editar_etiqueta_controlador(){
        $etiqueta = new Etiqueta();
        $etiqueta->setIdEtiqueta(mainModel::decryption($_POST['id_etiqueta_edit']));

        //Comprobar que la etiqueta exista en la BD
        $check_etiqueta = mainModel::ejecutar_consulta_simple("SELECT * FROM etiqueta WHERE id = '". $etiqueta->getIdEtiqueta() ."'");

        if($check_etiqueta->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró la etiqueta a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $etiqueta->setDescripcion($_POST['descripcion_edit']);
        $etiqueta->setEstado($_POST['estado']);

        if($etiqueta->getDescripcion() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        $editarEtiqueta = etiquetaModelo::editar_etiqueta_modelo($etiqueta);

        if($editarEtiqueta == 1){
            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Datos actualizados",
                "URL"=>SERVER_URL."panelPalabrasClave/",
                "Texto"=>"Los datos han sido actualizados con éxito",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>$editarEtiqueta,
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

    public function eliminar_etiqueta_controlador(){
        try {
            $autor = new Etiqueta();
            $autor->setIdEtiqueta(mainModel::decryption($_POST['id_etiqueta_del']));
            $autor->setEstado(Utilidades::getIdEstado("ELIMINADO"));

            $eliminarEtiqueta = etiquetaModelo::eliminar_etiqueta_modelo($autor);

            if(is_string($eliminarEtiqueta) || $eliminarEtiqueta < 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error",
                    "Texto"=>$eliminarEtiqueta,
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Etiqueta eliminada exitosamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        } catch (\Throwable $th) {
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>$th->getMessage(),
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /*---------- Controlador datos etiqueta ----------*/
    public function datos_etiqueta_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return etiquetaModelo::datos_etiqueta_modelo($tipo, $id);
    }

    /**
     * Paginador de etiquetas, vista dentro de Etiqueta en panel de Recursos de Admin
     *
     * @return Object Lista de las etiquetas consultadas
     */
    public function paginador_etiqueta_controlador($idPersona){
        $consulta = "SELECT e.id as idEtiqueta, e.descripcion, e.estado as estadoEtiqueta, e.fecha_creacion as fechaCreacionEtiqueta, p.nombre, p.apellido 
        FROM etiqueta e
        JOIN persona p ON p.id = e.id_docente
        WHERE e.estado != ". Utilidades::getIdEstado("ELIMINADO") ." ";

        if($idPersona != null)
            $consulta .= " AND id_docente = " . $idPersona;

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
    public function editar_docente_etiqueta_controlador(){
        $etiqueta = new Etiqueta();
        $etiqueta->setIdEtiqueta(mainModel::decryption($_POST['id_docente_etiqueta_edit']));

        //Comprobar que la etiqueta exista en la BD
        $check_etiqueta = mainModel::ejecutar_consulta_simple("SELECT * FROM etiqueta WHERE id = '". $etiqueta->getIdEtiqueta() ."'");

        if($check_etiqueta->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró la etiqueta a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $etiqueta->setDescripcion($_POST['descripcion_docente_edit']);
        $etiqueta->setEstado($_POST['estado']);

        if($etiqueta->getDescripcion() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        $editarEtiqueta = etiquetaModelo::editar_etiqueta_modelo($etiqueta);

        if($editarEtiqueta == 1){
            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Datos actualizados",
                "URL"=>SERVER_URL."docenteMisPalabrasClave/",
                "Texto"=>"Los datos han sido actualizados con éxito",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>$editarEtiqueta,
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
    }
}

?>