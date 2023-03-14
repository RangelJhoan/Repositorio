    <!--NAVLATERAL-->
    <nav class="lateralNavBar">
        <!--Sección de logo y nombre-->
        <section class="logo-section">
            <div class="logo-image">
                <a title="Home" href="<?php echo SERVER_URL; ?>home/">
                <img src="<?php echo SERVER_URL ?>vistas/assets/img/dashboard-ri-logo.png" alt="Logo Repositorio Institucional">
                </a>
            </div>
            <span class="logo-name">Docente</span>
        </section>

        <!--Sección de las funcionalidades para el docente-->
        <section class="menu-options-section">
            <!--Opciones principales-->
            <ul class="nav-links">
                <li class="li-plantilla" title="Dashboard">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docenteDashboard/">
                        <i class="uil uil-dashboard"></i>
                        <span class="option-name">Dashboard</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Recursos">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docenteRecursos/">
                        <i class="uil uil-file-blank"></i>
                        <span class="option-name">Recursos</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Autores">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docenteAutores/">
                        <i class="uil uil-pen"></i>
                        <span class="option-name">Autores</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Etiquetas">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docenteEtiquetas/">
                        <i class="uil uil-tag"></i>
                        <span class="option-name">Etiquetas</span>
                    </a>
                </li>
                <!-- <li class="li-plantilla" title="Reportes">
                <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminReportes/">
                        <i class="uil uil-analytics"></i>
                        <span class="option-name">Reportes</span>
                    </a>
                </li> -->
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