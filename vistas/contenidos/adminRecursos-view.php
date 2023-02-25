<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
</head>
    <title>Repositorio Institucional</title>
</head>
<body>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-file-blank"></i>
                <h1 class="panel-title-name">Recursos</h1>
            </div>
            <!--BOTÓN CREAR-->
            <div class="new-record-container">
                <a class="btn-add-record" title="Crear recurso" href="<?php echo SERVER_URL ?>crearRecurso/">
                <i class="uil uil-plus-circle"></i></i></i>Nuevo
                </a>
                <a class="btn-add-record" title="Ir a autores" href="<?php echo SERVER_URL ?>adminAutores/">
                <i class="uil uil-pen"></i></i></i>Autores
                </a>
                <a class="btn-add-record" title="Ir a etiquetas" href="<?php echo SERVER_URL ?>panelEtiquetas/">
                <i class="uil uil-tag"></i></i></i>Etiquetas
                </a>
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
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Archivo</th>
                            <th>Positivos</th>
                            <th>Negativos</th>
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
                            <td data-titulo="TÍTULO"><?php echo $rows['nombre_curso'] ?></td>
                            <td data-titulo="AUTOR"><?php echo $rows['descripcion_curso'] ?></td>
                            <td data-titulo="ARCHIVO"><?php echo $rows['nombre_programa'] ?></td>
                            <td data-titulo="POSITIVOS"><?php echo "12" ?></td>
                            <td data-titulo="NEGATIVOS"><?php echo "4" ?></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="" class="btn-admin-view-record" title="Ir al recurso"><i class="uil uil-eye btn-admin-view-record"></i></a>
                                    </div>
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>adminEditarCurso/<?php echo $ins_curso->encryption($rows['id_curso'])?>/" class="btn-admin-edit-record" title="Editar recurso"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/cursoAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="id_curso_del" value="<?php echo $ins_curso->encryption($rows['id_curso']) ?>">
                                            <button type="submit" class="btn-delete-record" title="Eliminar recurso"><i class="uil uil-trash-alt"></i></button>
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
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/uploadFile.js"></script> 


</body>
</html>