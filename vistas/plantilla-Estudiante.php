<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo SERVER_URL; ?>vistas/assets/img/tab-ri-logo.png">
    <!--ESTILOS CSS Y DEMÁS ESTILOS-->
    <?php include "incEstudiante/link.php";?>
    <title>Estudiante - Repositorio Institucional</title>
</head>
<body class="mode" id="bodyID">
    <?php
    $peticionAjax = false;
    require_once "./controladores/vistasControlador.php";
    $IV = new vistasControlador();

    $vistas = $IV->obtener_vistas_controlador();

    if($vistas == "login" || $vistas == "404" || $vistas == "home"){
        require_once "./vistas/contenidos/".$vistas."-view.php";
    }else{
        if(!isset($_SESSION)){
            session_start(['name' => 'REPO']);
        }
        require_once "./controladores/usuarioControlador.php";
        $uc = new usuarioControlador();

        if(!isset($_SESSION['id_persona']) || !isset($_SESSION['correo_usuario']) || !isset($_SESSION['estado_usuario'])){
            echo $uc->forzarCierreSesionControlador();
            exit();
        }

        $pagina = explode("/", $_GET['views']);
        ?>
        <!---NAVLATERAL-->
        <?php include "incEstudiante/navLateral.php";?>
        <!--TOPBAR-->
        <section class="top-navbar">
        <?php
        include "incEstudiante/navBar.php";
        include $vistas;
        ?>
        </section>
        <!--SCRIPTS NECESARIOS-->
        <?php include "./vistas/LogOut.php" ?>
        <?php include "incEstudiante/scripts.php";
    }
    ?>
</body>
</html>