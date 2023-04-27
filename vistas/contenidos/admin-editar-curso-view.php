<?php

require_once "./controladores/cursoControlador.php";
require_once "./controladores/programaControlador.php";
require_once "./controladores/usuarioControlador.php";
require_once "./utilidades/Utilidades.php";

$ins_curso = new cursoControlador();
$ins_programa = new programaControlador();
$insUsuario = new usuarioControlador();

$datos_curso = $ins_curso->datosCursoControlador("Unico", $pagina[1]);
$datos_programas = $ins_programa->listar_programas_controlador();
$datosUsuarios = $insUsuario->obtenerPersonasXTipoUsuario("DOCENTE");

if($datos_curso->rowCount()>0){
    $campos_curso = $datos_curso->fetch();
    $programas_curso = $ins_curso->programasCursoControlador($campos_curso['id']);
    $docentesCurso = $ins_curso->docentesCursoControlador($campos_curso['id']);
    ?>
<section class="general-admin-container">
    <div class="overview-general-admin">
        <!--TÍTULO-->
        <div class="title">
            <i class="uil uil-book-open"></i>
            <h1 class="panel-title-name">Editar Curso</h1>
        </div>
        <div class="container-modal-edit-record" id="modal-container-edit-user">
            <div class="content-modal-edit-record">
                <form action="<?php echo SERVER_URL ?>ajax/cursoAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                    <input type="hidden" name="id_curso_edit" value="<?php echo $pagina[1] ?>">
                    <div class="input-field">
                        <input name="nombre_edit" type="text" placeholder="Nombre" value="<?php echo $campos_curso['nombre'] ?>"  title="Nombre" required/>
                    </div>
                    <div class="">
                            <textarea class="textAreaStl" name="descripcion_edit" type="text" required><?php echo $campos_curso['descripcion'] ?></textarea>
                    </div>

                    <label for="programaSeleccion" class="titleComboMultiple">Programa (s)</label>
                        <select name="programas_edit[]" id="programaSeleccionarCbxCurso" multiple="multiple" title="Por favor, selecciona el o los programas asociados al curso">
                            <?php
                            foreach($datos_programas as $campos){
                                $selected = false;
                                foreach($programas_curso as $campos_pc){
                                    if($campos['id'] == $campos_pc['programa_id']){
                                        $selected = true;
                                    }
                                }
                                ?>
                            <option <?php if($selected) echo "selected" ?> value="<?php echo $campos['id'] ?>"><?php echo $campos['nombre'] ?></option>
                                <?php
                            }
                            ?>
                        </select>

                    <label for="docenteSeleccion" class="titleComboMultiple">Docente (s)</label>
                        <select name="docentes_edit[]" id="docenteSeleccionarCbxCurso" multiple="multiple" title="Por favor, selecciona el o los programas asociados al curso">
                            <?php
                            foreach($datosUsuarios as $campos){
                                $selected = false;
                                foreach($docentesCurso as $campos_dc){
                                    if($campos['id'] == $campos_dc['idPersona']){
                                        $selected = true;
                                    }
                                }
                                ?>
                            <option <?php if($selected) echo "selected" ?> value="<?php echo $campos['id'] ?>"><?php echo $campos['nombre'] . " " . $campos['apellido']?></option>
                                <?php
                            }
                            ?>
                        </select>
                    <!--Select tag-->
                    <div class="input-field ">
                        <div class="select-option">
                            <select name="estado" class="combobox-titulo" title="Estado del curso">
                                <option disabled value="" class="combobox-opciones">Estado</option>
                                <?php
                                foreach (Utilidades::getEstadosEdicion() as $clave => $valor) {
                                ?>
                                <option <?php if($campos_curso['estado'] == $clave){echo "selected";} ?> value="<?php echo $clave; ?>"><?php echo $valor; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="botones-accion-modal">
                        <button type="submit" class="btn-admin-edit-record" title="Actualizar">Guardar cambios</button>
                        <a href="<?php echo SERVER_URL ?>admin-cursos/" class="btn-close-edit-record" title="Cursos">Volver atrás</a>
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
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar curso.">
            <a href="<?php echo SERVER_URL; ?>admin-cursos/" class="btn-UserNotFound" title="Ir a cursos">Volver atrás</a>
        </section>
    </div>
<?php } ?>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleComboCurso.js"></script> 
