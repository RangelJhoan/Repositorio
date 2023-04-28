<?php
$peticionAjax = true;

require_once "../config/APP.php";
/*--- Instancia al controlador ---*/
require_once "../controladores/recursoControlador.php";
$insRecurso = new recursoControlador();

/*--- ADMINISTRADOR ---*/

if(isset($_POST['titulo_ins'])){
    if(isset($_POST['titulo_ins'])){
        echo $insRecurso->agregarRecursoControlador();
    }

}else if(isset($_POST['id_recurso_del'])){
    echo $insRecurso->eliminarRecursoControlador();
}

if(isset($_POST['titulo_edit'])){
    echo $insRecurso->editarRecursoControlador();
}


/*--- DOCENTE ---*/
if(isset($_POST['titulo_docente_ins'])){
    echo $insRecurso->agregarDocenteRecursoControlador();
}

if(isset($_POST['titulo_docente_edit'])){
    echo $insRecurso->editarDocenteRecursoControlador();
}

/*--- Estudiante ---*/
if(isset($_POST['id_recurso_favorito_del'])){
    echo $insRecurso->eliminarRecursoFavoritoControlador();
}

if(isset($_POST['id_calificacion_recurso_del'])){
    echo $insRecurso->eliminarCalificacionRecursoControlador();
}

/*--- Llamado de la función para cargar las gráficas del dashboard del docente ---*/
if(isset($_POST['graficar_docente_calificaciones_totales'])){
    echo $insRecurso->calificacionesTotalesXPublicador();
}
?>