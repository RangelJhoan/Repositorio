<?php

require_once "./controladores/cursoControlador.php";
require_once "./controladores/programaControlador.php";
require_once "./controladores/usuarioControlador.php";
require_once "./utilidades/Utilidades.php";

$ins_curso = new cursoControlador();
$ins_programa = new programaControlador();
$insUsuario = new usuarioControlador();

$datos_curso = $ins_curso->datos_curso_controlador("Unico", $pagina[1]);
$datos_programas = $ins_programa->listar_programas_controlador();
$datosUsuarios = $insUsuario->obtenerPersonasXTipoUsuario("DOCENTE");

if($datos_curso->rowCount()>0){
    $campos_curso = $datos_curso->fetch();
    $programas_curso = $ins_curso->programas_curso_controlador($campos_curso['id']);
    $docentesCurso = $ins_curso->docentes_curso_controlador($campos_curso['id']);
    ?>
<section class="general-admin-container">
    <div class="overview-general-admin">
        <!--TÍTULO-->
        <div class="title">
            <i class="uil uil-file-blank"></i>
                <h1 class="panel-title-name">Editar Recurso</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                <form action="<?php echo SERVER_URL ?>ajax/recursoAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save_resource" autocomplete="off" enctype="multipart/form-data">
                        <!--Título recurso-->
                        <div class="input-field">
                            <input name="titulo_ins" type="text" placeholder="Título *" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Lista de autores-->
                        <label for="autorSeleccion" class="titleComboMultiple">Autor(es)</label>
                            <select name="autores_ins[]" id="autorSeleccionarCbx" multiple="multiple" title="Por favor, selecciona el o los autores del recurso">
                                <?php
                                foreach($datos_autores as $datos_autor){
                                ?>
                                <option value="<?php echo $datos_autor['id'] ?>"><?php echo $datos_autor['nombre'] . " " .  $datos_autor['apellido']?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <!--Resumen-->
                        <textarea class="textAreaStl" name="resumen_ins" type="text" placeholder="Resumen *" title="Por favor, complete el campo" required></textarea>
                        <!--Año recurso-->
                        <div class="input-field">
                            <input name="anioRecurso" type="number" placeholder="Año de creación" min="1700" pattern="[0-9]+" title="Por favor, complete el campo"/>
                        </div>
                        <!--Lista de cursos-->
                        <label for="cursoSeleccion" class="titleComboMultiple">Curso (s) *</label>
                            <select name="cursos_ins[]" id="cursoSeleccionarCbx" multiple="multiple" title="Por favor, selecciona el o los programas asociados al recurso">
                                <?php
                                foreach($datos_cursos as $campos_curso){
                                ?>
                                <option value="<?php echo $campos_curso['id'] ?>"><?php echo $campos_curso['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <!--Lista de etiquetas-->
                        <label for="etiquetaSeleccion" class="titleComboMultiple">Etiqueta (s)</label>
                            <select name="etiquetas_ins[]" id="etiquetaSeleccionarCbx" multiple="multiple" title="Por favor, selecciona la o las etiquetas para el recurso">
                                <?php
                                foreach($datos_etiquetas as $campos_etiqueta){
                                ?>
                                <option value="<?php echo $campos_etiqueta['id'] ?>"><?php echo $campos_etiqueta['descripcion'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <!--Editorial-->
                        <div class="input-field">
                            <input name="editorial_ins" type="text" placeholder="Editorial " title="Por favor, complete el campo"/>
                        </div>
                        <!--ISBN-->
                        <div class="input-field">
                            <input name="ISBN_ins" type="number" placeholder="ISBN" title="Por favor, complete el campo"/>
                        </div>
                        <!--Link del recurso-->
                        <div class="input-field">
                            <input name="link_ins" type="text" placeholder="Enlace" title="Por favor, complete el campo"/>
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
            <a href="<?php echo SERVER_URL; ?>adminRecursos/" class="btn-UserNotFound" title="Ir a recursos">Volver atrás</a>
        </section>
    </div>
<?php } ?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleComboRecurso.js"></script> 
<script src="<?php echo SERVER_URL ?>vistas/assets/js/uploadFile.js"></script> 