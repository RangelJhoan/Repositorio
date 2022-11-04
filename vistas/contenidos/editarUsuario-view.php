<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminUsuarios-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<section class="users-container">
        <div class="overviewUsers">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-users-alt"></i>
                <h1 class="panel-title-name">Editar Usuario</h1>
            </div>
            <div class="container-modal-editar-usuario" id="modal-container-edit-user">
                <div class="content-modal-editar-usuario">
                    <form action="" class="editar-usuario">
                        <div class="input-field">
                            <div class="select-option">
                                <select name="tipoUsuario" class="combobox-titulo" title="Tipo de usuario">
                                    <option selected disabled value="" class="combobox-opciones">Tipo de usuario</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Docente">Docente</option>
                                    <option value="Estudiante">Estudiante</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="nombre" type="text" placeholder="Nombres" pattern="^[a-zA-Z\s]+" minlength="3" maxlength="30" title="Nombres"/>
                        </div>
                        <div class="input-field">
                            <input name="apellido" type="text" placeholder="Apellidos" pattern="^[a-zA-Z\s]+" minlength="3" title="Apellidos" />
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
                            <input name="documento" type="number" placeholder="Número de documento" minlength="10" maxlength="15"  pattern="[0-9]+" title="Número de documento"/>
                        </div>
                        <div class="input-field">
                            <input name="correo" type="email" placeholder="Correo electrónico" minlength="8" maxlength="60"  title="Correo electrónico"/>
                        </div>
                        <div class="input-field">
                            <input name="clave" type="password" placeholder="Contraseña" minlength="8" maxlength="80"  title="Contraseña"/>
                        </div>
                        <div class="input-field">
                            <input name="confirmarClave" type="password" placeholder="Confirmar contraseña" minlength="8" maxlength="80"  title="Confirmar"/>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="estado" class="combobox-titulo" title="Estado">
                                    <option selected disabled value="" class="combobox-opciones">Estado</option>
                                    <option value="0">Inactivo</option>
                                    <option value="1">Activo</option>
                                </select>
                            </div>
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
</body>
</html>