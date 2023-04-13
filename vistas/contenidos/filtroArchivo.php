<!--//* Contenedor principal  -->
<main class="mainContarinerFilters">
    <section class = "tableWithContent">
        <!--//* DATATABLE  -->
        <section class="general-tableJQ-container">
            <div class="overview-general-admin">
                <!--TÍTULO-->
                <div class="title">
                    <i><img src="<?php echo SERVER_URL; ?>vistas/assets/img/tituloHome.svg" class="titleImgIcon" alt="Autor Img"/></i>
                    <h1 class="panel-title-name">Filtro por Archivo</h1>
                </div>


                <!--FILTRO POR LETRAS-->
                <p class="dataTables_length">Títulos que empiecen por:</p>
                <ul class="dataTables_length">
                    <li class="liLetraFilto">
                        <a class="aLetraFiltro" href="<?php echo SERVER_URL."recursosBusqueda/Titulonumero/"; ?>">0-9</a>
                <?php
                    $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                    foreach($abecedario as $letra){
                ?> 
                        <a class="aLetraFiltro" href="<?php echo SERVER_URL."recursosBusqueda/Titulofiltrar/".$letra; ?>">
                            <?php echo $letra?>
                        </a>
                    </li>
                </ul>
                <?php } ?>


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
                            $datos_filtro = $ins_home->listado_filtro_recursos($pagina[1],$pagina[2]);
                            foreach($datos_filtro as $vRecurso){
                                $autores = $ins_home->cargar_informacion_recurso($vRecurso['id']);
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
