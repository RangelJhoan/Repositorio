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
                <label for="btn-modal-crear-usuario" class="btn-agregar-usuario">
                    <i class="uil uil-plus-circle"></i>Nuevo
                </label>
            </div>
            <!--MODAL CREAR-->
            <input type="checkbox" id="btn-modal-crear-usuario">
            <div class="container-modal-crear-usuario">
                <div class="content-modal-crear-usuario">
                    <h3 class="content-modal-titulo">Nuevo usuario</h3>
                    <form action="" class="crear-usuario">
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoUsuario" class="combobox-titulo">
                                    <option selected disabled value="" class="combobox-opciones">Tipo de usuario</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Docente">Docente</option>
                                    <option value="Estudiante">Estudiante</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="nombre" type="text" placeholder="Nombres" />
                        </div>
                        <div class="input-field">
                            <input name="apellido" type="text" placeholder="Apellidos" />
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="tipoDocumento" class="combobox-titulo">
                                    <option selected disabled value="" class="combobox-opciones">Tipo de documento</option>
                                    <option value="TI">Tarjeta de Identidad (TI)</option>
                                    <option value="CC">Cédula de Ciudadanía (CC)</option>
                                    <option value="CE">Tarjeta de Extranjería (CE)</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-field">
                            <input name="documento" type="number" placeholder="Número de documento" />
                        </div>
                        <div class="input-field">
                            <input name="correo" type="email" placeholder="Correo electrónico" />
                        </div>
                        <div class="input-field">
                            <input name="clave" type="password" placeholder="Contraseña" />
                        </div>
                        <div class="input-field">
                            <input name="confirmarClave" type="password" placeholder="Confirmar contraseña" />
                        </div>
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-crear-usuario" value="Crear" />
                            <label for="btn-modal-crear-usuario" class="btn-cerrar-crear-usuario">Cerrar</label>
                        </div>
            
                    </form>
                </div>
            </div>
            <!--TABLA-->
            <?php
                require_once "./controladores/usuarioControlador.php";
                $ins_usuario = new usuarioControlador();

                if(count($pagina) > 1){
                    echo $ins_usuario->paginador_usuario_controlador($pagina[1], 15, 3, $pagina[0], "");
                }else{
                    echo $ins_usuario->paginador_usuario_controlador(-1, 15, 3, $pagina[0], "");
                }
            ?>

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