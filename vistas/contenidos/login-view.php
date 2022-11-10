<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/loginReg-Style.css">
    <title>Login</title>
</head>
<body>
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
                    <a href="" class="password-forget-text">¿Olvidó su contraseña?</a>
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
                                <option selected value="" class="combobox-opciones">Tipo de documento</option>
                                <option value="TI">Tarjeta de Identidad (TI)</option>
                                <option value="CC">Cédula de Ciudadanía (CC)</option>
                                <option value="CE">Tarjeta de Extranjería (CE)</option>
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
                    <p>Cree su cuenta para que pueda tener una experiencia más personalizada a la hora de usar el repositorio institucional. Recuerde que si se registra su tipo de usuario será estudiante.</p>
                    <button class="btn transparent" id="sign-up-btn">Registrarse</button>
                </div>
                <img src="<?php echo SERVER_URL; ?>vistas/assets/img/login.svg" class="image" alt="" />
            </div>
            <!--Panel 2. Derecho = Iniciar Sesión-->
            <div class="panel right-panel">
                <div class="content">
                    <h3>¿Ya tiene cuenta?</h3>
                    <p>Ingrese a su perfil facilmente utilizando su correo electrónico y su contraseña.</p>
                <button class="btn transparent" id="sign-in-btn">Iniciar sesión</button>
                </div>
                <img src="<?php echo SERVER_URL; ?>vistas/assets/img/signup.svg" class="image" alt="" />
            </div>
        </section>
    </div>


    <!--APARTADO PARA LOS SCRIPTS-->
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