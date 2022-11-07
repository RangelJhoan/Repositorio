<!--NAVBAR-->
<div class="top-container">
            <i class="uil uil-bars sidebar-toggle"></i>
            <h1 class="center-name">Banco de recursos digitales audiovisuales</h1>
            <div class="profile-details" title="Perfil">
                <img src="<?php echo SERVER_URL; ?>vistas/assets/img/admin-dashboard-img.png" alt="Icono Admin" onclick="toggleMenu()">
                <!-- <span class="admin-name">Nombre admin</span> -->
                <!-- <i class="uil uil-angle-down"></i> -->
            </div>
            <!--MENÚ WRAP USUARIO-->
            <div class="submenu-wrap" id="subMenu">
                <div class="submenu">
                    <div class="user-info">
                        <h3>Rafael Ricardo Mantilla Guiza</h3>
                    </div>
                </div>
                <hr>

                <ul>
                    <li>
                    <a href="<?php echo SERVER_URL ?>editarPerfil/" class="submenu-link">
                        <i class="uil uil-user"></i>
                        <p class="option-name">Mi perfil</p>
                    </a>
                    </li>
                    <li>
                    <a href="#" class="submenu-link">
                        <i class="uil uil-sign-out-alt"></i>
                        <p class="option-profile">Cerrar sesión</p>
                    </a>
                    </li>
                </ul>
            </div>

        </div>