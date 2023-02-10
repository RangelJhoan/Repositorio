<?php

    require_once "mainModel.php";
    if($peticionAjax){
        //Modelo llamado desde el archivo Ajax
        require_once "../entidades/TipoDocumento.php";
    }else{
        //Modelo llamado desde la vista Index
        require_once "./entidades/TipoDocumento.php";
    }

    class tipoDocumentoModelo extends mainModel{

        

    }

?>