<?php
    $id = $_GET['codigo'];
    $peticionAjax=true;
    require_once "homeControlador.php";

    $insHome = new homeControlador();

    $busqueda = $insHome->buscarRutaArchivo($id);
    $mime = mime_content_type("../".$busqueda['ruta']);

    header("Content-disposition: attachment; filename=".$busqueda['nombre']);
    header("Content-type: ".$mime);
    readfile("../".$busqueda['ruta']);
    
?>