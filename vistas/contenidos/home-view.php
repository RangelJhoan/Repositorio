<?php 
    require_once "./controladores/recursoControlador.php";
    $insRecurso = new recursoControlador();
    $datos = $insRecurso->paginador_recurso_controlador(null, true);
?>

<section class="filters-main-container">
    <p class="msg-total-resources">Este repositorio institucional cuenta con un total de <span class="resources-total-count"><?php echo count($datos); ?></span> recursos disponibles para toda la comunidad. </p>
        <h2 class="filter-main-Title">Filtrar búsqueda por</h2>
        <div class="filterHomeContainer">
            <div class="hexagonFilters hxF1">
                <a href="<?php echo SERVER_URL ?>busqueda/Autor/" class="hexagonShape hexShp1">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/autorHome.svg" class="imageFilterHome" alt="Autor Img" />
                    <h3 class="titleFilterHome">Autor</h3>
                </a>
            </div>              
            <div class="hexagonFilters hxF2">
                <a href="<?php echo SERVER_URL ?>busqueda/Titulo/" class="hexagonShape hexShp2">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/tituloHome.svg" class="imageFilterHome" alt="Titulo Img" />
                    <h3 class="titleFilterHome">Título</h3>
                </a>
            </div>              
            <div class="hexagonFilters hxF3">
                <a href="<?php echo SERVER_URL ?>busqueda/Fecha/" class="hexagonShape hexShp3">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/fechaHome.svg" class="imageFilterHome" alt="Fecha Img" />
                    <h3 class="titleFilterHome">Fecha</h3>
                </a>
            </div>        
            <div class="hexagonFilters hxF4">
                <a href="<?php echo SERVER_URL ?>busqueda/Curso/" class="hexagonShape hexShp4">
                    <img src="<?php echo SERVER_URL; ?>vistas/assets/img/materiaHome.svg" class="imageFilterHome" alt="Curso Img" />
                    <h3 class="titleFilterHome">Curso</h3>
                </a>
            </div>             
        </div>
    </section>