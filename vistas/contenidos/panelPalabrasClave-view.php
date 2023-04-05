<?php
    require_once "./controladores/etiquetaControlador.php";
    require_once "./utilidades/Utilidades.php";
    $ins_etiqueta = new etiquetaControlador();
    $datos = $ins_etiqueta->paginador_etiqueta_controlador(null);
?>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-tag"></i>
                <h1 class="panel-title-name">Palabras Clave</h1>
            </div>

            <!--TABLA-->
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Creada por</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($datos != 0){
                            $contador = 1;
                            foreach($datos as $rows){
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="NOMBRE" class="responsive-file"><?php echo $rows['descripcion'] ?></td>
                            <td data-titulo="CREADO POR" class="responsive-file"><?php echo $rows['nombre'] . " " . $rows['apellido'] ?></td>
                            <td data-titulo="ESTADO" class="responsive-file"><?php echo Utilidades::getNombreEstado($rows['estadoEtiqueta']) ?></td>
                            <td data-titulo="ACCIÓN" class="responsive-file">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>editarPalabraClave/<?php echo $ins_etiqueta->encryption($rows['idEtiqueta'])?>/" class="btn-admin-edit-record" title="Editar palabra clave"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/etiquetaAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="id_etiqueta_del" value="<?php echo $ins_etiqueta->encryption($rows['idEtiqueta']) ?>">
                                            <button type="submit" class="btn-delete-record" title="Eliminar palabra clave"><i class="uil uil-trash-alt"></i></button>
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
