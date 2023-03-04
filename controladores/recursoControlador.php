<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/recursoModelo.php";
    require_once "../entidades/Recurso.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/recursoModelo.php";
    require_once "./entidades/Recurso.php";
}

class recursoControlador extends recursoModelo{

    /*---------- Controlador para agregar programa ----------*/
    public function agregar_recurso_controlador($pArchivo){
        $recurso = new Recurso();
        $recurso->setTitulo($_POST['titulo_ins']);
        $recurso->setResumen($_POST['resumen_ins']);

        if(isset($_POST['autores_ins']))
            $recurso->setAutor($_POST['autores_ins']);

        if(isset($_POST['cursos_ins']))
            $recurso->setCurso($_POST['cursos_ins']);

        if(isset($_POST['etiquetas_ins']))
            $recurso->setEtiqueta($_POST['etiquetas_ins']);

        if(isset($_POST['link_ins']))
            $recurso->setEnlace($_POST['link_ins']);

        $recurso->setFecha($_POST['anioRecurso']);

        if(isset($_POST['editorial_ins'])){
            $recurso->setEditorial($_POST['editorial_ins']);
        }
        if(isset($_POST['ISBN_ins'])){
            $recurso->setIsbn($_POST['ISBN_ins']);
        }

        if($recurso->getTitulo() == "" || $recurso->getResumen() == "" || $recurso->getFecha() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            $agregar_recurso = recursoModelo::agregar_recurso_modelo($recurso);

            if(is_string($agregar_recurso) || $agregar_recurso < 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Error al crear el recurso",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            if($pArchivo != "null"){
                $recurso->setArchivo($pArchivo);
                $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Error al crear el archivo",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
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

}

?>