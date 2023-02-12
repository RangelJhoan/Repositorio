    <!--NAVLATERAL-->
    <nav class="lateralNavBar">
        <!--Sección de logo y nombre-->
        <section class="logo-section">
            <div class="logo-image">
                <a title="Home" href="<?php echo SERVER_URL; ?>home/">
                <img src="<?php echo SERVER_URL ?>vistas/assets/img/dashboard-ri-logo.png" alt="Logo Repositorio Institucional">
                </a>
            </div>

            <span class="logo-name">Estudiante</span>
        </section>

        <!--Sección de las funcionalidades para el estudiante-->
        <section class="menu-options-section">
            <!--Opciones principales-->
            <ul class="nav-links">
                <!-- <li class="li-plantilla" title="Dashboard">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminDashboard/">
                        <i class="uil uil-dashboard"></i>
                        <span class="option-name">Dashboard</span>
                    </a>
                </li> -->
                <li class="li-plantilla" title="Usuarios">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>estudianteFavoritos/">
                        <i class="uil uil-heart"></i>
                        <span class="option-name">Favoritos</span>
                    </a>
                </li>
            </ul>

            <!--Demás opciones-->
            <ul class="nav-other-options">
                <li class="li-plantilla mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="option-name">Modo oscuro</span>
                    </a>
                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </section>
    </nav>