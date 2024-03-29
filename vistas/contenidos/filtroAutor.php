<!--//* Contenedor principal  -->
<main class="mainContarinerFilters">
    <section class = "tableWithContent">
        <!--//* DATATABLE  -->
        <section class="general-tableJQ-container">
            <div class="overview-general-admin">
                <!--TÍTULO-->
                <div class="title">
                    <i><img src="<?php echo SERVER_URL; ?>vistas/assets/img/autorHome.svg" class="titleImgIcon" alt="Autor Img" /></i>
                    <h1 class="panel-title-name">Filtro por autor</h1>
                </div>
            <!--FILTRO POR LETRAS-->
            <p class="dataTables_length">Autores que empiecen por:</p>
                <?php
                    $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                    foreach($abecedario as $letra){
                ?> 
                <ul class="dataTables_length">
                    <li class="liLetraFilto">
                        <a class="aLetraFiltro" href="<?php echo SERVER_URL."busqueda/Autorfiltrar/".$letra; ?>">
                            <?php echo $letra?>
                        </a>
                    </li>
                </ul>
                <?php } ?>

                <div class="panel-title-name noRESPtable-dataJQ-container">
                    <table id="tablaUsuarios" class="noRESPtb-admin-records">
                        <thead>
                            <tr>
                                <td class="titleTableFilterSearch">Nombre</td>
                            </tr>
                        </thead>
                    <tbody>




                <?php 
                    require_once "./controladores/homeControlador.php";
                    $ins_home = new homeControlador();
                    $datos_filtro = $ins_home->listadoFiltroRecursos($pagina[1],$pagina[2]);
                    foreach($datos_filtro as $vRecurso){
                        $recursos = $ins_home->cargarRecursosAutor($vRecurso['id']);
                        if($recursos > 0){
                        ?>
                        <tr>
                            <td><a href="<?php echo SERVER_URL."busqueda/filtroAutor/".$vRecurso['id']; ?>" class="redireccionTable"><?php echo $vRecurso['apellido']." ".$vRecurso['nombre']; ?><span class="tableFilterCounter"><?php echo $recursos; ?></span></a></td>
                        </tr>
                        <?php }} ?>  
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