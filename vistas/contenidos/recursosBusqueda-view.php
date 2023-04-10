<section>
    <?php
        if($pagina[1]=="Autor" || $pagina[1]=="Autorfiltrar"){
            include("filtroAutor.php");
        }else if($pagina[1]=="Titulo" || $pagina[1]=="Titulofiltrar" || $pagina[1]=="Titulonumero"){
            include("filtroTitulo.php");
        }else if($pagina[1]=="Curso" || $pagina[1]=="Cursofiltrar"){
            include("filtroCurso.php");
        }else if($pagina[1]=="Fecha" || $pagina[1]=="Fechafiltrar"){
            include("filtroFecha.php");
        }else if($pagina[1]=="Busqueda" || $pagina[1]=="filtroCurso" || $pagina[1]=="filtroAutor"){
            include("filtroBusqueda.php");
        }else if($pagina[1]=="Archivos"){
            include("filtroArchivo.php");
        }else{
            header('Location: ' . SERVER_URL. '404');
            exit();
        }
    ?>
</section>