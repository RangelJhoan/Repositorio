<?php
require_once "./controladores/tipoDocumentoControlador.php";

$ins_tipo_documento = new tipoDocumentoControlador();

$datos_tipo_documento = $ins_tipo_documento->listar_tipo_documento_controlador();
?>
<section class="general-admin-container dashboard-container">
        <div class="overview-general-admin overview">
            <!--TÍTULO-->
            <div class="title">
            <i class="uil uil-user"></i>
                <h1 class="panel-title-name">Editar Mi Perfil</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="editar-usuario FormularioAjax" method="POST" data-form="update" autocomplete="off">
                    <input type="hidden" name="id_usuario_edit_perfil" value="<?php echo $ins_tipo_documento->encryption($_SESSION['id_persona']) ?>">
                        <div class="input-field">
                            <input name="nombre_edit_perfil" value="<?php echo $_SESSION['nombre_usuario'] ?>" type="text" placeholder="Nombres" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Nombres"/>
                        </div>
                        <div class="input-field">
                            <input name="apellido_edit_perfil" value="<?php echo $_SESSION['apellido_usuario'] ?>" type="text" placeholder="Apellidos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Apellidos" />
                        </div>
                        <!--Select tag-->
                        <div class="input-field" title="No se permite editar el tipo de documento">
                            <div class="icon-locked">
                                <i class="uil uil-lock icon-no-edit-allowed"></i>
                            </div>
                            <div class="select-option-disabledEdit">
                                <select name="tipoDocumento_edit_perfil" class="combobox-titulo input-disabledEdit" disabled>
                                    <option selected disabled value="" class="combobox-opciones">Tipo de documento</option>
                                    <?php
                                    foreach($datos_tipo_documento as $campoTD){
                                    ?>
                                    <option <?php if($campoTD['descripcion'] == $_SESSION['tipo_documento']){echo "selected";}  ?> value="<?php echo $campoTD['id'] ?>"><?php echo $campoTD['descripcion'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-field" title="No se permite editar el número de documento">
                            <div class="icon-locked">
                                <i class="uil uil-lock icon-no-edit-allowed"></i>
                            </div>
                            <input class="input-disabledEdit" name="documento_edit_perfil" value="<?php echo $_SESSION['documento_usuario'] ?>" disabled type="number" placeholder="Número de documento" min="1000" max="100000000000"  pattern="[0-9]+" title="Número de documento"/>
                        </div>
                        <div class="input-field" title="No se permite editar el correo electrónico">
                            <div class="icon-locked">
                                <i class="uil uil-lock icon-no-edit-allowed"></i>
                            </div>
                            <input class="input-disabledEdit" name="correo_edit_perfil" value="<?php echo $_SESSION['correo_usuario'] ?>" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60"  title="No se permite editar el correo electrónico"/>
                        </div>
                        <div class="input-field">
                            <input name="clave_edit_perfil" type="password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Recuerde que la contraseña debe contener al menos un número, una letra en mayúscula y minúscula, y como mínimo 8 caracteres."/>
                        </div>
                        <div class="input-field">
                            <input name="confirmarClave_edit_perfil" type="password" placeholder="Confirmar contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Confirmar contraseña"/>
                        </div>
                        <div class="botones-accion-modal">
                            <button type="submit" class="btn-admin-edit-record">Guardar cambios</button>
                            <!-- <a href="<?php echo SERVER_URL ?>adminUsuarios/" class="btn-classcerrar-editar-usuario" title="Volver atrás">Volver atrás</a> -->
                            <a href="javascript:history.back()" class="btn-close-edit-record" title="Volver atrás">Volver atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        <div>
    </section>