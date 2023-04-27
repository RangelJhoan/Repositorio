<!--//* Contenedor principal  -->
<main class="mainContarinerFilters">
    <section class = "tableWithContent">
        <!--//* DATATABLE  -->
        <section class="general-tableJQ-container">
            <div class="overview-general-admin">
                <!--TÍTULO-->
                <div class="title">
                    <i class="uil uil-search search-iconHome"></i>
                    <h1 class="panel-title-name">Resultados obtenidos</h1>
                </div>
                
                <div class="panel-title-name table-dataJQ-container">
                    <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                            <tr>
                                <td class="titleTableFilterSearch">Fecha</td>
                                <td class="titleTableFilterSearch">Título</td>
                                <td class="titleTableFilterSearch">Autor(es)</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            require_once "./controladores/homeControlador.php";
                            require_once "./modelos/mainModel.php";
                            $ins_main = new mainModel();
                            $ins_home = new homeControlador();
                            $datos_filtro = $ins_home->listadoFiltroRecursos($pagina[1],$pagina[2]);
                            foreach($datos_filtro as $vRecurso){
                                $autores = $ins_home->cargarInformacionRecurso($vRecurso['id']);
                                ?>
                                <tr>
                                    <td data-titulo="FECHA"><a href="#" class="deleteRedireccionTable"><?php echo $vRecurso['fecha_publicacion_recurso'];?></a></td>
                                    <td data-titulo="TITULO"><a href="<?php echo SERVER_URL."handle/".$ins_main->encryption($vRecurso['id']); ?>" class="redireccionTable"><?php echo $vRecurso['titulo']; ?> </a></td>
                                    <td data-titulo="AUTOR(ES)"><a href="#" class="deleteRedireccionTable italicTableStyle"><?php echo $autores; ?></a></td>
                                </tr>
                                <?php } ?>  
                        </tbody>
                    </table>
                </div>
            <div>
        </section>        
    </section>
<!--//* Contenedor aside filtros  -->
<?php include "asideHomeFilters-view.php";?>
</main>
<!--SCRIPTS NECESARIOS PARA EL DATATABLE-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/datatables.js"></script>
</body>
</html>
