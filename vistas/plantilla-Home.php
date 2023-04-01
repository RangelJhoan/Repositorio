<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ETIQUETAS SEO -->
    <!-- 1. Breve descripción para cuando la página sale en el motor de búsqueda.-->
    <meta name="description" content="Herramienta para reunir, organizar, difundi y preservar las producciones de la IES.">
    <!-- 2. Palabras clave para encontrar más facilmente el repositorio.-->
    <meta name="keywords" content="Recursos, Recursos académicos, Banco de recursos digitales audiovisuales, Repositorio Institucional, Repositorio IES, Archivos, Biblioteca digital, Colección digital, Material didáctico, Recursos educativos abiertos, Repositorio de objetos de aprendizaje, Biblioteca virtual, Repositorio de tesis y trabajos académicos, Archivos históricos, Biblioteca especializada, Repositorio de investigación, Biblioteca universitaria, Biblioteca en línea, Colección multimedia, Archivos audiovisuales, Recursos de aprendizaje en línea, Bibliografía digital, Archivos en formato PDF, Archivos en formato digital, Archivos de texto completo, Repositorio de acceso abierto, Open Access, Repositorio gratuito, Repositorio Libre">
    <!-- 3. Indicar que la página puede ser indexada por motores de búsquea y aparecer en resultados de búsqueda.-->
    <meta name="robots" content="index, follow">
    <!-- 3. Autores del repositorio institucional. Proyecto de Grado para optar por el título de Ingeniero de Sistemas en la Universidad de Investigación y Desarrollo (UDI) año 2023-1.-->
	<meta name="author" content="Juan Camilo Valencia Silva, Jhoan Manuel Rangel Mariño">

    <link rel="shortcut icon" href="<?php echo SERVER_URL; ?>vistas/assets/img/tab-ri-logo.png">
    <!--ESTILOS CSS Y DEMÁS ESTILOS-->
    <?php include "incHome/link.php";?>
    <title>Repositorio Institucional</title>
</head>
<body id="bodyID">
    <?php
    $peticionAjax = false;
    require_once "./controladores/vistasControlador.php";
    $IV = new vistasControlador();

    $vistas = $IV->obtener_vistas_controlador();

    if($vistas == "login" || $vistas == "404"){
        if(isset($_SESSION['tipo_usuario'])){
            include "incHome/headerHome.php";
            include "./vistas/contenidos/home-view.php";
            include "incHome/footerHome.php";
            include "incHome/scripts.php";
        }else{
            require_once "./vistas/contenidos/".$vistas."-view.php";
        }
    }elseif($vistas == "home"){
        include "incHome/headerHome.php";
        include "./vistas/contenidos/".$vistas."-view.php";
        include "incHome/footerHome.php";
        include "incHome/scripts.php";
    }else{
        $pagina = explode("/", $_GET['views']);
        include "incHome/headerHome.php";
        include $vistas;
        include "incHome/footerHome.php";
        include "incHome/scripts.php";
    }
    ?>
</body>
</html>