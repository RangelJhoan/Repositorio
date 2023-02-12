<?php
    require_once "./controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();
?>
<!--NAVBAR-->
<div class="top-container">
            <i class="uil uil-bars sidebar-toggle"></i>
            <h1 class="center-name">Banco de recursos digitales audiovisuales</h1>
            <div class="profile-details" title="Perfil">
                <img src="<?php echo SERVER_URL; ?>vistas/assets/img/docente-dashboard-img.png" alt="Icono Docente" onclick="toggleMenu()">
            </div>
            <!--MENÚ WRAP USUARIO-->
            <div class="submenu-wrap" id="subMenu">
                <div class="submenu">
                    <div class="user-info">
                        <h3><?php echo $_SESSION['nombre_usuario'] . " " . $_SESSION['apellido_usuario']; ?></h3>
                    </div>
                </div>
                <hr>

                <ul>
                    <li class="li-plantilla">
                    <a href="<?php echo SERVER_URL ?>editarPerfil/<?php echo $ins_usuario->encryption($_SESSION['id_persona'])?>" class="submenu-link">
                        <i class="uil uil-user"></i>
                        <p class="option-name">Mi perfil</p>
                    </a>
                    </li>
                    <li class="li-plantilla">
                    <a href="#" class="submenu-link" id="cerrar_sesion">
                        <i class="uil uil-sign-out-alt"></i>
                        <p class="option-profile">Cerrar sesión</p>
                    </a>
                    </li>
                </ul>
            </div>
        </div>