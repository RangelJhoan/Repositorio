<?php

    if($peticionAjax){
        require_once "../config/SERVER.php";
        require_once "../utilidades/Utilidades.php";
    }else{
        require_once "./config/SERVER.php";
        require_once "./utilidades/Utilidades.php";
    }

    class mainModel{

        /*------- Función para conectar a la base de datos ------*/
        protected static function conectar(){
            try {
                $conexion = new PDO(SGBD, USER, PASS);
                $conexion->exec("SET CHARACTER SET utf8");
            } catch (Exception $e) {
                echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Error al conectarse con el servidor",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
            }
            return $conexion;
        }

        /*------- Función para ejecutar consultas simples ------*/
        protected static function ejecutar_consulta_simple($consulta){
            try {
                $sql = self::conectar()->prepare($consulta);
                $sql->execute();
                return $sql;
            } catch (Exception $e) {
                echo Utilidades::getAlertaErrorJSON("simple", "Error al conectarse con el servidor");
            }
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

        /**
         * Método para eliminar palabras claves de programación y otros caracteres dentro de una entrada por el usuario
         * 
         * @param string $cadena Input del usuario a limpiar
         * @return string $cadena Cadena de texto sin caracteres o palabras claves especiales en programación
         */
        protected static function limpiarCadena($cadena){
            $cadena = trim($cadena);
            $cadena = stripslashes($cadena);
            $cadena = str_ireplace("<script>", "", $cadena);
            $cadena = str_ireplace("</script>", "", $cadena);
            $cadena = str_ireplace("<script src", "", $cadena);
            $cadena = str_ireplace("<script type=", "", $cadena);
            $cadena = str_ireplace("SELECT * FROM", "", $cadena);
            $cadena = str_ireplace("DELETE FROM", "", $cadena);
            $cadena = str_ireplace("INSERT INTO", "", $cadena);
            $cadena = str_ireplace("DROP TABLE", "", $cadena);
            $cadena = str_ireplace("DROP DATABASE", "", $cadena);
            $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
            $cadena = str_ireplace("SHOW TABLES", "", $cadena);
            $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
            $cadena = str_ireplace("<?php", "", $cadena);
            $cadena = str_ireplace("?>", "", $cadena);
            $cadena = stripslashes($cadena);
            $cadena = trim($cadena);
            return $cadena;
        }

        protected static function verificarDatos($filtro, $cadena){
            if(preg_match("/^".$filtro."$/", $cadena))
                return true;
            else
                return false;
        }

    }

?>
