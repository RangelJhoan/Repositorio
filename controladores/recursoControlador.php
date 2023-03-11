<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/recursoModelo.php";
    require_once "../entidades/Recurso.php";
    require_once "../entidades/Archivo.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/recursoModelo.php";
    require_once "./entidades/Recurso.php";
    require_once "./entidades/Archivo.php";
}

class recursoControlador extends recursoModelo{

    /*---------- Controlador para agregar programa ----------*/
    public function agregar_recurso_controlador(){
        $recurso = new Recurso();
        $recurso->setTitulo($_POST['titulo_ins']);
        $recurso->setResumen($_POST['resumen_ins']);
        $recurso->setEstado(Utilidades::getIdEstado("ACTIVO"));

        if(isset($_POST['autores_ins']))
            $recurso->setAutor($_POST['autores_ins']);

        if(isset($_POST['cursos_ins']))
            $recurso->setCurso($_POST['cursos_ins']);

        if(isset($_POST['etiquetas_ins']))
            $recurso->setEtiqueta($_POST['etiquetas_ins']);

        if(isset($_POST['link_ins']))
            $recurso->setEnlace($_POST['link_ins']);

        $recurso->setFecha($_POST['anioRecurso']);

        if($recurso->getTitulo() == "" || $recurso->getResumen() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            if(!isset($_FILES["archivo"]["name"]) && $recurso->getEnlace() == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Por favor ingrese un enlace o seleccione un archivo",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $agregar_recurso = recursoModelo::agregar_recurso_modelo($recurso);

            if(is_string($agregar_recurso) || $agregar_recurso < 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Ups! Ups! Hubo un problema al cargar el recurso. Por favor intente nuevamente.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if(isset($_FILES["archivo"]["name"])){
                $ruta = "../recursos/".$_FILES["archivo"]["name"];
                move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta);
            }else{
                $ruta = "null";
            }

            if($ruta != "null"){
                $archivo = new Archivo();

                $archivo->setRuta($ruta);
                $archivo->setTamano($_FILES["archivo"]["size"]);
                $archivo->setNombre($_FILES["archivo"]["name"]);

                if(isset($_POST['editorial_ins'])){
                    $archivo->setEditorial($_POST['editorial_ins']);
                }

                if(isset($_POST['ISBN_ins'])){
                    $archivo->setISBN($_POST['ISBN_ins']);
                }

                $archivo->setEstado(Utilidades::getIdEstado("ACTIVO"));

                $recurso->setArchivo($archivo);

                $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Ups! Hubo un problema al cargar el archivo. Por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Exitoso",
                "URL"=>SERVER_URL."adminRecursos/",
                "Texto"=>"Recurso creado correctamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
        }

    }

    /**
     * Paginador de recursos, vista en panel de Admin
     *
     * @return Object Lista de los recursos consultados
     */
    public function paginador_recurso_controlador(){
        $consulta = "SELECT r.id as idRecurso, r.titulo, r.puntos_positivos, r.puntos_negativos 
        FROM recurso r 
        ORDER BY r.id;";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

    /*---------- Controlador datos recurso ----------*/
    public function datos_recurso_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return recursoModelo::datos_recurso_modelo($tipo, $id);
    }

    /*---------- Controlador archivo por recurso ----------*/
    public function archivoXRecursoControlador($id){
        return recursoModelo::archivoXRecursoModelo($id)->fetch();
    }

    public function eliminar_recurso_controlador(){
        $recurso = new Recurso();
        $recurso->setIdRecurso(mainModel::decryption($_POST['id_recurso_del']));
        $recurso->setEstado(3);

        $eliminarRecurso = recursoModelo::editar_estado_recurso_modelo($recurso);

        if(is_string($eliminarRecurso) || $eliminarRecurso < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo eliminar el recurso",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $alerta=[
            "Alerta"=>"recargar",
            "Titulo"=>"Exitoso",
            "Texto"=>"Recurso eliminado exitosamente",
            "Tipo"=>"success"
        ];
        echo json_encode($alerta);

    }

}

?>