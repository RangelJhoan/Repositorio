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
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Error: ".$valorar,
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Exitoso",
                    "Texto"=>"Gracias por evaluar el recurso y ayudar a mejorar su calidad. Su retroalimentación es muy valiosa y nos ayudará a identificar áreas de oportunidad para seguir mejorando y ofrecer recursos de gran utilidad.",
                    "Tipo"=>"success"
                ];
                echo json_encode($alerta);
            }
        }else{
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Error",
                "Texto"=>"Para calificar este recurso, es necesario que inicie sesión.",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
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
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Error: ".$favorito,
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }else{
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Exitoso",
                    "Texto"=>$textoalert,
                    "Tipo"=>"success"
                ];
                echo json_encode($alerta);
            }
        }else{
            $alerta=[
                "Alerta"=>"recargar",
                "Titulo"=>"Error",
                "Texto"=>"Para agregar este recurso a favoritos, es necesario que inicie sesión.",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }
    }
    
}



?>