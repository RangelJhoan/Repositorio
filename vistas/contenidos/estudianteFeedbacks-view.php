<section class="dashboard-container">
        <div class="overview">
            <div class="title">
                <i class="uil uil-feedback"></i>
                <h1 class="panel-title-name">Feedbacks</h1>
            </div>
            <!--TABLA-->
            <?php
                require_once "./controladores/recursoControlador.php";
                $insRecurso = new recursoControlador();
                $recursosCalificados = $insRecurso->obtenerListaCalificadosXPersona($_SESSION['id_persona']);
            ?>
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Autor(es)</th>
                            <th>Archivo</th>
                            <th>Mi Calificación</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($recursosCalificados != 0){
                            $contador = 1;
                            foreach($recursosCalificados as $recurso){
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="TÍTULO" class="responsive-file"><?php echo $recurso['titulo'] ?></td>
                            <td data-titulo="AUTOR(ES)" class="responsive-file">¿Autor?</td>
                            <td data-titulo="ARCHIVO" class="responsive-file fileStyleResp"><?php echo $recurso['nombre'] ?></td>
                            <td data-titulo="MI CALIFICACIÓN" class="responsive-file"><?php if($recurso['tipo_voto'] == 1) echo "Positivo";  else echo "Negativo"; ?></td>
                            <td data-titulo="ACCIÓN" class="responsive-file">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL?>recursosVisualizacion/<?php echo $insRecurso->encryption($recurso['id_recurso'])?>/" target="_blank" class="btn-admin-view-record" title="Ir al recurso"><i class="uil uil-eye btn-admin-view-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action=" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="id_curso_del" value="">
                                            <button type="submit" class="btn-delete-record" title="Eliminar calificación"><i class="uil uil-feedback"></i></button>
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
