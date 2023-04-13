<?php

require_once "./controladores/usuarioControlador.php";
require_once "./controladores/tipoDocumentoControlador.php";
require_once "./utilidades/Utilidades.php";

$ins_usuario = new usuarioControlador();
$ins_tipo_documento = new tipoDocumentoControlador();

$datos_usuario = $ins_usuario->datos_usuario_controlador("Unico", $pagina[1]);
$datos_tipo_documento = $ins_tipo_documento->listar_tipo_documento_controlador();

if($datos_usuario->rowCount()>0){
    $campos = $datos_usuario->fetch();
    ?>
<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-users-alt"></i>
                <h1 class="panel-title-name">Editar Usuario</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="FormularioAjax" method="POST" data-form="update" autocomplete="off">
                        <input type="hidden" name="id_usuario_editar" value="<?php echo $pagina[1] ?>">
                        
                        <!--Select tag-->
                        <div class="input-field" title="No se permite editar el tipo de usuario">
                            <div class="icon-locked">
                                    <i class="uil uil-lock icon-no-edit-allowed"></i>
                                </div>
                                <div class="select-option-disabledEdit">
                                <select disabled name="tipoUsuario" class="combobox-titulo input-disabledEdit" title="No se permite editar el tipo de usuario">
                                    <option disabled value="" class="combobox-opciones input-blocked input-disabledEdit">Tipo de usuario</option>
                                    <option <?php if($campos['descripcion'] == 'Administrador'){echo "selected";} ?> value="Administrador">Administrador</option>
                                    <option <?php if($campos['descripcion'] == 'Docente'){echo "selected";} ?> value="Docente">Docente</option>
                                    <option <?php if($campos['descripcion'] == 'Estudiante'){echo "selected";} ?> value="Estudiante">Estudiante</option>
                                </select>
                            </div>
                        </div>

                        <div class="input-field">
                            <input name="nombre" value="<?php echo $campos['nombre']; ?>" type="text" placeholder="Nombres" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Nombres"/>
                        </div>
                        <div class="input-field">
                            <input name="apellido" value="<?php echo $campos['apellido']; ?>" type="text" placeholder="Apellidos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Apellidos" />
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoDocumento" class="combobox-titulo" title="Tipo de documento">
                                    <option selected disabled value="" class="combobox-opciones">Tipo de documento</option>
                                    <?php
                                    foreach($datos_tipo_documento as $campoTD){
                                    ?>
                                    <option <?php if($campoTD['descripcion'] == $campos['descripcionTipoDocumento']){echo "selected";}  ?> value="<?php echo $campoTD['id'] ?>"><?php echo $campoTD['descripcion'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="input-field">
                            <input name="documento" value="<?php echo $campos['documento']; ?>" type="number" placeholder="Número de documento" min="1000" max="100000000000"  pattern="[0-9]+" title="Número de documento"/>
                        </div>

                        <div class="input-field" title="No se permite editar el correo <?php echo $campos['correo']; ?>">
                                <div class="icon-locked">
                                    <i class="uil uil-lock icon-no-edit-allowed"></i>
                                </div>
                                <input class="input-disabledEdit" disabled name="correo" value="<?php echo $campos['correo']; ?>" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60"  title="No se permite editar el correo electrónico"/>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                            <select name="estado" class="combobox-titulo" title="Estado del curso">
                                    <option disabled value="" class="combobox-opciones">Estado</option>
                                    <?php
                                    foreach (Utilidades::getEstadosUsuario() as $clave => $valor) {
                                    ?>
                                    <option <?php if($campos['estado'] == $clave){echo "selected";} ?> value="<?php echo $clave; ?>"><?php echo $valor; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input class="input-psswd-editUser" name="clave" type="password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Recuerde que la contraseña debe contener al menos un número, una letra en mayúscula y minúscula, y como mínimo 8 caracteres."/>
                            <span class="toggle-password" aria-label="Mostrar/Ocultar contraseña"><i class="uil uil-eye-slash"></i></span>
                        </div>
                        <div class="input-field">
                            <input class="input-psswd-editUser" name="confirmarClave" type="password" placeholder="Confirmar contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Confirmar contraseña"/>
                            <span class="toggle-password" aria-label="Mostrar/Ocultar contraseña"><i class="uil uil-eye-slash"></i></span>
                        </div>
                        <div class="botones-accion-modal">
                            <button type="submit" class="btn-admin-edit-record" title="Actualizar">Guardar cambios</button>
                            <a href="<?php echo SERVER_URL ?>admin-usuarios/" class="btn-close-edit-record" title="Usuarios">Volver atrás</a>
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
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar usuario.">
            <a href="<?php echo SERVER_URL; ?>admin-usuarios/" class="btn-UserNotFound" title="Ir a usuarios">Volver atrás</a>
        </section>
    </div>
<?php } ?>