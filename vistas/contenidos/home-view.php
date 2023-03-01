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
                    <h3 class="titleFilterHome">Curso</h3>
                </a>
            </div>             
        </div>
    </section>
</body>
</html>