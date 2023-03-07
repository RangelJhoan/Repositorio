<!--//* Contenedor principal  -->
<main class="mainContarinerFilters">
    <section class = "tableWithContent">
        <!--//* DATATABLE  -->
        <section class="general-tableJQ-container">
            <div class="overview-general-admin">
                <!--TÍTULO-->
                <div class="title">
                    <i><img src="<?php echo SERVER_URL; ?>vistas/assets/img/materiaHome.svg" class="titleImgIcon" alt="Curso Img"/></i>
                    <h1 class="panel-title-name">Filtro por curso</h1>
                </div>

                <!--FILTRO POR LETRAS-->
                <p class="dataTables_length">Cursos que empiecen por:</p>
                <?php
                    $abecedario = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
                    foreach($abecedario as $letra){
                ?> 
                <ul class="dataTables_length">
                    <li class="liLetraFilto">
                        <a class="aLetraFiltro" href="<?php echo SERVER_URL."recursosBusqueda/Cursofiltrar/".$letra; ?>">
                            <?php echo $letra?>
                        </a>
                    </li>
                </ul>
                <?php } ?>

                
                <div class="panel-title-name table-dataJQ-container">
                    <table id="tablaUsuarios" class="tb-admin-records">
                        <thead>
                            <tr>
                                <td class="titleTableFilterSearch">Nombre</td>
                            </tr>
                        </thead>
                    <tbody>
                    <?php 
                        require_once "./controladores/homeControlador.php";
                        $ins_home = new homeControlador();
                        $datos_filtro = $ins_home->listado_filtro_recursos($pagina[1],$pagina[2]);
                        foreach($datos_filtro as $vRecurso){
                            $recursos = $ins_home->cargar_recursos_curso($vRecurso['id']);
                            ?>
                            <tr>
                                <td data-titulo="NOMBRE"><a href="#" class="redireccionTable"><?php echo $vRecurso['nombre']; ?><span class="tableFilterCounter"><?php echo $recursos; ?></span></a></td>
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