<section class="dashboard-container">
        <div class="overview">
            <div class="title">
                <i class="uil uil-feedback"></i>
                <h1 class="panel-title-name">Feedbacks</h1>
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
                            <th>Autor(es)</th>
                            <th>Archivo</th>
                            <th>Mi Calificación</th>
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
                            <td data-titulo="#">¿Id?</td>
                            <td data-titulo="TÍTULO" class="responsive-file">¿Titulo?</td>
                            <td data-titulo="AUTOR(ES)" class="responsive-file">¿Autor?</td>
                            <td data-titulo="ARCHIVO" class="responsive-file fileStyleResp">¿Archivo?</td>
                            <td data-titulo="MI CALIFICACIÓN" class="responsive-file">¿Calificación? ¿Positiva o negativa?</td>
                            <td data-titulo="ACCIÓN" class="responsive-file">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="" class="btn-admin-view-record" title="Ir al recurso"><i class="uil uil-eye btn-admin-view-record"></i></a>
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
