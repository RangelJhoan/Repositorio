<?php

require_once "./controladores/recursoControlador.php";
require_once "./controladores/autorControlador.php";
require_once "./controladores/cursoControlador.php";
require_once "./controladores/etiquetaControlador.php";

$insRecurso = new recursoControlador();
$insAutor = new autorControlador();
$insCurso = new cursoControlador();
$insEtiqueta = new etiquetaControlador();

$consultaRecursos = $insRecurso->datos_recurso_controlador("Unico", $pagina[1]);
if($consultaRecursos->rowCount() > 0){
    //Se carga la información del recurso y del archivo
    $datosRecurso = $consultaRecursos->fetch();

    //Se consultan toda la lista de tablas intermedias
    $listaAutores = $insAutor->paginadorAutorControlador(null, true);
    $listaCursos = $insCurso->paginador_curso_controlador(true);
    $listaEtiquetas = $insEtiqueta->paginador_etiqueta_controlador(null, true);

    //Se consultan los registros relacionados
    $autoresActuales = $insAutor->autoresXRecursoControlador($datosRecurso['idRecurso']);
    $cursosActuales = $insCurso->cursosXRecursoControlador($datosRecurso['idRecurso']);
    $etiquetasActuales = $insEtiqueta->etiquetasXRecursoControlador($datosRecurso['idRecurso']);
    ?>
<section class="general-admin-container">
    <div class="overview-general-admin">
        <!--TÍTULO-->
        <div class="title">
            <i class="uil uil-file-blank"></i>
            <h1 class="panel-title-name">Editar Recurso</h1>
            <div class="icon-container">
                <span class="question-Info qInfoNew" aria-label="Mostrar información"><i class="uil uil-question-circle"></i></span>
                <div class="message-box">
                <p>Para poder cargar más de un archivo en un recurso, es necesario comprimirlos en un formato específico.</p>
                </div>
            </div>
        </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                <form action="<?php echo SERVER_URL ?>ajax/recursoAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save_resource" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="id_recurso_edit" value="<?php echo $pagina[1] ?>">
                    <!--Título recurso-->
                    <div class="input-field">
                        <input name="titulo_edit" type="text" maxlength="250" value="<?php echo $datosRecurso['titulo']?>" placeholder="Título *" title="Por favor, complete el campo" required/>
                    </div>
                    <!--Lista de autores-->
                    <label for="autorSeleccion" class="titleComboMultiple">Autor(es)</label>
                        <select name="autores_edit[]" id="autorSeleccionarCbx" multiple="multiple" title="Por favor, selecciona el o los autores del recurso">
                            <?php
                            foreach($listaAutores as $datosAutor){
                                $selected = false;
                                foreach ($autoresActuales as $datosAutorActual) {
                                    if($datosAutor['id'] == $datosAutorActual['id']){
                                        $selected = true;
                                    }
                                }
                            ?>
                            <option <?php if($selected) echo "selected" ?> value="<?php echo $datosAutor['id'] ?>"><?php echo $datosAutor['nombre'] . " " .  $datosAutor['apellido']?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <!--Resumen-->
                    <textarea class="textAreaStl" name="resumen_edit" maxlength="1500" type="text" placeholder="Resumen *" title="Por favor, complete el campo" required><?php echo $datosRecurso['resumen'] ?></textarea>
                    <!--Año recurso-->
                    <div class="input-field">
                        <input name="anioRecurso_edit" type="number" value="<?php echo $datosRecurso['fecha_publicacion_recurso'] ?>" placeholder="Año de creación" min="1700" pattern="[0-9]+" title="Por favor, complete el campo"/>
                    </div>
                    <!--Lista de cursos-->
                    <label for="cursoSeleccion" class="titleComboMultiple">Curso (s) *</label>
                        <select name="cursos_edit[]" id="cursoSeleccionarCbx" multiple="multiple" title="Por favor, selecciona el o los programas asociados al recurso">
                            <?php
                            foreach($listaCursos as $datosCurso){
                                $selected = false;
                                foreach ($cursosActuales as $datosCursoActual) {
                                    if($datosCurso['id'] == $datosCursoActual['id']){
                                        $selected = true;
                                    }
                                }
                            ?>
                            <option <?php if($selected) echo "selected" ?> value="<?php echo $datosCurso['id'] ?>"><?php echo $datosCurso['nombre']?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <!--Lista de etiquetas-->
                    <label for="etiquetaSeleccion" class="titleComboMultiple">Palabra(s) clave</label>
                        <select name="etiquetas_edit[]" id="etiquetaSeleccionarCbx" multiple="multiple" title="Por favor, selecciona la o las palabras clave para el recurso">
                            <?php
                            foreach($listaEtiquetas as $datosEtiqueta){
                                $selected = false;
                                foreach ($etiquetasActuales as $datosEtiquetaActual) {
                                    if($datosEtiqueta['idEtiqueta'] == $datosEtiquetaActual['id']){
                                        $selected = true;
                                    }
                                }
                            ?>
                            <option <?php if($selected) echo "selected" ?> value="<?php echo $datosEtiqueta['idEtiqueta'] ?>"><?php echo $datosEtiqueta['descripcion']?></option>
                            <?php
                            }
                            ?>
                        </select>
                    <!--Editorial-->
                    <div class="input-field">
                        <input name="editorial_edit" maxlength="80" type="text" placeholder="Editorial " value="<?php echo $datosRecurso['editorial'] ?>" title="Por favor, complete el campo"/>
                    </div>
                    <!--ISBN-->
                    <div class="input-field">
                        <input name="ISBN_edit" type="number" maxlength="20" placeholder="ISBN" value="<?php echo $datosRecurso['isbn'] ?>" title="Por favor, complete el campo"/>
                    </div>
                    <!--Link del recurso-->
                    <div class="input-field">
                        <input name="link_edit" type="text" maxlength="300" placeholder="Enlace" value="<?php echo $datosRecurso['enlace'] ?>" title="Por favor, complete el campo"/>
                    </div>
                    <!--Estados-->
                    <div class="input-field ">
                        <div class="select-option">
                            <select name="estado_edit" class="combobox-titulo" title="Estado del curso">
                            <option disabled value="" class="combobox-opciones">Estado</option>
                                <?php
                                foreach (Utilidades::getEstadosEdicion() as $clave => $valor) {
                                ?>
                                <option <?php if($datosRecurso['estado_recurso'] == $clave){echo "selected";} ?> value="<?php echo $clave; ?>"><?php echo $valor; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!--Cargue del archivo-->
                    <div class="fileUploadContainer">
                        <input class="inputUploadFile" type="file" id="file-input"/>
                        <label class="labelFileUpload" for="file-input">
                            <i class="uil uil-upload"></i>
                            &nbsp; Subir archivo
                        </label>
                        <!--Barra de carga / progreso-->
                        <ul id="files-list">
                        </ul>
                        <div class="progress">
                            <div id="progress-bar" class="progress-bar" role="progressbar"></div>
                        </div>
                    </div>
                    <div class="botones-accion-modal">
                        <button type="submit" class="btn-admin-edit-record" title="Actualizar">Guardar cambios</button>
                        <a href="javascript:history.back()" class="btn-close-edit-record" title="Recursos">Volver atrás</a>
                    </div>
                </form>
            </div>
        </div>
    <div>
</section>
<?php }else{ ?>
    <div class="errorEditContainer">
        <section class="errorTextSection">
            <h3 class="title-errorTextSection">Hmmm...</h3>
            <p class="message-record-not-found">Ha ocurrido un error inesperado.</p>
        </section>
        <section class="img-section">
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar recurso.">
            <a href="javascript:history.back()" class="btn-UserNotFound" title="Volver">Volver atrás</a>
        </section>
    </div>
<?php } ?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleComboRecurso.js"></script> 
<script src="<?php echo SERVER_URL ?>vistas/assets/js/uploadFile.js"></script> 