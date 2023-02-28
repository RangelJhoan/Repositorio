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

}

?>