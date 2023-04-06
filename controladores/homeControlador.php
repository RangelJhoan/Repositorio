<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/homeModelo.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/homeModelo.php";
}

class homeControlador extends homeModelo{

    public function listado_filtro_recursos($pTipo, $pBuscar){
        $listado = homeModelo::filtrar_recursos($pTipo, $pBuscar);
        return $listado->fetchAll();
    }

    public function cargar_informacion_recurso($pId){
        $informacion = homeModelo::cargar_autores($pId);
        $autores = "";
        foreach ($informacion AS $key => $autor){
            $separador = ($key == count($informacion) - 1) ? "" : "; ";
            $autores .= $autor['apellido'].", ".$autor['nombre'].$separador;
        }
        return $autores;
    }

    public function cargar_busqueda($pBusqueda){
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
    public function cargar_recursos_autor($pId){
        $recursos = homeModelo::cargar_recursos($pId);
        return $recursos;
    }

    public function cargar_recursos_curso($pId){
        $recursos = homeModelo::cargar_curso($pId);
        
        return $recursos;
    }

    public function capturar_fecha_recurso(){
        $fechas = homeModelo::fechas_recurso();

        return $fechas;
    }

    public function buscar_info_recurso($pId){
        $informacion = homeModelo::detalles_recurso(mainModel::decryption($pId));

        return $informacion;
    }

    public function autores_recurso($pId){
        $informacion = homeModelo::cargar_autores($pId);
        
        return $informacion;
    }

    public function curso_recurso($pId){
        $informacion = homeModelo::cursos_recurso($pId);
        
        return $informacion;
    }

    public function etiquetas_recurso($pId){
        $informacion = homeModelo::cargar_etiquetas($pId);
        
        return $informacion;
    }

    public function archivo_recurso($pId){
        $informacion = homeModelo::cargar_archivos($pId);
        
        return $informacion;
    }

    public function calificar_recurso($pId, $pRespuesta){
        session_start(['name'=>"REPO"]);
        if(isset($_SESSION['id_persona']) && $_SESSION['tipo_usuario']=="Estudiante"){
            $validar = homeModelo::validar_registro_voto($pId);
            if(isset($validar['id'])){
                $valorar = homeModelo::editar_voto($validar['id'],$pRespuesta);
                if($valorar>0){
                    $registrar = homeModelo::quitar_punto($pId, $pRespuesta);
                    $valorar = homeModelo::evaluar_recurso($pId, $pRespuesta);
                }
            }else{
                $valorar = homeModelo::evaluar_recurso($pId, $pRespuesta);
                $registrar = homeModelo::registrar_voto($pId, $pRespuesta);
            }
            if(is_string($valorar)){
                echo Utilidades::getAlertaErrorJSON("simple", "Error: ".$valorar);
                exit();
            }else{
                echo Utilidades::getAlertaExitosoJSON("recargar", "Gracias por evaluar el recurso y ayudar a mejorar su calidad. Su retroalimentación es muy valiosa y nos ayudará a identificar áreas de oportunidad para seguir mejorando y ofrecer recursos de gran utilidad.");
            }
        }else{
            echo Utilidades::getAlertaErrorJSON("recargar", "Para calificar este recurso, es necesario que inicie sesión.");
            exit();
        }
        
    }

    public function buscar_ruta_archivo($pId){
        $informacion = homeModelo::ruta_archivo($pId);
        
        return $informacion;
    }

    public function agregar_favorito($pId){
        session_start(['name'=>"REPO"]);
        if(isset($_SESSION['id_persona']) && $_SESSION['tipo_usuario']=="Estudiante"){
            $validar = homeModelo::validar_favorito($pId);
            if(!isset($validar['id'])){
                $favorito = homeModelo::registrar_favorito($pId);
                $textoalert = "Recurso Agregado a Favoritos";
            }else{
                $favorito = homeModelo::eliminar_favorito($validar['id']);
                $textoalert = "Recurso Eliminado de Favoritos";
            }

            if(is_string($favorito)){
                echo Utilidades::getAlertaErrorJSON("simple", "Error: ".$favorito);
                exit();
            }else{
                echo Utilidades::getAlertaExitosoJSON("recargar", $textoalert);
            }
        }else{
            echo Utilidades::getAlertaErrorJSON("recargar", "Para agregar este recurso a favoritos, es necesario que inicie sesión.");
        }
    }

    /**
     * Consulta la lista de autores que hayan sido seleccionados en uno o más recursos
     */
    public function contarAutoresConRecursos(){
        $lista = mainModel::ejecutar_consulta_simple("SELECT DISTINCT a.id FROM autor a JOIN autor_recurso ar ON ar.id_autor = a.id;");
        return $lista->fetchAll();
    }

    /**
     * Consulta la lista de cursos que hayan sido seleccionados en uno o más recursos
     */
    public function contarCursosConRecursos(){
        $lista = mainModel::ejecutar_consulta_simple("SELECT DISTINCT c.id FROM curso c JOIN curso_recurso cr ON cr.id_curso = c.id;");
        return $lista->fetchAll();
    }
    
}



?>