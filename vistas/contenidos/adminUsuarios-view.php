<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<?php
require_once "./controladores/usuarioControlador.php";
require_once "./controladores/tipoDocumentoControlador.php";
require_once "./utilidades/Utilidades.php";

$ins_usuario = new usuarioControlador();
$ins_tipo_documento = new tipoDocumentoControlador();

$datos_tipo_documento = $ins_tipo_documento->listar_tipo_documento_controlador();
$datos = $ins_usuario->paginador_usuario_controlador();
?>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-users-alt"></i>
                <h1 class="panel-title-name">Usuarios</h1>
            </div>
            <!--BOTÓN CREAR-->
            <div class="new-record-container">
                <label for="btn-modal-admin-add-record" class="btn-add-record" title="Crear usuario">
                    <i class="uil uil-plus-circle"></i>Nuevo
                </label>
            </div>
            <!--MODAL CREAR-->
            <input type="checkbox" id="btn-modal-admin-add-record">
                <div class="container-modal-add-record">
                <div class="content-modal-add-record">
                    <h3 class="content-modal-titulo">Nuevo usuario</h3>
                    <p class="content-modal-recordatorio">Recuerde que * indica que el campo es obligatorio.</p>
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoUsuario" class="combobox-titulo" title="Por favor, seleccione un tipo de usuario" required>
                                    <option selected disabled value="" class="combobox-opciones">Tipo de usuario *</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Docente</option>
                                    <option value="3">Estudiante</option>
                                </select>
                            </div>
                        </div>
                        <input name="estado" type="hidden" value="1">
                        <div class="input-field">
                            <input name="nombre" type="text" placeholder="Nombres *" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}"  title="Por favor, complete el campo" required/>
                        </div>
                        <div class="input-field">
                            <input name="apellido" type="text" placeholder="Apellidos *" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoDocumento" class="combobox-titulo" title="Por favor, seleccione un tipo de documento" required>
                                    <option selected disabled value="" class="combobox-opciones">Tipo de documento *</option>
                                    <?php
                                    foreach($datos_tipo_documento as $campoTD){
                                    ?>
                                    <option value="<?php echo $campoTD['id'] ?>"><?php echo $campoTD['descripcion'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="documento" type="number" placeholder="Número de documento *" pattern="[0-9]+" min="1000" max="100000000000" title="Por favor, complete el campo" required  />
                        </div>
                        <div class="input-field">
                            <input name="correo" type="email" placeholder="Correo electrónico *" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60" title="Por favor, ingrese el correo electrónico" required  />
                        </div>
                        <div class="input-field">
                            <input name="clave" type="password" placeholder="Contraseña *" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="La contraseña debe contener al menos un número, una letra en mayúscula y minúscula, y como mínimo 8 caracteres." required/>
                        </div>
                        <div class="input-field">
                            <input name="confirmarClave" type="password" placeholder="Confirmar contraseña *" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}"  title="Por favor, complete el campo" required />
                        </div>
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" />
                            <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cerrar</label>
                        </div>
                    </form>
                </div>
                <label for="btn-modal-admin-add-record" class="cerrar-modal"></label>
            </div>
            </div>
            <!--TABLA-->
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Tipo Usuario</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador = 1;
                        foreach($datos as $rows){
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo$contador ?></td>
                            <td data-titulo="NOMBRE"><?php echo $rows['nombre'].' '.$rows['apellido'] ?></td>
                            <td data-titulo="DOCUMENTO"><?php echo $rows['numeroDocumento'] ?></td>
                            <td data-titulo="TIPO USUARIO"><?php echo $rows['tipoUsuario'] ?></td>
                            <td data-titulo="ESTADO"><?php echo $estados[$rows['estado']] ?></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>adminEditarUsuario/<?php echo $ins_usuario->encryption($rows['id'])?>/" class="btn-admin-edit-record" title="Editar usuario"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="idPersona" value="<?php echo $ins_usuario->encryption($rows['id']) ?>">
                                            <input type="hidden" name="idUsuario" value="<?php echo $ins_usuario->encryption($rows['id_usuario']) ?>">
                                            <button type="submit" class="btn-delete-record" title="Eliminar usuario"><i class="uil uil-trash-alt"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $contador++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <div>
    </section>
    <!--SCRIPTS NECESARIOS PARA EL DATATABLE-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/datatables.js"></script> 
</body>
</html>