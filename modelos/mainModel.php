<?php

    if($peticionAjax){
        require_once "../config/SERVER.php";
    }else{
        require_once "./config/SERVER.php";
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
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error",
                    "Texto"=>"Error al conectarse con el servidor",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
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

        // Método para limpiar cadena y evitar inyección SQL o campos vacíos
        protected static function limpiar_cadena($cadena){
            $cadena = trim($cadena);
            return $cadena;
        }

    }

?>