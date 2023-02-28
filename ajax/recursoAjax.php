<?php
$peticionAjax = true;

require_once "../config/APP.php";

if(isset($_POST['titulo_ins'])){

    /*--- Instancia al controlador ---*/
    require_once "../controladores/recursoControlador.php";
    $ins_recurso = new recursoControlador();

    if(isset($_POST['titulo_ins'])){
        $ruta = "../recursos/".$_FILES["archivo"]["name"];
        move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta);

        echo $ins_recurso->agregar_recurso_controlador($ruta);
    }

}
?>