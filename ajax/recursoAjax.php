<?php
$peticionAjax = true;

require_once "../config/APP.php";
/*--- Instancia al controlador ---*/
require_once "../controladores/recursoControlador.php";
$ins_recurso = new recursoControlador();

/*--- ADMINISTRADOR ---*/

if(isset($_POST['titulo_ins'])){
    if(isset($_POST['titulo_ins'])){
        echo $ins_recurso->agregar_recurso_controlador();
    }

}else if(isset($_POST['id_recurso_del'])){
    echo $ins_recurso->eliminar_recurso_controlador();
}

if(isset($_POST['titulo_edit'])){
    echo $ins_recurso->editar_recurso_controlador();
}


/*--- DOCENTE ---*/
if(isset($_POST['titulo_docente_ins'])){
    echo $ins_recurso->agregar_docente_recurso_controlador();
}

if(isset($_POST['titulo_docente_edit'])){
    echo $ins_recurso->editar_docente_recurso_controlador();
}
?>