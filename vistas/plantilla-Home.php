<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--ESTILOS CSS Y DEMÁS ESTILOS-->
    <?php include "incHome/link.php";?>
    <title>Repositorio Institucional</title>
</head>
<body>
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