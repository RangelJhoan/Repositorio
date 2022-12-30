<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<?php

require_once "./controladores/cursoControlador.php";
require_once "./controladores/programaControlador.php";

$ins_curso = new cursoControlador();
$ins_programa = new programaControlador();

$datos_curso = $ins_curso->datos_curso_controlador("Unico", $pagina[1]);
$datos_programas = $ins_programa->listar_programas_controlador();

if($datos_curso->rowCount()>0){
    $campos_curso = $datos_curso->fetch();
    $programas_curso = $ins_curso->programas_curso_controlador($campos_curso['id']);
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
                    <div class="input-field">
                        <input name="descripcion_edit" type="text" placeholder="Descripción" value="<?php echo $campos_curso['descripcion'] ?>" title="Descripción" required/>
                    </div>
                    <label for="programaSeleccion" class="titleComboMultiple">Programa(s)</label>
                        <select name="programas_edit[]" id="programaSeleccionarCur" multiple="multiple" title="Por favor, selecciona el o los programas asociados al curso">
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
                    <div class="botones-accion-modal">
                        <button type="submit" class="btn-admin-edit-record" title="Actualizar">Guardar cambios</button>
                        <a href="<?php echo SERVER_URL ?>adminCursos/" class="btn-close-edit-record" title="Cursos">Volver atrás</a>
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
            <a href="<?php echo SERVER_URL; ?>adminCursos/" class="btn-UserNotFound" title="Ir a cursos">Volver atrás</a>
        </section>
    </div>
<?php } ?>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleCombo.js"></script> 

</body>
</html>