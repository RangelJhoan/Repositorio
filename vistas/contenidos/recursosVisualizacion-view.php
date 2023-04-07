<?php
    require_once "./controladores/homeControlador.php";
    require_once "./modelos/mainModel.php";
    $ins_main = new mainModel();
    $ins_home = new homeControlador();

    //No hay información de recurso en la URL
    if(!isset($pagina[1]) || $pagina[1] == ""){
        header('Location: ' . SERVER_URL. '404');
        exit();
    }

    $inforecurso = $ins_home->buscar_info_recurso($pagina[1]);

    //El ID del recurso es incorrecto (No existe)
    if($inforecurso == ""){
        header('Location: ' . SERVER_URL. '404');
        exit();
    }

    $autores = $ins_home->autores_recurso($inforecurso['id']);
    $cursos = $ins_home->curso_recurso($inforecurso['id']);
    $etiquetas = $ins_home->etiquetas_recurso($inforecurso['id']);
    $archivo = $ins_home->archivo_recurso($inforecurso['id']);
    if(isset($archivo['ruta'])){
        $nArchivo = $archivo['nombre'];
        $tamano = $archivo['tamano'];
        $ruta = $archivo['ruta'];
        $formato = pathinfo($nArchivo, PATHINFO_EXTENSION);
        // Obtener el tipo de MIME del archivo
        $tipoMimeArchivo = mime_content_type($ruta);
    }else{
        $nArchivo = "";
        $tamano = "";
        $ruta = "";
        $formato = "";
    }

?>
<html class="no-scroll">
<!-- TABLA INFORMACIÓN DEL RECURSO -->
    <section class = "containerVerRecurso">
        <table class="tableRecursoVisualizar">
            <tr>
                <th colspan="2" class="containerVerRecursoTitulo">INFORMACIÓN DEL RECURSO</th>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Título:</th>
                <td class="infoColVerRecurso"><?php echo $inforecurso['titulo']; ?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Autor(es):</th>
                <td class="infoColVerRecurso">          
                    <ul class="ulVerRecurso">
                        <?php 
                        if(count($autores) != 0){
                            foreach($autores AS $autor){
                        ?>
                            <a href="<?php echo SERVER_URL."recursosBusqueda/filtroAutor/".$autor['id'] ?>" class="redireccionVerRecurso"><li class="liVerRecurso"><?php echo $autor['nombre']." ".$autor['apellido']; ?></li></a>
                        <?php } 
                        }else{ echo "Autor Desconocido"; }?>
                    </ul>
                </td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Resumen:</th>
                <td class="infoColVerRecurso"><?php echo $inforecurso['resumen']; ?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Año de creación:</th>
                <td class="infoColVerRecurso"><?php echo $inforecurso['fecha_publicacion_recurso']?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Publicado por:</th>
                <td class="infoColVerRecurso"><?php echo $inforecurso['nombre']." ".$inforecurso['apellido']; ?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Fecha de publicación:</th>
                <td class="infoColVerRecurso"><?php echo $inforecurso['fecha_publicacion_profesor']?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Curso(s):</th>
                <td class="infoColVerRecurso">          
                <ul class="ulVerRecurso">
                        <?php 
                            foreach($cursos AS $curso){
                        ?>
                        <a href="<?php echo SERVER_URL."recursosBusqueda/filtroCurso/".$curso['id'] ?>" class="redireccionVerRecurso"><li class="liVerRecurso"><?php echo $curso['nombre']; ?></li></a>
                        <?php } ?>
                    </ul>
                </td>    
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Palabra(s) clave:</th>
                <td class="infoColVerRecurso">
                    <ul class="ulVerRecurso">
                        <?php 
                            foreach($etiquetas AS $etiqueta){
                                $array = explode(" ", $etiqueta['descripcion']);
                                $parametro = "";
                                foreach($array as $dato){
                                    if($parametro!=""){
                                        $parametro .= "¡";
                                    }
                                    $parametro .= $ins_main->encryption($dato);
                                }
                        ?>
                        <a href="<?php echo SERVER_URL."recursosBusqueda/Busqueda/".$parametro; ?>" class="redireccionVerRecurso"><li class="liVerRecurso"><?php echo $etiqueta['descripcion']; ?></li></a>
                        <?php } ?>
                    </ul>
                </td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Editorial:</th>
                <td class="infoColVerRecurso"><?php echo $inforecurso['editorial']; ?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">ISBN:</th>
                <td class="infoColVerRecurso"><?php echo $inforecurso['isbn']; ?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">URI:</th>
                <td class="infoColVerRecurso">
                    <a href="<?php echo SERVER_URL."recursosVisualizacion/".$pagina[1]; ?>" class="redireccionVerRecurso"><?php echo SERVER_URL."recursosVisualizacion/".$pagina[1]; ?></a>
                </td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Identificador:</th>
                <td class="infoColVerRecurso">REC-090320231106</td>
            </tr>
    <!-- ENLACE DEL RECURSO -->
            <tr>
                <th colspan="2" class="containerVerRecursoTitulo">ENLACE DEL RECURSO</th>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">URL:</th>
                <td class="infoColVerRecurso">
                    <a href="<?php echo $inforecurso['enlace']; ?>" target="_blank" class="redireccionVerRecurso"><?php if (isset($inforecurso['enlace'])) echo $inforecurso['enlace']; ?></a>
                </td>
            </tr>
    <!-- ARCHIVO DEL RECURSO -->
            <tr>
                <th colspan="2" class="containerVerRecursoTitulo">ARCHIVO DEL RECURSO</th>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Archivo:</th>
                <td class="infoColVerRecurso">
                    <?php
                        if ($ruta!="" && in_array($tipoMimeArchivo, Utilidades::getTiposMimePermitidos())){
                    ?>
                    <a href="<?php echo SERVER_URL.$ruta?>" target="_blank" class="redireccionVerRecurso"><?php echo $nArchivo; ?></a>
                    <?php
                        }else{
                    ?>
                    <?php echo $nArchivo; ?>
                    <?php
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Tamaño:</th>
                <td class="infoColVerRecurso"><?php if($tamano!="") echo round($tamano / pow(1024,2),2)." MB"; ?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Formato:</th>
                <td class="infoColVerRecurso"><?php echo $formato; ?></td>
            </tr>
            <tr>
                <th class="tituloColVerRecurso">Acción:</th>
                <td class="infoColVerRecurso infoBotonesVerRec">
                    <div class="action-options-container">
                        <div class="btn-group-action">
                            <?php 
                                if($ruta!=""){
                                    // Validar si el tipo de MIME del archivo está permitido para navegadores
                                    if (in_array($tipoMimeArchivo, Utilidades::getTiposMimePermitidos())) {
                            ?>
                            <a href="<?php echo SERVER_URL.$ruta?>" target="_blank" class="btn-admin-view-record" title="Visualizar archivo"><i class="uil uil-eye btnAccionesRecurso btnVisRec"></i></a>
                            <?php 
                                    }
                            ?>
                            <a href="<?php echo SERVER_URL."controladores/descargarArchivo.php?codigo=".$pagina[1];?>" class="btn-admin-view-record" title="Descargar archivo"><i class="uil uil-cloud-download btnAccionesRecurso btnDescRec"></i></a>
                            <?php 
                                }
                            ?>
                            <a href="#" class="btn-admin-view-record buttonFeedbackOpen" title="Calificar recurso"><i class="uil uil-feedback btnAccionesRecurso btnCalRec"></i></a>
                            <form action="<?php echo SERVER_URL."ajax/homeAjax.php";?>" class="FormularioAjax" method="POST" data-form="save" autocomplete="off">
                                <input type="hidden" name="favorito" value="<?php echo $pagina[1]; ?>">
                                <!-- <input type="submit" class="btn-admin-view-record" title="Agregar a favoritos el recurso" value="HOLAAA"> -->
                                <button type="submit" class="btnFavRec" title="Agregar a favoritos el recurso"><i class='uil uil-heart'></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!--MODAL FEEDBACK-->
        <div class="modal-container">
            <div class="modal-feedback modal-close-feedback" >
                <p class="close">X</p>
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/feedback-Img.svg" class="recover-password-pic" alt="Ilustración calificar recurso" />
                    <div class="textosmodal">
                        <h3 class="title-feedback">¿Considera que el recurso es útil?</h3>
                        <p class="phrp-feedback">Por favor seleccione una de las siguientes opciones:</p>
                        <form action="<?php echo SERVER_URL."ajax/homeAjax.php";?>" class="FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <input type="hidden" name="codrecurso" value="<?php echo $pagina[1]; ?>">
                        <div class="input-field">
                            <label class="radio">
                                <input class="inputRadio" type="radio" name="respuestaFeedback" value="Si">
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
<script src="<?php echo SERVER_URL; ?>vistas/assets/js/alertas.js"></script>