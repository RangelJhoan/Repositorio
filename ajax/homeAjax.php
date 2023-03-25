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
        if(strlen($dato)>15){
            $parteuno = substr($dato,0,15);
            $partedos = substr($dato,15,10);
            $partedos .= "~~";
            $parametro.= $ins_main->encryption($parteuno);
            $parametro.="¡".$ins_main->encryption($partedos);
        }else{
            $parametro .= $ins_main->encryption($dato);
        }
        
        
    }
    // $arrayParametro = explode("!", $parametro);
    // var_dump($arrayParametro); 
    // foreach($arrayParametro AS $prueba){
    //     $info = $ins_main->decryption($prueba);
    //     $info = str_replace("~~","",$info);
    //     echo $info;
    // }

    header("Location:".SERVER_URL."recursosBusqueda/Busqueda/".$parametro);
}else if(isset($_POST['codano'])){
    $parametro .= $ins_main->encryption($_POST['codano']);
    header("Location:".SERVER_URL."recursosBusqueda/Fechafiltrar/".$parametro);
}else if(isset($_POST['respuestaFeedback'])){
    $idRecurso = $_POST['codrecurso'];
    $respuesta = $_POST['respuestaFeedback'];
    echo $ins_home->calificar_recurso($idRecurso, $respuesta);
}else if (isset($_POST['favorito'])) {
    $idFavorito = $_POST['favorito'];
    echo $ins_home->agregar_favorito($idFavorito);
}

?>