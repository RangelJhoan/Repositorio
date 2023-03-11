<?php

require_once "./controladores/programaControlador.php";
require_once "./utilidades/Utilidades.php";
$ins_programa = new programaControlador();

$datos_programa = $ins_programa->datos_programa_controlador("Unico", $pagina[1]);

if($datos_programa->rowCount()>0){
    $campos = $datos_programa->fetch();
    ?>
<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
            <i class="uil uil-graduation-cap"></i>
                <h1 class="panel-title-name">Editar Programa</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="<?php echo SERVER_URL ?>ajax/programaAjax.php" class="FormularioAjax" method="POST" data-form="update" autocomplete="off">
                        <input type="hidden" name="id_programa_edit" value="<?php echo $pagina[1] ?>">
                        <div class="input-field">
                            <input name="nombre_edit" type="text" value="<?php echo $campos['nombre'] ?>" placeholder="Nombre" title="Por favor, complete el campo" required/>
                        </div>
                        <div class="">
                            <textarea class="textAreaStl" name="descripcion_edit" type="text" placeholder="Descripción" title="Por favor, complete el campo" required><?php echo $campos['descripcion'] ?></textarea>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="estado" class="combobox-titulo" title="Estado del Programa">
                                    <option disabled value="" class="combobox-opciones">Estado</option>
                                    <?php
                                    foreach (Utilidades::getEstados() as $clave => $valor) {
                                    ?>
                                    <option <?php if($campos['estado'] == $clave){echo "selected";} ?> value="<?php echo $clave; ?>"><?php echo $valor; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="botones-accion-modal">
                            <button type="submit" class="btn-admin-edit-record" title="Actualizar">Guardar cambios</button>
                            <a href="<?php echo SERVER_URL ?>adminProgramas/" class="btn-close-edit-record" title="Programas">Volver atrás</a>
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
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar programa.">
            <a href="<?php echo SERVER_URL; ?>adminProgramas/" class="btn-UserNotFound" title="Ir a programas">Volver atrás</a>
        </section>
    </div>
<?php } ?>