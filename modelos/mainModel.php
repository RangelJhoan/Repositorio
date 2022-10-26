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

        /*------- Función para encriptar cadenas ------*/
        public function encryption($string){
			$output=FALSE;
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_encrypt($string, ENCRYPTION_METHOD, $key, 0, $iv);
			$output=base64_encode($output);
			return $output;
		}

        /*------- Función para desencriptar cadenas ------*/
		protected static function decryption($string){
			$key=hash('sha256', SECRET_KEY);
			$iv=substr(hash('sha256', SECRET_IV), 0, 16);
			$output=openssl_decrypt(base64_decode($string), ENCRYPTION_METHOD, $key, 0, $iv);
			return $output;
		}

    }

?>