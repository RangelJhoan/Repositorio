<?php
require_once "./controladores/autorControlador.php";
require_once "./controladores/etiquetaControlador.php";
require_once "./controladores/cursoControlador.php";

$ins_autor = new autorControlador();
$ins_etiqueta = new etiquetaControlador();
$ins_curso = new cursoControlador();

$datos_autores = $ins_autor->paginador_autor_controlador(null);
$datos_etiquetas = $ins_etiqueta->paginador_etiqueta_controlador(null);
$datos_cursos = $ins_curso->paginador_curso_controlador();
?>
<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-file-blank"></i>
                <h1 class="panel-title-name">Nuevo Recurso</h1>
                <div class="icon-container">
                    <span class="question-Info qInfoNew" aria-label="Mostrar información"><i class="uil uil-question-circle"></i></span>
                    <div class="message-box">
                    <p>Para poder cargar más de un archivo en un recurso, es necesario comprimirlos en un formato específico.</p>
                </div>
            </div>
        </div>

            <div class="container-modal-edit-record" id="modal-container-add-record">
                <div class="content-modal-add-record">
                <p class="content-modal-recordatorio">Recuerde que * indica que el campo es obligatorio.</p>

                <form action="<?php echo SERVER_URL ?>ajax/recursoAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save_resource" autocomplete="off" enctype="multipart/form-data">
                        <!--Título recurso-->
                        <div class="input-field">
                            <input name="titulo_docente_ins" type="text" maxlength="250" placeholder="Título *" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Lista de autores-->
                        <label for="autorSeleccion" class="titleComboMultiple">Autor(es)</label>
                            <select name="autores_docente_ins[]" id="autorSeleccionarCbx" multiple="multiple" title="Por favor, selecciona el o los autores del recurso">
                                <?php
                                foreach($datos_autores as $datos_autor){
                                ?>
                                <option value="<?php echo $datos_autor['id'] ?>"><?php echo $datos_autor['nombre'] . " " .  $datos_autor['apellido']?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <!--Resumen-->
                        <textarea class="textAreaStl" name="resumen_docente_ins" type="text" maxlength="1500" placeholder="Resumen *" title="Por favor, complete el campo" required></textarea>
                        <!--Año recurso-->
                        <div class="input-field">
                            <input name="anioRecurso_docente" type="number" placeholder="Año de creación" min="1700" pattern="[0-9]+" title="Por favor, complete el campo"/>
                        </div>
                        <!--Lista de cursos-->
                        <label for="cursoSeleccion" class="titleComboMultiple">Curso(s) *</label>
                            <select name="cursos_docente_ins[]" id="cursoSeleccionarCbx" multiple="multiple" title="Por favor, selecciona el o los programas asociados al recurso">
                                <?php
                                foreach($datos_cursos as $campos_curso){
                                ?>
                                <option value="<?php echo $campos_curso['id'] ?>"><?php echo $campos_curso['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <!--Lista de etiquetas-->
                        <label for="etiquetaSeleccion" class="titleComboMultiple">Palabra(s) clave</label>
                            <select name="etiquetas_docente_ins[]" id="etiquetaSeleccionarCbx" multiple="multiple" title="Por favor, selecciona la o las palabras clave para el recurso">
                                <?php
                                foreach($datos_etiquetas as $campos_etiqueta){
                                ?>
                                <option value="<?php echo $campos_etiqueta['idEtiqueta'] ?>"><?php echo $campos_etiqueta['descripcion'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <!--Editorial-->
                        <div class="input-field">
                            <input name="editorial_docente_ins" type="text" maxlength="80" placeholder="Editorial " title="Por favor, complete el campo"/>
                        </div>
                        <!--ISBN-->
                        <div class="input-field">
                            <input name="ISBN_docente_ins" type="number" maxlength="20" placeholder="ISBN" title="Por favor, complete el campo"/>
                        </div>
                        <!--Link del recurso-->
                        <div class="input-field">
                            <input name="link_docente_ins" type="text" maxlength="300" placeholder="Enlace" title="Por favor, complete el campo"/>
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
                        <!--Botones de acción-->
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" title="Crear recurso" id="btn-submit"/>
                            <a href="javascript:history.back()" class="btn-close-add-record" title="Volver atrás">Volver atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        <div>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleComboRecurso.js"></script>
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/uploadFile.js"></script>
