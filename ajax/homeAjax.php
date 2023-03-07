<?php 

$peticionAjax = true;

require_once "../config/APP.php";
require_once "../controladores/homeControlador.php";
require_once "../modelos/mainModel.php";
$ins_home = new homeControlador();
$ins_main = new mainModel();
if(isset($_POST['barraBusqueda'])){

    $array = explode(" ", $_POST['barraBusqueda']);
    $parametro = "";
    foreach($array as $dato){
        if($parametro!=""){
            $parametro .= "¡";
        }
        $parametro .= $ins_main->encryption($dato);
    }

    header("Location:".SERVER_URL."recursosBusqueda/Busqueda/".$parametro);
}else if(isset($_POST['codano'])){
    header("Location:".SERVER_URL."recursosBusqueda/Fechafiltrar/".$_POST['codano']);
}

?>