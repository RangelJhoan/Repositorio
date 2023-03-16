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
        $valorar = homeModelo::evaluar_recurso($pId, $pRespuesta);
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
                "Texto"=>"Gracias por evaluar el recurso",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
        }
    }
}



?>