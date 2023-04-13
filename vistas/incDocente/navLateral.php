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
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docente-dashboard/">
                        <i class="uil uil-dashboard"></i>
                        <span class="option-name">Dashboard</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Autores">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docente-autores/">
                        <i class="uil uil-pen"></i>
                        <span class="option-name">Autores</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Palabras Clave">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docente-palabras-clave/">
                        <i class="uil uil-tag"></i>
                        <span class="option-name">Palabras clave</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Recursos">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>docente-recursos/">
                        <i class="uil uil-file-blank"></i>
                        <span class="option-name">Recursos</span>
                    </a>
                </li>
                <li class="li-plantilla" title="Feedbacks">
                    <a class="li-plantilla" href="<?php echo SERVER_URL ?>estudiante-feedbacks/">
                    <i class="uil uil-feedback"></i>
                    <span class="option-name">Feedbacks</span>
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