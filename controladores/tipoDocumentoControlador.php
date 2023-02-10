<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/tipoDocumentoModelo.php";
    require_once "../entidades/TipoDocumento.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/tipoDocumentoModelo.php";
    require_once "./entidades/TipoDocumento.php";
}

class tipoDocumentoControlador extends tipoDocumentoModelo{

    public function listar_tipo_documento_controlador(){
        $sql = mainModel::ejecutar_consulta_simple("SELECT * FROM tipo_documento;");
        return $sql->fetchAll();
    }

}