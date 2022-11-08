<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<?php

require_once "./controladores/usuarioControlador.php";
$ins_usuario = new usuarioControlador();

$datos_usuario = $ins_usuario->datos_usuario_controlador("Unico", $pagina[1]);

if($datos_usuario->rowCount()>0){
    $campos = $datos_usuario->fetch();
    ?>
<section class="users-container">
        <div class="overviewUsers">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-users-alt"></i>
                <h1 class="panel-title-name">Editar Usuario</h1>
            </div>
            <div class="container-modal-editar-usuario" id="modal-container-edit-user">
                <div class="content-modal-editar-usuario">
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="editar-usuario FormularioAjax" method="POST" data-form="update" autocomplete="off">
                        <input type="hidden" name="id_usuario_editar" value="<?php echo $pagina[1] ?>">
                        <div class="input-field">
                            <div class="select-option">
                                <select disabled name="tipoUsuario" class="combobox-titulo" title="Tipo de usuario">
                                    <option disabled value="" class="combobox-opciones">Tipo de usuario</option>
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
                                    <option disabled value="" class="combobox-opciones">Tipo de documento</option>
                                    <option <?php if($campos['tipo_documento'] == 'TI'){echo "selected";} ?> value="TI">Tarjeta de Identidad (TI)</option>
                                    <option <?php if($campos['tipo_documento'] == 'CC'){echo "selected";} ?> value="CC">Cédula de Ciudadanía (CC)</option>
                                    <option <?php if($campos['tipo_documento'] == 'CE'){echo "selected";} ?> value="CE">Tarjeta de Extranjería (CE)</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="documento" value="<?php echo $campos['documento']; ?>" type="number" placeholder="Número de documento" min="1000" max="100000000000"  pattern="[0-9]+" title="Número de documento"/>
                        </div>
                        <div class="input-field">
                            <input disabled name="correo" value="<?php echo $campos['correo']; ?>" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60"  title="Correo electrónico"/>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="estado" class="combobox-titulo" title="Estado del usuario">
                                    <option disabled value="" class="combobox-opciones">Estado</option>
                                    <option <?php if($campos['estado'] == '0'){echo "selected";} ?> value="0">Inactivo</option>
                                    <option <?php if($campos['estado'] == '1'){echo "selected";} ?> value="1">Activo</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="clave" type="password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Recuerde que la contraseña debe contener al menos un número, una letra en mayúscula y minúscula, y como mínimo 8 caracteres."/>
                        </div>
                        <div class="input-field">
                            <input name="confirmarClave" type="password" placeholder="Confirmar contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Confirmar contraseña"/>
                        </div>
                        <div class="botones-accion-modal">
                            <button type="submit" class="btn-editar-usuario">Guardar cambios</button>
                            <a href="<?php echo SERVER_URL ?>adminUsuarios/" class="btn-classcerrar-editar-usuario" title="Volver atrás">Volver atrás</a>
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
            <p class="message-user-not-found">Ha ocurrido un error inesperado.</p>
        </section>
        <section class="img-section">
            <img class="img-errorEditUser"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarUsuario.svg" alt="Error al intentar editar usuario.">
            <a href="<?php echo SERVER_URL; ?>adminUsuarios/" class="btn-UserNotFound">Volver atrás</a>
        </section>
    </div>
<?php } ?>
</body>
</html>