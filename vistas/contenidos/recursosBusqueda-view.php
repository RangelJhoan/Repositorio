<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repositorio Institucional</title>
</head>
<body>
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
            }else if($pagina[1]=="Busqueda"){
                include("filtroBusqueda.php");
            }
        ?>
    </section>
</body>
</html>