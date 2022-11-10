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
        $programa->setNombre($_POST['nombre']);
        $programa->setDescripcion($_POST['descripcion']);

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

    public function eliminar_programa_controlador(){
        $idPrograma = mainModel::decryption($_POST['idPrograma']);

        $eliminarPrograma = programaModelo::eliminar_programa_modelo($idPrograma);

        if($eliminarPrograma->rowCount() == 1){
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Programa eliminado exitosamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se pudo eliminar el programa. Intente nuevamente",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    /**
     * Paginador de programas, vista principal Admin
     *
     * @param String $pagina Numero pagina actual
     * @param String $registros Cantidad de registros a buscar
     * @param String $id ID del administrador logueado
     * @param String $url Direccion URL actual
     * @param String $busqueda Parametro de busqueda
     *
     * @return Object código HTML con la lista de programas en una tabla
     */
    public function paginador_programa_controlador($pagina, $registros, $id, $url, $busqueda){
        $url = SERVER_URL.$url."/";
        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

        if(isset($busqueda) && $busqueda != ""){
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
            FROM programa 
            WHERE id != '$id' AND (nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%') 
            ORDER BY nombre ASC LIMIT $inicio,$registros";
        }else{
            $consulta = "SELECT SQL_CALC_FOUND_ROWS * 
            FROM programa 
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

}

?>