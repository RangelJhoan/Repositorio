<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/programaModelo.php";
    require_once "../entidades/Programa.php";
    require_once "../utilidades/EstadosEnum.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/programaModelo.php";
    require_once "./entidades/Programa.php";
    require_once "./utilidades/EstadosEnum.php";
}

class programaControlador extends programaModelo{

    /*---------- Controlador para agregar programa ----------*/
    public function agregar_programa_controlador(){
        $programa = new Programa();
        $programa->setNombre($_POST['nombre_ins']);
        $programa->setDescripcion($_POST['descripcion_ins']);
        $programa->setEstado(EstadosEnum::ACTIVO->value);

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
        $programa = new Programa();
        $programa->setIdPrograma(mainModel::decryption($_POST['id_programa_del']));
        $programa->setEstado(EstadosEnum::ELIMINADO->value);

        $editarPrograma = programaModelo::editar_estado_programa_modelo($programa);

        if(is_string($editarPrograma) || $editarPrograma < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo eliminar el programa",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $alerta=[
            "Alerta"=>"recargar",
            "Titulo"=>"Exitoso",
            "Texto"=>"Programa eliminado exitosamente",
            "Tipo"=>"success"
        ];
        echo json_encode($alerta);
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

        $check_programa = mainModel::ejecutar_consulta_simple("SELECT id FROM programa WHERE nombre = '".$programa->getNombre()."' and id != '".$programa->getIdPrograma()."';");

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
                    "URL"=>SERVER_URL."/adminProgramas/",
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
     */
    public function paginador_programa_controlador(){
        $consulta = "SELECT * 
        FROM programa 
        WHERE estado != ". EstadosEnum::ELIMINADO->value ." 
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