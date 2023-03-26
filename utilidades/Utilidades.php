<?php

class Utilidades {

    /*--- UTILIDAD DE ESTADOS ---*/
    private static $estados = array(0 => "INACTIVO",
            1 => "ACTIVO",
            2 => "PENDIENTE ACTIVACION",
            3 => "ELIMINADO"
            );

    private static $estadosEdicion = array(0, 1);

    public static function getEstados(){
        return self::$estados;
    }

    public static function getEstadosEdicion(){
        $estadosFiltrados = array();
        foreach(self::$estadosEdicion as $estadoEdicion){
            if(isset(self::$estados[$estadoEdicion]))
                $estadosFiltrados[$estadoEdicion] = self::$estados[$estadoEdicion];
        }
        return $estadosFiltrados;
    }

    public static function getNombreEstado($idEstado){
        return self::$estados[$idEstado];
    }

    public static function getIdEstado($nombreEstado){
        return array_keys(self::$estados, $nombreEstado)[0];
    }

    /*--- UTILIDAD DE ALERTAS ---*/
    public static function getAlertaExitosoJSON($alerta, $texto, $url = ""){
        $alerta=[
            "Alerta"=>$alerta,
            "Titulo"=>"Exitoso",
            "URL"=>$url,
            "Texto"=>$texto,
            "Tipo"=>"success"
        ];
        return json_encode($alerta);
    }

    public static function getAlertaErrorJSON($alerta, $texto, $url = ""){
        $alerta=[
            "Alerta"=>$alerta,
            "Titulo"=>"Error",
            "URL"=>$url,
            "Texto"=>$texto,
            "Tipo"=>"error"
        ];
        return json_encode($alerta);
    }

}

?>