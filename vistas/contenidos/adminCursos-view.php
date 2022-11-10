<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    
</head>
    <title>Repositorio Institucional</title>
</head>
<body>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-book-open"></i>
                <h1 class="panel-title-name">Cursos</h1>
            </div>
            <!--BOTÓN CREAR-->
            <div class="new-record-container">
                <label for="btn-modal-admin-add-record" class="btn-add-record" title="Crear curso">
                    <i class="uil uil-plus-circle"></i>Nuevo
                </label>
            </div>
            <!--MODAL CREAR-->
            <input type="checkbox" id="btn-modal-admin-add-record">
                <div class="container-modal-add-record">
                <div class="content-modal-add-record">
                    <h3 class="content-modal-titulo">Nuevo curso</h3>
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field">
                            <input name="nombre" type="text" placeholder="Nombre" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}"  title="Por favor, complete el campo" required/>
                        </div>
                        <div class="input-field">
                            <input name="descripcion" type="text" placeholder="Descripción" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,300}" title="Por favor, complete el campo" required/>
                        </div>
                        <select data-placeholder="Nombre del programa..." multiple class="chosen-select" name="test">
                                    <option value=""></option>
                                    <option>Ingeniería de sistemas</option>
                                    <option>Diseño gráfico</option>
                                    <option>Ingeniería industrial</option>
                                    <option>Diseño industrial</option>
                                    <option>Ingeniería electrónica</option>
                                </select>
                        <select class="livesearch" multiple>
                            <option>Ingeniería de sistemas</option>
                            <option>Diseño gráfico</option>
                            <option>Ingeniería industrial</option>
                        </select>



                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" />
                            <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cerrar</label>
                        </div>
                    </form>
                </div>
            </div>
            </div>

            <select id="my-select" multiple="multiple">
    <option value="1">January</option>
    <option value="2">February</option>
    <option value="3">March</option>
    <option value="4">April</option>
    <option value="5">May</option>
    <option value="6">June</option>
    <option value="7">July</option>
    <option value="8">August</option>
    <option value="9">September</option>
    <option value="10">October</option>
    <option value="11">November</option>
    <option value="12">December</option>
</select>
            <!--TABLA-->
            <?php
                require_once "./controladores/usuarioControlador.php";
                $ins_usuario = new usuarioControlador();

                $cantidadRegistros = 1000;
                if(count($pagina) == 0){
                    $paginaActual = $pagina[1];
                    $datos = $ins_usuario->paginador_usuario_controlador($paginaActual, $cantidadRegistros, 0, $pagina[0], "");
                }else{
                    $paginaActual = -1;
                    $datos = $ins_usuario->paginador_usuario_controlador($paginaActual, $cantidadRegistros, 0, $pagina[0], "");
                }
            ?>
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Programa</th>
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
                            <td data-titulo="DESCRIPCIÓN"><?php echo $rows['documento'] ?></td>
                            <td data-titulo="PROGRAMA"><?php echo $rows['documento'] ?></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>adminEditarCurso/<?php echo $ins_usuario->encryption($rows['id'])?>/" class="btn-admin-edit-record" title="Editar curso"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="idPersona" value="<?php echo $ins_usuario->encryption($rows['id']) ?>">
                                            <input type="hidden" name="idUsuario" value="<?php echo $ins_usuario->encryption($rows['id_usuario']) ?>">
                                            <button type="submit" class="btn-delete-record" title="Eliminar curso"><i class="uil uil-trash-alt"></i></button>
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

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script> -->

    <!-- Include the default stylesheet -->
<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.css">
<!-- Include plugin -->
<script src="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.js"></script>
    <!-- <script type="text/javascript">
        $(".chosen-select").chosen();
        $(".livesearch").chosen();
    </script> -->

    <script>
    // Initialize multiple select on your regular select
    $("#my-select").multipleSelect({
        filter: true
    });
</script>
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/datatables.js"></script> 
</body>
</html>