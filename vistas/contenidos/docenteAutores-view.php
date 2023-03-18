<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-pen"></i>
                <h1 class="panel-title-name">Autores</h1>
            </div>
            <!--BOTÓN MIS AUTORES-->
            <div class="new-record-container">
                <a class="btn-add-record btnDocenteMis" title="Mis autores" href="<?php echo SERVER_URL ?>docenteMisAutores/">Mis autores</a>
            </div>
            <!--TABLA-->
            <?php
                require_once "./controladores/autorControlador.php";
                require_once "./utilidades/Utilidades.php";
                $ins_autor = new autorControlador();
                $datos = $ins_autor->paginador_autor_controlador(null);
            ?>
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Creado por</th>
                            <th>Fecha creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($datos != 0){
                            $contador = 1;
                            foreach($datos as $rows){
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador; ?></td>
                            <td data-titulo="NOMBRE" class="responsive-file"><?php echo $rows['nombre'] ?></td>
                            <td data-titulo="APELLIDO" class="responsive-file"><?php echo $rows['apellido'] ?></td>
                            <td data-titulo="CREADO POR" class="responsive-file"><?php echo $rows['nombreDocente'] . " " . $rows['apellidoDocente'] ?></td>
                            <td data-titulo="FECHA CREACIÓN" class="responsive-file"><?php echo $rows['fecha_creacion'] ?></td>
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