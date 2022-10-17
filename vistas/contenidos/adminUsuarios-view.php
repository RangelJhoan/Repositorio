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
                <button onclick="location.href='crearxD'" type="button" class="btn-agregar-usuario" data-toggle="modal" data-target="#modal" data-dismiss="modalclose"><i class="uil uil-plus-circle"></i>Nuevo</button>
            </div>
            <!--TABLA-->

            <div class="tablaUsuariosContainer">
                <!-- <table id="tablaUsuarios" class="table table-striped display responsive nowrap" style="width:100%"> -->
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
                        <tr>
                            <td data-titulo="ID">1</td>
                            <td data-titulo="NOMBRE">Camilo Valencia</td>
                            <td data-titulo="DOCUMENTO">1005163899</td>
                            <td data-titulo="TIPO">Estudiante</td>
                            <td data-titulo="ESTADO"><span class="active"></span></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                        </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                        </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">2</td>
                            <td data-titulo="NOMBRE">Jhoan Rangel</td>
                            <td data-titulo="DOCUMENTO">1007777888</td>
                            <td data-titulo="TIPO">Docente</td>
                            <td data-titulo="ESTADO"><span class="inactive"></span></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">1</td>
                            <td data-titulo="NOMBRE">Camilo Valencia</td>
                            <td data-titulo="DOCUMENTO">1005163899</td>
                            <td data-titulo="TIPO">Estudiante</td>
                            <td data-titulo="ESTADO"><span class="active"></span></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                        </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                        </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">2</td>
                            <td data-titulo="NOMBRE">Jhoan Rangel</td>
                            <td data-titulo="DOCUMENTO">1007777888</td>
                            <td data-titulo="TIPO">Docente</td>
                            <td data-titulo="ESTADO"><span class="inactive"></span></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td data-titulo="ID">3</td>
                            <td data-titulo="NOMBRE">Jonnathan Ramos</td>
                            <td data-titulo="DOCUMENTO">1098801777</td>
                            <td data-titulo="TIPO">Administrador</td>
                            <td data-titulo="ESTADO">Inactivo</td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <button class="btn-editar-usuario"><i class="uil uil-edit"></i></button>
                                    </div>
                                    <div class="btn-group-action">
                                        <button class="btn-eliminar-usuario"><i class="uil uil-trash-alt"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!--MODAL CREAR-->

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