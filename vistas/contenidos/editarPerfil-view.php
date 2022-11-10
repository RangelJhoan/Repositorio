<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminEditarMiPerfil-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
            <i class="uil uil-user"></i>
                <h1 class="panel-title-name">Editar Mi Perfil</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="" class="editar-usuario">
                        <div class="input-field">
                            <input name="nombre" type="text" placeholder="Nombres" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Nombres"/>
                        </div>
                        <div class="input-field">
                            <input name="apellido" type="text" placeholder="Apellidos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Apellidos" />
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoDocumento" class="combobox-titulo" title="Tipo de documento">
                                    <option selected disabled value="" class="combobox-opciones">Tipo de documento</option>
                                    <option value="TI">Tarjeta de Identidad (TI)</option>
                                    <option value="CC">Cédula de Ciudadanía (CC)</option>
                                    <option value="CE">Tarjeta de Extranjería (CE)</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="documento" type="number" placeholder="Número de documento" min="1000" max="100000000000"  pattern="[0-9]+" title="Número de documento"/>
                        </div>
                        <div class="input-field">
                            <div class="icon-locked">
                                <i class="uil uil-lock icon-no-edit-allowed"></i>    
                            </div>    
                            <input name="correo" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60"  title="No se permite editar el correo electrónico"/>
                        </div>
                        <div class="input-field">
                            <input name="clave" type="password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Recuerde que la contraseña debe contener al menos un número, una letra en mayúscula y minúscula, y como mínimo 8 caracteres."/>
                        </div>
                        <div class="input-field">
                            <input name="confirmarClave" type="password" placeholder="Confirmar contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Confirmar contraseña"/>
                        </div>
                        <div class="botones-accion-modal">
                            <button type="submit" class="btn-admin-edit-record">Guardar cambios</button>
                            <!-- <a href="<?php echo SERVER_URL ?>adminUsuarios/" class="btn-classcerrar-editar-usuario" title="Volver atrás">Volver atrás</a> -->
                            <a href="#" class="btn-close-edit-record" title="Volver atrás">Volver atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        <div>
    </section>
</body>
</html>