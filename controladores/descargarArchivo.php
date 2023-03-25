<?php
    $id = $_GET['codigo'];
    $peticionAjax=true;
    require_once "homeControlador.php";

    $ins_home = new homeControlador();

    $busqueda = $ins_home->buscar_ruta_archivo($id);
    $mime = mime_content_type("../".$busqueda['ruta']);

    header("Content-disposition: attachment; filename=".$busqueda['nombre']);
    header("Content-type: ".$mime);
    readfile("../".$busqueda['ruta']);
    
?>