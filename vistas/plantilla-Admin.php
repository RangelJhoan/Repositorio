<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--ESTILOS CSS Y DEMÁS ESTILOS-->
    <?php include "incAdmin/link.php";?>
    <title>Repositorio Institucional</title>
</head>
<body class="mode">
    <?php
    $peticionAjax = false;
    require_once "./controladores/vistasControlador.php";
    $IV = new vistasControlador();

    $vistas = $IV->obtener_vistas_controlador();

    if($vistas == "login" || $vistas == "404" || $vistas == "home"){
        require_once "./vistas/contenidos/".$vistas."-view.php";
    }else{
        $pagina = explode("/", $_GET['views']);
        ?>
        <!---NAVLATERAL-->
        <?php include "incAdmin/navLateral.php";?>
        <!--TOPBAR-->
        <section class="top-navbar">
        <?php
        include "incAdmin/navBar.php";
        include $vistas;
        ?>
        </section>
        <!--SCRIPTS NECESARIOS-->
        <?php include "incAdmin/scripts.php";
    }
    ?>
</body>
</html>