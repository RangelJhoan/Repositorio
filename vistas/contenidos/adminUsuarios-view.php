<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminUsuarios-Style.css">
    <!--BOOTSTRAP-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css"> -->
    <title>Repositorio Institucional</title>
</head>
<body>
    <section class="users-container">
        <div class="overviewUsers">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-users-alt"></i>
                <h1 class="panel-title-name">Usuarios</h1>
            </div>
            <!--BOTÓN CREAR-->
            <div class="new-user-container">
                <label for="btn-modal-crear-usuario" class="btn-agregar-usuario" title="Crear usuario">
                    <i class="uil uil-plus-circle"></i>Nuevo
                </label>
            </div>
            <!--MODAL CREAR-->
            <input type="checkbox" id="btn-modal-crear-usuario">
                <div class="container-modal-crear-usuario">
                <div class="content-modal-crear-usuario">
                    <h3 class="content-modal-titulo">Nuevo usuario</h3>
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoUsuario" class="combobox-titulo" title="Por favor, seleccione un tipo de usuario" required>
                                    <option selected value="" class="combobox-opciones">Tipo de usuario</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Docente</option>
                                    <option value="3">Estudiante</option>
                                </select>
                            </div>
                        </div>
                        <input name="estado" type="hidden" value="1">
                        <div class="input-field">
                            <input name="nombre" type="text" placeholder="Nombres" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}"  title="Por favor, complete el campo" required/>
                        </div>
                        <div class="input-field">
                            <input name="apellido" type="text" placeholder="Apellidos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoDocumento" class="combobox-titulo" title="Por favor, seleccione un tipo de documento" required>
                                    <option selected value="" class="combobox-opciones">Tipo de documento</option>
                                    <option value="TI">Tarjeta de Identidad (TI)</option>
                                    <option value="CC">Cédula de Ciudadanía (CC)</option>
                                    <option value="CE">Tarjeta de Extranjería (CE)</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="documento" type="number" placeholder="Número de documento" pattern="[0-9]+" minlength="10" maxlength="15"title="Por favor, complete el campo" required  />
                        </div>
                        <div class="input-field">
                            <input name="correo" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60" title="Por favor, ingrese el correo electrónico" required  />
                        </div>
                        <div class="input-field">
                            <input name="clave" type="password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="La contraseña debe contener al menos un número, una letra en mayúscula y minúscula, y como mínimo 8 caracteres." required/>
                        </div>
                        <div class="input-field">
                            <input name="confirmarClave" type="password" placeholder="Confirmar contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}"  title="Por favor, complete el campo" required />
                        </div>
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-crear-usuario" value="Crear" />
                            <label for="btn-modal-crear-usuario" class="btn-cerrar-crear-usuario">Cerrar</label>
                        </div>
                    </form>
                </div>
            </div>
            </div>
            <!--TABLA-->
            <?php
                require_once "./controladores/usuarioControlador.php";
                $ins_usuario = new usuarioControlador();

                $cantidadRegistros = 1000;
                if(count($pagina) > 1){
                    $paginaActual = $pagina[1];
                    $datos = $ins_usuario->paginador_usuario_controlador($paginaActual, $cantidadRegistros, 9, $pagina[0], "");
                }else{
                    $paginaActual = -1;
                    $datos = $ins_usuario->paginador_usuario_controlador($paginaActual, $cantidadRegistros, 9, $pagina[0], "");
                }
            ?>
            <div class="tablaUsuariosContainer">
                <table id="tablaUsuarios" class="tbUsuarios" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $inicio = ($paginaActual>0) ? (($paginaActual*$cantidadRegistros)-$cantidadRegistros) : 0;
                        $contador = $inicio+1;
                        if($datos != 0){
                            foreach($datos as $rows){
                                $estado = "";
                                if($rows['estado'] == "0"){
                                    $estado = "inactive";
                                }else{
                                    $estado = "active";
                                }
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="NOMBRE"><?php echo $rows['nombre'].' '.$rows['apellido'] ?></td>
                            <td data-titulo="DOCUMENTO"><?php echo $rows['documento'] ?></td>
                            <td data-titulo="TIPO"><?php echo $rows['descripcion'] ?></td>
                            <td data-titulo="ESTADO"><span class="<?php echo $estado ?>"></span></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <!-- <button id="btn-abrir-editar-usuario" class="btn-editar-usuario" title="Editar usuario"><i class="uil uil-edit"></i></button> -->
                                        <!-- <a href="editar-usuario.php?id=<?php echo $row["id_usuario"];?>" class="btn-editar-usuario" title="Editar usuario"><i class="uil uil-edit"></i></a> -->
                                        <a href="<?php echo SERVER_URL ?>editarUsuario/" class="btn-editar-usuario" title="Editar usuario"><i class="uil uil-edit btn-editar-usuario"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="idPersona" value="<?php echo $ins_usuario->encryption($rows['id']) ?>">
                                            <input type="hidden" name="idUsuario" value="<?php echo $ins_usuario->encryption($rows['id_usuario']) ?>">
                                            <button type="submit" class="btn-eliminar-usuario" title="Eliminar usuario"><i class="uil uil-trash-alt"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                            $contador++;
                            }
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