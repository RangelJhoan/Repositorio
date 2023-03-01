<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio Institucional</title>
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
</head>
<body>
    <!--//* Contenedor principal  -->
    <main class="mainContarinerFilters">
    <!--//* Contenedor tabla  -->
        <section class = "tableWithContent">
            <section class="general-admin-container">
            <div class="overview-general-admin">
                <!--TÍTULO-->
                <div class="title">
                    <i class="uil uil-book-open"></i>
                    <h1 class="panel-title-name">Filtro por autor</h1>
                </div>





                
                <!--TABLA-->
                <div class="table-admin-container">
                    <table id="tablaUsuarios" class="tb-admin-records">
                        <thead>
                            <tr>
                                <td colspan="3"> <center>Resultado por <?php echo $pagina[1];?></center> </td>
                                    </tr>
                                    <tr>
                                        <td><b>Fecha</b></td>
                                        <td><b>Titulo</b></td>
                                        <td><b>Autor(es)</b></td>
                                    </tr>
                        </thead>
                        <tbody>
                        <?php
                            require_once "./controladores/homeControlador.php";

                            $ins_curso = new homeControlador();

                            $datos_filtro = $ins_curso->listado_filtro_recursos($pagina[1],$pagina[2]);

                            foreach($datos_filtro as $vRecurso){
                                ?>
                                <tr>
                                    <td><?php echo $vRecurso['fecha_publicacion_recurso']; ?></td>
                                    <td><?php echo $vRecurso['titulo']; ?></td>
                                    <td><?php echo $vRecurso['nombre']." ".$vRecurso['apellido']; ?></td>
                                </tr>
                            <?php } ?>   
                        </tbody>
                    </table>
                </div>
            <div>
        </section>
        </section>
    <!--//* Contenedor aside filtros  -->
        <aside class = "asideFilters">
            <h3 class="asideFiltersTitle">Listar</h3>
            <nav class = "navAsideFilters">
                <ul class = "ulAsideFilters">
                    <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Autor/">Autor</a></li>
                    <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Titulo/">Título</a></li>
                    <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Fecha/">Fecha creación</a></li>
                    <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Curso/">Curso</a></li>
                </ul>
            </nav>
        </aside>
    </section>
<!--SCRIPTS NECESARIOS PARA EL DATATABLE-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
</body>
</html>
