<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/homeModelo.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/homeModelo.php";
}

class homeControlador extends homeModelo{

    public function listadoFiltroRecursos($pTipo, $pBuscar){
        $listado = homeModelo::filtrarRecursos($pTipo, $pBuscar);
        return $listado->fetchAll();
    }

    public function cargarInformacionRecurso($pId){
        $informacion = homeModelo::cargarAutores($pId);
        $autores = "";
        foreach ($informacion AS $key => $autor){
            $separador = ($key == count($informacion) - 1) ? "" : "; ";
            $autores .= $autor['apellido'].", ".$autor['nombre'].$separador;
        }
        return $autores;
    }

    public function cargarBusqueda($pBusqueda){
        $search = "";
        $arrayParametro = explode("¡", $pBusqueda);
        $prueba = "";
        foreach($arrayParametro AS $dato){
            $varDato = mainModel::decryption($dato);
            if(strpos($varDato, '~~') == ""){
                if($search!=""){
                    $search .= " ";
                }
            }
            $search .= $varDato;
        }
        return str_replace("~~","",$search);
    }

    public function cargarRecursosAutor($pId){
        $recursos = homeModelo::cargarRecursos($pId);
        return $recursos;
    }

    public function cargarRecursosCurso($pId){
        $recursos = homeModelo::cargarCurso($pId);
        return $recursos;
    }

    public function capturarFechaRecurso(){
        $fechas = homeModelo::fechasRecurso();
        return $fechas;
    }

    public function buscarInfoRecurso($pId){
        $informacion = homeModelo::detallesRecurso(mainModel::decryption($pId));
        return $informacion;
    }

    public function autoresRecurso($pId){
        $informacion = homeModelo::cargarAutores($pId);
        return $informacion;
    }

    public function cursoRecurso($pId){
        $informacion = homeModelo::cursosRecurso($pId);
        return $informacion;
    }

    public function etiquetasRecurso($pId){
        $informacion = homeModelo::cargarEtiquetas($pId);
        return $informacion;
    }

    public function archivoRecurso($pId){
        $informacion = homeModelo::cargarArchivos($pId);
        return $informacion;
    }

    public function calificarRecurso(){
        if(!isset($_POST['respuestaFeedback'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor seleccione una opción");
            exit();
        }

        $pId = $_POST['codrecurso'];
        $pRespuesta = $_POST['respuestaFeedback'];

        session_start(['name'=>"REPO"]);
        if(isset($_SESSION['id_persona']) && ($_SESSION['tipo_usuario']=="Estudiante" || $_SESSION['tipo_usuario']=="Docente")){
            $validar = homeModelo::validarRegistroVoto($pId);
            if(isset($validar['id'])){
                $valorar = homeModelo::editarVoto($validar['id'],$pRespuesta);
                if($valorar>0){
                    $registrar = homeModelo::quitarPunto($pId, $pRespuesta);
                    $valorar = homeModelo::evaluarRecurso($pId, $pRespuesta);
                }
            }else{
                $valorar = homeModelo::evaluarRecurso($pId, $pRespuesta);
                $registrar = homeModelo::registrarVoto($pId, $pRespuesta);
            }
            if(is_string($valorar)){
                echo Utilidades::getAlertaErrorJSON("simple", "Error: ".$valorar);
                exit();
            }else{
                echo Utilidades::getAlertaExitosoJSON("recargar", "Gracias por evaluar el recurso y ayudar a mejorar su calidad. Su retroalimentación es muy valiosa y nos ayudará a identificar áreas de oportunidad para seguir mejorando y ofrecer recursos de gran utilidad.");
            }
        }else{
            echo Utilidades::getAlertaErrorJSON("recargar", "Usted no cuenta con los permisos para calificar el recurso.");
            exit();
        }
    }

    public function buscarRutaArchivo($pId){
        $informacion = homeModelo::rutaArchivo($pId);
        return $informacion;
    }

    public function agregarFavorito($pId){
        session_start(['name'=>"REPO"]);
        if(isset($_SESSION['id_persona']) && $_SESSION['tipo_usuario']=="Estudiante"){
            $validar = homeModelo::validarFavorito($pId);
            if(!isset($validar['id'])){
                $favorito = homeModelo::registrarFavorito($pId);
                $textoalert = "Recurso Agregado a Favoritos";
            }else{
                $favorito = homeModelo::eliminarFavorito($validar['id']);
                $textoalert = "Recurso Eliminado de Favoritos";
            }

            if(is_string($favorito)){
                echo Utilidades::getAlertaErrorJSON("simple", "Error: ".$favorito);
                exit();
            }else{
                echo Utilidades::getAlertaExitosoJSON("recargar", $textoalert);
            }
        }else{
            echo Utilidades::getAlertaErrorJSON("recargar", "Usted no cuenta con los permisos para agregar a favoritos este recurso.");
        }
    }

    /**
     * Consulta la lista de autores que hayan sido seleccionados en uno o más recursos
     */
    public function contarAutoresConRecursos(){
        $lista = mainModel::ejecutar_consulta_simple("SELECT DISTINCT a.id FROM autor a JOIN autor_recurso ar ON ar.id_autor = a.id WHERE a.estado = " . Utilidades::getIdEstado("ACTIVO"));
        return $lista->fetchAll();
    }

    /**
     * Consulta la lista de cursos que hayan sido seleccionados en uno o más recursos
     */
    public function contarCursosConRecursos(){
        $lista = mainModel::ejecutar_consulta_simple("SELECT DISTINCT c.id FROM curso c JOIN curso_recurso cr ON cr.id_curso = c.id WHERE c.estado = " . Utilidades::getIdEstado("ACTIVO"));
        return $lista->fetchAll();
    }
    
}
?>