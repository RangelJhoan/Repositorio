    <!--NAVLATERAL-->
    <nav class="lateralNavBar">
        <!--Sección de logo y nombre-->
        <section class="logo-section">
            <div class="logo-image">
                <a title="Home" href="<?php echo SERVER_URL; ?>home/">
                <img src="<?php echo SERVER_URL ?>vistas/assets/img/dashboard-ri-logo.png" alt="Logo Repositorio Institucional">
                </a>
            </div>

            <span class="logo-name">Administrador</span>
        </section>

        <!--Sección de las funcionalidades para el administrador-->
        <section class="menu-options-section">
            <!--Opciones principales-->
            <ul class="nav-links">
                <li class="li-plantilla" title="Dashboard">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminDashboard/">
                        <i class="uil uil-dashboard"></i>
                        <span class="option-name">Dashboard</span>
                    </a>
                </li>
                <!-- <li>
                    <a href="#">
                        <i class="uil uil-home"></i>
                        <span class="option-name">Inicio</span>
                    </a>
                </li> -->
                <li class="li-plantilla" title="Usuarios">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminUsuarios/">
                        <i class="uil uil-users-alt"></i>
                        <span class="option-name">Usuarios</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Programas">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminProgramas/">
                        <i class="uil uil-graduation-cap"></i>
                        <span class="option-name">Programas</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Cursos">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminCursos/">
                        <i class="uil uil-book-open"></i>
                        <span class="option-name">Cursos</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Recursos">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminRecursos/">
                        <i class="uil uil-file-blank"></i>
                        <span class="option-name">Recursos</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Reportes">
                <a class="li-plantilla" href="<?php echo SERVER_URL ?>adminReportes/">
                        <i class="uil uil-analytics"></i>
                        <span class="option-name">Reportes</span>
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