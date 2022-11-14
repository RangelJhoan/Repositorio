
    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="nav-Home-Main">
        <section class="logo-section-Home">
            <div class="logo-image-Home">
                <a title="Repositorio Institucional" href="<?php echo SERVER_URL; ?>home/">
                <img class="logo-ri-home" src="<?php echo SERVER_URL ?>vistas/assets/img/dashboard-ri-logo.png" alt="Logo Repositorio Institucional">
                </a>
            </div>
            <h1 class="logo-Home">Repositorio Institucional</h1>
        </section>

        <input class="input-HamburguerHome" type="checkbox" id="checkHamburguesaHome" title="Menú">
        <label for="checkHamburguesaHome">
            <img src="<?php echo SERVER_URL; ?>vistas/assets/img/hamburguerNav.svg" alt="Menú" title="Menú de navegación" class="hamburguer-Menu">
        </label>
        <ul class="ul-Home">
            <li class="li-Home">
                <a  class="a-HomeNav" href="#">Inicio</a></li>
            <li class="li-Home"><a  class="a-HomeNav" href="#">Preguntas frecuentes</a></li>
            <li class="li-Home">
                <input class="input-HamburguerHome" type="checkbox" id="btn-Perfil-Label" class="input-Navbar">
                <a  class="a-HomeNav homeHideListMin" href="#">Perfil</a>
                <ul class="ul-Home ul-SubMenu">
                    <li class="li-Home">
                        <a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>login/">Acceder</a>
                    </li>
                </ul>
            </li>
            <li class="li-Home homeHideListFull"><a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>login/">Acceder</a></li>
        </ul>
    </nav>

    <!-- SECCIÓN 1: BANNER + BARRA BÚSQUEDA-->
    <section class="bannerSearchHome-Section">
        <!-- Banner -->
        <img class="bannerImg" src="<?php echo SERVER_URL ?>vistas/assets/img/bannerHome.png" alt="Banner Repositorio Institucional">
        <!-- Barra búsqueda -->
        <form class="form-BarraBusquedaHome" action="#" method="POST" data-form="save" autocomplete="off">
            <div class="searchBar-Container">
                <input class="input-SearchBar" type="text" placeholder="Buscar recurso...">
                <button type="submit" title="Buscar" class="searchBar-IconContainer">
                    <i class="uil uil-search search-iconHome"></i>
                    <!-- <i class="uil uil-search search-iconHome"></i> -->
                </button>
            </div>
        </form>
    </section>