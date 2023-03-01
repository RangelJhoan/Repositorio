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

        $recurso->setFecha($_POST['anioRecurso']);

        if(isset($_POST['editorial_ins'])){
            $recurso->setEditorial($_POST['editorial_ins']);
        }
        if(isset($_POST['ISBN_ins'])){
            $recurso->setIsbn($_POST['ISBN_ins']);
        }

        $recurso->setArchivo($pArchivo);

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
            $agregar_programa = recursoModelo::agregar_recurso_modelo($recurso);
            $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Exitoso",
                "Texto"=>"Recurso creado correctamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
            exit();
        }

    }

    /**
     * Paginador de recursos, vista en panel de Admin
     *
     * @return Object Lista de los recursos consultados
     */
    public function paginador_recurso_controlador(){
        $consulta = "SELECT r.id as idRecurso, r.titulo, a.nombre, r.puntos_positivos, r.puntos_negativos 
        FROM recurso r 
        JOIN archivo a ON a.id_recurso = r.id 
        ORDER BY r.id;";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

}

?>