
<html class="no-scroll">
<!-- TABLA INFORMACIÓN DEL RECURSO -->
    <section class = "containerVerRecurso">
        <table class="tableRecursoVisualizar">
            <tr>
                <th colspan="2" class="containerVerRecursoTitulo">INFORMACIÓN DEL RECURSO</th>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Título:</th>
                <td class="infoColVerRecurso">
                Programación orientada a objetos para enfermitos</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Autor(es):</th>
                <td class="infoColVerRecurso">          
                    <ul class="ulVerRecurso">
                        <a href="<?php echo SERVER_URL ?>#" class="redireccionVerRecurso"><li class="liVerRecurso">Juan Camilo Valencia Silva</li></a>
                        <a href="<?php echo SERVER_URL ?>#" class="redireccionVerRecurso"><li class="liVerRecurso">Jhoan Manuel Rangel Mariño</li></a>
                    </ul>
                </td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Resumen:</th>
                <td class="infoColVerRecurso">Este es el resumen del recurso</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Año de creación:</th>
                <td class="infoColVerRecurso">1999</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Publicado por:</th>
                <td class="infoColVerRecurso">Rafael Ricardo Mantilla</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Fecha de publicación:</th>
                <td class="infoColVerRecurso">12 - 06 - 2023</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Curso(s):</th>
                <td class="infoColVerRecurso">          
                    <ul class="ulVerRecurso">
                        <a href="<?php echo SERVER_URL ?>#" class="redireccionVerRecurso"><li class="liVerRecurso">Minería de datos</li></a>
                        <a href="<?php echo SERVER_URL ?>#" class="redireccionVerRecurso"><li class="liVerRecurso">Seguridad informática</li></a>
                    </ul>
                </td>    
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Etiqueta(s):</th>
                <td class="infoColVerRecurso">
                    <ul class="ulVerRecurso">
                        <a href="<?php echo SERVER_URL ?>#" class="redireccionVerRecurso"><li class="liVerRecurso">SQL</li></a>
                        <a href="<?php echo SERVER_URL ?>#" class="redireccionVerRecurso"><li class="liVerRecurso">POO</li></a>
                    </ul></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Editorial:</th>
                <td class="infoColVerRecurso">Norma</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">ISBN:</th>
                <td class="infoColVerRecurso">04028524</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">URI:</th>
                <td class="infoColVerRecurso">
                    <a href="<?php echo SERVER_URL ?>#" class="redireccionVerRecurso">http://localhost/Repositorio/recursosVisualizacion/</a>
                </td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Identificador:</th>
                <td class="infoColVerRecurso"> REC-090320231106</td>
            </tr>
    <!-- ENLACE DEL RECURSO -->
            <tr>
                <th colspan="2" class="containerVerRecursoTitulo">ENLACE DEL RECURSO</th>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">URL:</th>
                <td class="infoColVerRecurso">
                    <a href="<?php echo SERVER_URL ?>#" target="_blank" class="redireccionVerRecurso">https://www.youtube.com/watch?v=StxPHD_7Mzc&ab_channel=TheWildProject</a>
                </td>
            </tr>
    <!-- ARCHIVO DEL RECURSO -->
            <tr>
                <th colspan="2" class="containerVerRecursoTitulo">ARCHIVO DEL RECURSO</th>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Archivo:</th>
                <td class="infoColVerRecurso">
                    <a href="<?php echo SERVER_URL ?>#" target="_blank" class="redireccionVerRecurso">LondonoJuan_1944_AnalesAcademiaMedicina.pdf</a>
                </td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Tamaño:</th>
                <td class="infoColVerRecurso">10.07MB</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Formato:</th>
                <td class="infoColVerRecurso">PDF</td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Acción:</th>
                <td class="infoColVerRecurso infoBotonesVerRec">
                    <div class="action-options-container">
                        <div class="btn-group-action">
                            <a href="" target="_blank" class="btn-admin-view-record" title="Visualizar archivo"><i class="uil uil-eye btnAccionesRecurso btnVisRec"></i></a>
                            <a href="" class="btn-admin-view-record" title="Descargar archivo"><i class="uil uil-cloud-download btnAccionesRecurso btnDescRec"></i></a>
                            <a href="#" class="btn-admin-view-record buttonFeedbackOpen" title="Calificar recurso"><i class="uil uil-feedback btnAccionesRecurso btnCalRec"></i></a>
                            <a href="" class="btn-admin-view-record" title="Agregar a favoritos el recurso"><i class="uil uil-heart btnAccionesRecurso btnFavRec"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!--MODAL FEEDBACK-->
        <div class="modal-container">
            <div class="modal-feedback modal-close-feedback">
                <p class="close">X</p>
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/feedback-Img.svg" class="recover-password-pic" alt="Ilustración calificar recurso" />
                    <div class="textosmodal">
                        <h3 class="title-feedback">¿Considera que el recurso es útil?</h3>
                        <p class="phrp-feedback">Por favor seleccione una de las siguientes opciones:</p>
                        <form action="#" class="" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field">
                            <label class="radio">
                                <input class="inputRadio" type="radio" name="respuestaFeedback" value="Sí">
                                <span class="checkmark"></span>
                                <span class="label-text">Sí, el recurso es útil.</span>
                            </label>
                            <label class="radio">
                                <input class="inputRadio" type="radio" name="respuestaFeedback" value="No">
                                <span class="checkmark"></span>
                                <span class="label-text">No, el recurso no es útil.</span>
                            </label>
                        </div>

                            <div class="botones-accion-modal">
                                <input type="submit" class="btn-submit-add-record" value="Enviar" title="Enviar"/>
                                <!-- <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cancelar</label> -->
                            </div>
                        </form>
                        </div>
                    </div>
            </div>
        </div>
    </section>
<script src="<?php echo SERVER_URL; ?>vistas/assets/js/feedbackForm.js"></script>
