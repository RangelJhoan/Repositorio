<?php

    if($peticionAjax){
        require_once "../config/SERVER.php";
    }else{
        require_once "./config/SERVER.php";
    }

    class mainModel{

        /*------- Función para conectar a la base de datos ------*/
        protected static function conectar(){
            $conexion = new PDO(SGBD, USER, PASS);
            $conexion->exec("SET CHARACTER SET utf8");
            return $conexion;
        }

        /*------- Función para ejecutar consultas simples ------*/
        protected static function ejecutar_consulta_simple($consulta){
            $sql = self::conectar()->prepare($consulta);
            $sql->execute();
            return $sql;
        }

    }

?>