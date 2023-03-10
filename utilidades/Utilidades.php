<?php

class Utilidades {

private static $estados = array(0 => "INACTIVO",
        1 => "ACTIVO",
        2 => "PENDIENTE ACTIVACION",
        3 => "ELIMINADO"
        );

public static function getEstados(){
    return self::$estados;
}

public static function getNombreEstado($idEstado){
    return self::$estados[$idEstado];
}

public static function getIdEstado($nombreEstado){
    return array_keys(self::$estados, $nombreEstado)[0];
}

}

?>