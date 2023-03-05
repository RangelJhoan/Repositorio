<?php
$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['titulo_ins'])){

    /*--- Instancia al controlador ---*/
    require_once "../controladores/recursoControlador.php";
    $ins_recurso = new recursoControlador();

    if(isset($_POST['titulo_ins'])){
        echo $ins_recurso->agregar_recurso_controlador();
    }

}
?>