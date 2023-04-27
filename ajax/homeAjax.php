<?php 

$peticionAjax = true;

require_once "../config/APP.php";
require_once "../controladores/homeControlador.php";
require_once "../modelos/mainModel.php";
$insHome = new homeControlador();
$insMain = new mainModel();
if(isset($_POST['barraBusqueda'])){

    $array = explode(" ", $_POST['barraBusqueda']);
    $parametro = "";
    foreach($array as $dato){
        if($parametro!=""){
            $parametro .= "¡";
        }
        if(strlen($dato)>15){
            $parteuno = substr($dato,0,15);
            $partedos = substr($dato,15,10);
            $partedos .= "~~";
            $parametro.= $insMain->encryption($parteuno);
            $parametro.="¡".$insMain->encryption($partedos);
        }else{
            $parametro .= $insMain->encryption($dato);
        }
        
        
    }
    header("Location:".SERVER_URL."busqueda/Busqueda/".$parametro);
}else if(isset($_POST['codano'])){
    $parametro .= $insMain->encryption($_POST['codano']);
    header("Location:".SERVER_URL."busqueda/Fechafiltrar/".$parametro);
}else if(isset($_POST['respuestaFeedback'])){
    $idRecurso = $_POST['codrecurso'];
    $respuesta = $_POST['respuestaFeedback'];
    echo $insHome->calificarRecurso($idRecurso, $respuesta);
}else if (isset($_POST['favorito'])) {
    $idFavorito = $_POST['favorito'];
    echo $insHome->agregarFavorito($idFavorito);
}

?>