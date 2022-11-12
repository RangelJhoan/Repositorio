<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
</head>
    <title>Repositorio Institucional</title>
</head>
<body>
<?php

require_once "./controladores/programaControlador.php";
$ins_programa = new programaControlador();

$datos_programas = $ins_programa->listar_programas_controlador();
    ?>
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
                    <form action="<?php echo SERVER_URL ?>ajax/cursoAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field">
                            <input name="nombre_ins" type="text" placeholder="Nombre" title="Por favor, complete el campo" required/>
                        </div>
                        <div class="input-field">
                            <input name="descripcion_ins" type="text" placeholder="Descripción" title="Por favor, complete el campo" required/>
                        </div>

                        <label for="programaSeleccion" class="titleComboMultiple">Programa(s)</label>
                            <select name="programas_ins[]" id="programaSeleccionarCur" multiple="multiple" title="Por favor, selecciona el o los programas asociados al curso">
                                <?php
                                foreach($datos_programas as $campos){
                                ?>
                                <option value="<?php echo $campos['id'] ?>"><?php echo $campos['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" />
                            <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cerrar</label>
                        </div>
                    </form>
                </div>
            </div>
            </div>

            <!--TABLA-->
            <?php
                require_once "./controladores/cursoControlador.php";
                $ins_curso = new cursoControlador();

                $cantidadRegistros = 1000;
                if(count($pagina) == 0){
                    $paginaActual = $pagina[1];
                    $datos = $ins_curso->paginador_curso_controlador($paginaActual, $cantidadRegistros, 0, $pagina[0], "");
                }else{
                    $paginaActual = -1;
                    $datos = $ins_curso->paginador_curso_controlador($paginaActual, $cantidadRegistros, 0, $pagina[0], "");
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
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="NOMBRE"><?php echo $rows['nombre_curso'] ?></td>
                            <td data-titulo="DESCRIPCIÓN"><?php echo $rows['descripcion_curso'] ?></td>
                            <td data-titulo="PROGRAMA"><?php echo $rows['nombre_programa'] ?></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>adminEditarCurso/<?php echo $ins_curso->encryption($rows['id_curso'])?>/" class="btn-admin-edit-record" title="Editar curso"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/usuarioAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="idPersona" value="<?php echo $ins_curso->encryption($rows['id_curso']) ?>">
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

    <!-- <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script> -->

    <script src="<?php echo SERVER_URL ?>vistas/assets/js/datatables.js"></script> 
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleCombo.js"></script> 


</body>
</html>