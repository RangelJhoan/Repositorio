<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/loginReg-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<?php
require_once "./controladores/tipoDocumentoControlador.php";
$ins_tipo_documento = new tipoDocumentoControlador();

$datos_tipo_documento = $ins_tipo_documento->listar_tipo_documento_controlador();
?>

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
                <a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>home/">Inicio</a></li>
            <li class="li-Home"><a  class="a-HomeNav" href="<?php echo SERVER_URL; ?>preguntasFreq/">Preguntas frecuentes</a></li>
            <li class="li-Home">
                <input class="input-HamburguerHome" type="checkbox" id="btn-Perfil-Label" class="input-Navbar">
                <a  class="a-HomeNav homeHideListMin" href="#">Perfil</a>
                <ul class="ul-Home ul-SubMenu">
                    <li class="li-Home">
                        <?php
                        if(isset($_SESSION['tipo_usuario'])){
                            if($_SESSION['tipo_usuario'] == "Administrador"){
                                echo '<a  class="a-HomeNav" href="'.SERVER_URL.'adminDashboard/">Cuenta</a>';
                            }elseif($_SESSION['tipo_usuario'] == "Docente"){
                                echo '<a  class="a-HomeNav" href="'.SERVER_URL.'docenteDashboard/">Cuenta</a>';
                            }elseif($_SESSION['tipo_usuario'] == "Estudiante"){
                                echo '<a  class="a-HomeNav" href="'.SERVER_URL.'estudianteDashboard/">Cuenta</a>';
                            }
                        }else{
                            echo '<a  class="a-HomeNav" href="'.SERVER_URL.'login/">Acceder</a>';
                        }
                        ?>
                    </li>
                </ul>
            </li>
            <li class="li-Home homeHideListFull">
                <?php
                require_once("./controladores/homeControlador.php");
                $ins_homec = new homeControlador();
                    
                if(isset($_SESSION['tipo_usuario'])){
                    if($_SESSION['tipo_usuario'] == "Administrador"){
                        echo '<a  class="a-HomeNav" href="'.SERVER_URL.'adminDashboard/">Cuenta</a>';
                    }elseif($_SESSION['tipo_usuario'] == "Docente"){
                        echo '<a  class="a-HomeNav" href="'.SERVER_URL.'docenteDashboard/">Cuenta</a>';
                    }elseif($_SESSION['tipo_usuario'] == "Estudiante"){
                        echo '<a  class="a-HomeNav" href="'.SERVER_URL.'estudianteDashboard/">Cuenta</a>';
                    }
                }else{
                    echo '<a  class="a-HomeNav" href="'.SERVER_URL.'login/">Acceder</a>';
                }
                ?>
            </li>
        </ul>
    </nav>
    <!--MODAL CONTRASEÑA-->
    <div class="modal-container">
        <div class="modal-pswd modal-close-pswd">
            <p class="close">X</p>
                <img src="<?php echo SERVER_URL; ?>vistas/assets/img/forgot-password.svg" class="recover-password-pic" alt="Ilustración recuperar contraseña" />
                <div class="textosmodal">
                    <h3 class="title-recover-password">Recuperación de la cuenta</h3>
                    <p class="phrp-recover-password"> A continuación, por favor ingrese el correo electrónico con el cual se encuentra registrado en el repositorio institucional.</p>
                    <form action="#" class="" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input name="correo" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60" title="Por favor, ingrese el correo electrónico" required />
                        </div>
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Recuperar" title="Enviar"/>
                            <!-- <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cancelar</label> -->
                        </div>
                    </form>
                    </div>
                </div>
        </div>
    </div>
    <!--CONTAINER GENERAL-->
    <div class="container">

        <!--SECCIÓN PARA LOS FORMULARIOS-->
        <section class="forms-container">
            <div class="signin-signup">
                <!--Formulario 1: Iniciar Sesión-->
                <form action="" class="sign-in-form" method="POST" data-form="login" autocomplete="off">
                    <h2 class="title">Iniciar Sesión</h2>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input name="correo" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60" title="Por favor, ingrese el correo electrónico" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="clave" type="password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="Por favor, ingrese la contraseña" required/>
                    </div>

                    <input type="submit" value="Acceder" class="btn solid" />
                    <a href="#" class="password-forget-text">¿Olvidó su contraseña?</a>
                </form>
                <!--Formulario 2: Crear cuenta-->
                <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                    <h2 class="title">Registrarse</h2>
                    <input name="tipoUsuario" type="hidden" value="3">
                    <input name="estado" type="hidden" value="0">
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input name="nombre" type="text" placeholder="Nombres" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Por favor, complete el campo" required/>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input name="apellido" type="text" placeholder="Apellidos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}" title="Por favor, complete el campo" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input name="correo" type="email" placeholder="Correo electrónico" pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" minlength="8" maxlength="60" title="Por favor, complete el campo" required />
                    </div>
                    <!--Select tag-->
                    <div class="input-field ">
                        <i class="fas fa-solid fa-address-card"></i>
                        <div class="select-option">
                            <select name="tipoDocumento" class="combobox-titulo" title="Por favor, seleccione el tipo de documento" required>
                                <option selected disabled value="" class="combobox-opciones">Tipo de documento</option>
                                <?php
                                foreach($datos_tipo_documento as $campo){
                                ?>
                                <option value="<?php echo $campo['id'] ?>"><?php echo $campo['descripcion'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-solid fa-address-card"></i>
                        <input name="documento" type="number" placeholder="Número de documento" min="1000" max="100000000000"  pattern="[0-9]+" title="Por favor, complete el campo" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="clave" type="password" placeholder="Contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}" title="La contraseña debe contener al menos un número, una letra en mayúscula y minúscula, y como mínimo 8 caracteres." required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="confirmarClave" type="password" placeholder="Confirmar contraseña" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,80}"  title="Por favor, complete el campo" required />
                    </div>
                    <input type="submit" class="btn" value="Crear cuenta" />
                </form>
            </div>
        </section>

        <!--SECCIÓN PARA EL CAMBIO DE ACCIÓN (INICIAR O REGISTRARSE)-->
        <section class="panels-container">
            <!--Panel 1. Izquierdo = Registrarse-->
            <div class="panel left-panel">
                <div class="content">
                    <h3>¿No está registrado?</h3>
                    <p>Cree su cuenta para que pueda tener una experiencia más personalizada a la hora de usar el repositorio institucional. </p>
                    <button class="btn transparent" id="sign-up-btn">Registrarse</button>
                </div>
                <img src="<?php echo SERVER_URL; ?>vistas/assets/img/login.svg" class="image" alt="" />
            </div>
            <!--Panel 2. Derecho = Iniciar Sesión-->
            <div class="panel right-panel">
                <div class="content">
                    <h3>¿Ya tiene cuenta?</h3>
                    <p>Ingrese a su perfil fácilmente utilizando su correo electrónico y su contraseña.</p>
                <button class="btn transparent" id="sign-in-btn">Iniciar sesión</button>
                </div>
                <img src="<?php echo SERVER_URL; ?>vistas/assets/img/signup.svg" class="image" alt="" />
            </div>
        </section>
    </div>

    <!-- SECCIÓN 3: FOOTER-->
    <footer class="footer-Home">
        <div class="footer-Container">
            <div class="footer-Box">
                <div class="logoFooter-Home">
                <img class="logo-RI-footerHome" src="<?php echo SERVER_URL ?>vistas/assets/img/dashboard-ri-logo.png" alt="Logo Repositorio Institucional">
                </div>
                <div class="mainText-Footer">
                    <p>Este espacio proporciona un lugar ideal para que la comunidad universitaria gestione todos sus recursos digitales audiovisuales en un solo lugar, de forma rápida y completamente libre.</p>
                </div>
            </div>
            <div class="footer-Box">
                <h2 class="h2-title-Footer">Información</h2>
                <div class="centerInfoFooter">
                    <a class="link-a-footer" href="#">Ubicación IES</a>
                    <a class="link-a-footer" href="#">Teléfono IES</a>
                    <a class="link-a-footer" href="mailto:admin.repositorioinstitucional@gmail.com">admin.repositorioinstitucional@gmail.com</a>
                </div>
            </div>
        </div>
        <div class="copyright-Box-Footer">
            <hr class="line-divide-footer">
            <p class="rights-p-Footer">Todos los derechos reservados &copy; 2023 - <b>PG</b></p>
        </div>
    </footer>
    
    <!--APARTADO PARA LOS SCRIPTS-->
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/recoveryPsswd.js"></script>

    <script src="<?php echo SERVER_URL ?>vistas/assets/js/alertas.js"></script>
    <!--Script necesario para poder cambiar de manera dinámica los formularios-->
    <script src="<?php echo SERVER_URL; ?>vistas/assets/js/loginReg.js"></script>
    <!--Script necesario para usar los íconos (fas fa...)-->
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="<?php echo SERVER_URL; ?>vistas/assets/js/evitar_reenvio.js"></script>
</body>
</html>

<?php
if(isset($_POST['correo']) && isset($_POST['clave'])){
    require_once "./controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();

    $ins_usuario->iniciarSesion_usuario_controlador();
}
?>