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
        $autor->setNombre($_POST['nombre_ins']);
        $autor->setApellido($_POST['apellido_ins']);
        $autor->setEstado(Utilidades::getIdEstado("ACTIVO"));

        if($autor->getApellido() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $agregar_autor = autorModelo::agregar_autor_modelo($autor);

        if($agregar_autor == 1){
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Autor creado correctamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Error al crear el autor",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }

    public function eliminar_autor_controlador(){
        try {
            $autor = new Autor();
            $autor->setIdAutor(mainModel::decryption($_POST['id_autor_del']));
            $autor->setEstado(Utilidades::getIdEstado("ELIMINADO"));

            $eliminarAutor = autorModelo::eliminar_autor_modelo($autor);

            if(is_string($eliminarAutor) || $eliminarAutor < 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error",
                    "Texto"=>$eliminarAutor,
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Exitoso",
                    "Texto"=>"Autor eliminado exitosamente",
                    "Tipo"=>"success"
                ];
                echo json_encode($alerta);
                exit();
            }
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

    /*---------- Controlador datos autor ----------*/
    public function datos_autor_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return autorModelo::datos_autor_modelo($tipo, $id);
    }

    /*---------- Controlador editar autor ----------*/
    public function editar_autor_controlador(){
        $autor = new autor();
        $autor->setIdAutor(mainModel::decryption($_POST['id_autor_edit']));

        //Comprobar que el autor exista en la BD
        $check_autor = mainModel::ejecutar_consulta_simple("SELECT * FROM autor WHERE id = '". $autor->getIdAutor() ."'");
        if($check_autor->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el autor a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $autor->setNombre($_POST['nombre_edit']);
        $autor->setApellido($_POST['apellido_edit']);
        $autor->setEstado($_POST['estado']);

        if($autor->getApellido() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
        $editarAutor = autorModelo::editar_autor_modelo($autor);

        if($editarAutor == 1){
            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Datos actualizados",
                "URL"=>SERVER_URL."adminAutores/",
                "Texto"=>"Los datos han sido actualizados con éxito",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>$editarAutor,
                "Tipo"=>"error"
            ];
        }
        echo json_encode($alerta);
    }

    /**
     * Paginador de autores, vista dentro de Recursos en panel de Admin
     *
     * @return Object Lista de los autores consultados
     */
    public function paginador_autor_controlador(){
        $consulta = "SELECT * 
        FROM autor 
        WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") ." 
        ORDER BY nombre ASC";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

    /*---------- Controlador datos autor ----------*/
    public function autoresXRecursoControlador($id){
        return autorModelo::autoresXRecursoModelo($id)->fetchAll();
    }

}

?>