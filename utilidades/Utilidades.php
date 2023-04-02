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

    public static function generarClaveAleatoria(){
        // Genera una cadena de bytes aleatorios
        $bytes = random_bytes(4);

        // Convierte la cadena de bytes en una cadena de caracteres segura
        $key = bin2hex($bytes);

        // Agrega caracteres especiales a la clave
        $catacteresEspeciales = array('*', '-', '+', '=', '<', '>', '?');
        $key .= $catacteresEspeciales[rand(0, count($catacteresEspeciales)-1)];

        // Mezcla la clave para que tenga una combinación aleatoria de mayúsculas, minúsculas y números
        $key = str_shuffle(strtolower($key) . strtoupper($key) . rand(0, 999));

        // Limita la clave a 12 caracteres
        $key = substr($key, 0, 12);

        return $key;
    }

}

?>