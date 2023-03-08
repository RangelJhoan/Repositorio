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
        foreach($arrayParametro AS $dato){
            if($search!=""){
                $search .= " ";
            }
            $search .= mainModel::decryption($dato);
        }

        return $search;

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
}



?>