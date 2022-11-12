<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>/vistas/assets/css/home-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
    <nav class="nav-Home-Main">       
        <section class="logo-section-Home">
            <div class="logo-image-Home">
                <a title="Repositorio Institucional" href="<?php echo SERVER_URL; ?>home/">
                <img class="logo-ri-home" src="<?php echo SERVER_URL ?>vistas/assets/img/dashboard-ri-logo.png" alt="Logo Repositorio Institucional">
                </a>
            </div>
            <span class="logo-Home">Repositorio Institucional</span>
        </section>


        <input type="checkbox" id="checkHamburguesaHome">
        <label for="checkHamburguesaHome">
            <img src="<?php echo SERVER_URL; ?>vistas/assets/img/hamburguerNav.svg" alt="Menú" title="Menú de navegación" class="hamburguer-Menu">
        </label>
        <ul class="ul-Home">
            <li class="li-Home">
                <a  class="a-HomeNav" href="#">Inicio</a></li>
            <li class="li-Home"><a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>login/">Preguntas frecuentes</a></li>
            <li class="li-Home">
                <input type="checkbox" id="btn-Perfil-Label" class="input-Navbar">
                <a  class="a-HomeNav homeHideListMin" href="#">Perfil</a>
                <ul class="ul-Home ul-SubMenu">
                    <li class="li-Home">
                        <a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>login/">Acceder</a>
                    </li>
                    <li class="li-Home">
                        <a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>login/">Registrarse</a>
                    </li>
                </ul>
            </li>
            <li class="li-Home homeHideListFull"><a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>login/">Acceder</a></li>
            <li class="li-Home homeHideListFull"><a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>login/">Registrarse</a></li>
        </ul>
    </nav>
</body>
</html>