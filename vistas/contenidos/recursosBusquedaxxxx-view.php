<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio Institucional</title>
</head>
<body>
    <section class="filters-main-container">
    <p class="msg-total-resources">Este repositorio institucional cuenta con un total de <span class="resources-total-count">1000</span> recursos disponibles para toda la comunidad. </p>
        <h2 class="filter-main-Title">Filtrar búsqueda por</h2>
        <div class="filterHomeContainer">
            <div class="hexagonFilters">
                <a href="<?php echo SERVER_URL ?>recursosBusqueda/Autor/" class="hexagonShape hexShp1">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/autorHome.svg" class="imageFilterHome" alt="Autor Img" />
                    <h3 class="titleFilterHome">Autor</h3>
                </a>
            </div>              
            <div class="hexagonFilters">
                <a href="<?php echo SERVER_URL ?>recursosBusqueda/Titulo/" class="hexagonShape hexShp2">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/tituloHome.svg" class="imageFilterHome" alt="Autor Img" />
                    <h3 class="titleFilterHome">Título</h3>
                </a>
            </div>              
            <div class="hexagonFilters">
                <a href="<?php echo SERVER_URL ?>recursosBusqueda/Fecha/" class="hexagonShape hexShp3">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/fechaHome.svg" class="imageFilterHome" alt="Autor Img" />
                    <h3 class="titleFilterHome">Fecha</h3>
                </a>
            </div>        
            <div class="hexagonFilters">
                <a href="<?php echo SERVER_URL ?>recursosBusqueda/Curso/" class="hexagonShape hexShp4">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/materiaHome.svg" class="imageFilterHome" alt="Autor Img" />
                    <h3 class="titleFilterHome">Área</h3>
                </a>
            </div>             
        </div>
    </section>
    <section>
        <table id="resultados">
            <tr>
                <td colspan="3"> <center>Resultado por <?php echo $pagina[1];?></center> </td>
            </tr>
            <tr>
                <td><b>Fecha</b></td>
                <td><b>Titulo</b></td>
                <td><b>Autor(es)</b></td>
            </tr>
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
        </table>
    </section>
</body>
</html>