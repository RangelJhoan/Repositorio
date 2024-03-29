<?php

require_once "./controladores/autorControlador.php";
require_once "./utilidades/Utilidades.php";
$ins_autor = new autorControlador();

$datos_autor = $ins_autor->datosAutorControlador("Unico", $pagina[1]);

if($datos_autor->rowCount()>0){
    $campos = $datos_autor->fetch();
    ?>
<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-pen"></i>
                <h1 class="panel-title-name">Editar Autor</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="<?php echo SERVER_URL ?>ajax/autorAjax.php" class="FormularioAjax" method="POST" data-form="update" autocomplete="off">
                    <input type="hidden" name="id_autor_edit" value="<?php echo $pagina[1] ?>">
                    <div class="input-field">
                            <input name="nombre_edit" type="text" value="<?php echo $campos['nombre'] ?>" placeholder="Nombres" title="Por favor, complete el campo"/>
                        </div>
                        <div class="input-field">
                            <input name="apellido_edit" type="text" value="<?php echo $campos['apellido'] ?>" placeholder="Apellidos *" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="estado" class="combobox-titulo" title="Estado del curso">
                                    <option disabled value="" class="combobox-opciones">Estado</option>
                                    <?php
                                    foreach (Utilidades::getEstadosEdicion() as $clave => $valor) {
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
                            <a href="javascript:history.back()" class="btn-close-edit-record" title="Autores">Volver atrás</a>
                        </div>
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
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar autor.">
            <a href="javascript:history.back()" class="btn-UserNotFound" title="Volver">Volver atrás</a>
        </section>
    </div>
<?php } ?>