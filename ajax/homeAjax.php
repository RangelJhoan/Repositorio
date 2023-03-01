<?php 

$peticionAjax = true;

require_once "../config/APP.php";
require_once "../controladores/homeControlador.php";
$ins_home = new homeControlador();

if(isset($_POST['barraBusqueda'])){
    header("Location:".SERVER_URL."recursosBusqueda/Busqueda/".str_replace(" ","-",$_POST['barraBusqueda']));
}

?>