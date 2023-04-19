<?php

class Utilidades {

    /*--- UTILIDAD DE ESTADOS ---*/
    private static $estados = array(0 => "INACTIVO",
            1 => "ACTIVO",
            2 => "PENDIENTE ACTIVACION",
            3 => "ELIMINADO"
            );

    // Tipo de MIME permitidos para navegadores
    private static $tiposMimePermitidos = array(
        'application/pdf',
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'audio/mpeg',
        'audio/wav', 
        'audio/ogg',
        'video/mp4',
        'video/webm'
    );

    private static $estadosEdicion = array(0, 1);

    private static $estadosUsuario = array(0, 1, 2);

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

    public static function getEstadosUsuario(){
        $estadosFiltrados = array();
        foreach(self::$estadosUsuario as $estado){
            if(isset(self::$estados[$estado]))
                $estadosFiltrados[$estado] = self::$estados[$estado];
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

    public static function getTiposMimePermitidos(){
        return self::$tiposMimePermitidos;
    }

    // Generar código aleatorio

    /**
     * Genera un código apartir de una secuencia aleatoria, la fecha actual y otra secuencia aleatoria
     * 
     * @return string Secuencia aleatoria de longitud dinámica de longitud 5, concatenado con la fecha actual y otra secuencia aleatoria de longitud 3
     */
    public static function generarCodigo() {
        $fechaHora = date('dmYHis');
        $codigo = self::generarAleatorio(5) . $fechaHora . self::generarAleatorio(3);
        return $codigo;
    }
    
    /**
     * Genera una secuencia aleatoria con la longitud recibida por parámetro
     * @param mixed $longitud Tamaño de la secuencia aleatoria
     * @return string Secuencia aleatoria de longitud dinámica
     */
    public static function generarAleatorio($longitud) {
        $bytes = random_bytes(ceil($longitud / 2));
        return substr(bin2hex($bytes), 0, $longitud);
    }

}

?>