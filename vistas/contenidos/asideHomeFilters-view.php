<?php
require_once "./controladores/homeControlador.php";
$insHome = new homeControlador();
$listaAutores = $insHome->listado_filtro_recursos("Autor","");
$listaTitulo = $insHome->listado_filtro_recursos("Titulo","");
$listaFecha = $insHome->listado_filtro_recursos("Fecha","");
$listaCurso = $insHome->listado_filtro_recursos("Curso","");
$listaArchivosSi = $insHome->listado_filtro_recursos("Archivos","Si");
$listaArchivosNo = $insHome->listado_filtro_recursos("Archivos","No");
?>
<aside class = "asideFilters">
    <h3 class="asideFiltersTitle">Listar</h3>
        <nav class = "navAsideFilters">
            <ul class = "ulAsideFilters">
                <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Autor/">Autor <span class="asideFilterCounter"><?php echo count($listaAutores) ?></span></a></li>
                <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Titulo/">Título <span class="asideFilterCounter"><?php echo count($listaTitulo) ?></span></a></li>
                <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Fecha/">Fecha creación <span class="asideFilterCounter"><?php echo count($listaFecha) ?></span> </a></li>
                <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Curso/">Curso <span class="asideFilterCounter"><?php echo count($listaCurso) ?></span></a></li>
            </ul>
        </nav>
    <h3 class="asideFiltersTitle hasFile">Tiene archivo</h3>
        <nav class = "navAsideFilters">
            <ul class = "ulAsideFilters">
                <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Archivos/Si">Sí <span class="asideFilterCounter"><?php echo count($listaArchivosSi) ?></span></a></li>
                <li class="liAsideFilters"><a class="aAsideFilters" href="<?php echo SERVER_URL ?>recursosBusqueda/Archivos/No">No <span class="asideFilterCounter"><?php echo count($listaArchivosNo) ?></span></a></li>
            </ul>
        </nav>
</aside>