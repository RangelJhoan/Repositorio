<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <form action="#" class="sign-in-form">
                    <h2 class="title">Iniciar Sesión</h2>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="text" placeholder="Correo electrónico" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Contraseña" />
                    </div>

                    <input type="submit" value="Acceder" class="btn solid" />
                    <a href="" class="password-forget-text">¿Olvidó su contraseña?</a>
                </form>


                <!--Formulario 2: Crear cuenta-->
                <form action="" class="sign-up-form" method="POST" data-form="save" autocomplete="off">
                    <h2 class="title">Registrarse</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input name="nombre" type="text" placeholder="Nombres" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input name="apellido" type="text" placeholder="Apellidos" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input name="correo" type="email" placeholder="Correo electrónico" />
                    </div>
                    <!--Select tag-->
                    <div class="input-field ">
                        <i class="fas fa-solid fa-address-card"></i>
                        <div class="select-option">
                            <select name="tipoDocumento" name="tipoDocumento" class="combobox-titulo">
                                <option selected disabled value="" class="combobox-opciones">Tipo de documento</option>
                                <option value="TI">Tarjeta de Identidad (TI)</option>
                                <option value="CC">Cédula de Ciudadanía (CC)</option>
                                <option value="CE">Tarjeta de Extranjería (CE)</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-solid fa-address-card"></i>
                        <input name="documento" type="number" placeholder="Número de documento" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="clave" type="password" placeholder="Contraseña" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input name="confirmarClave" type="password" placeholder="Confirmar contraseña" />
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
    <!--Script necesario para poder cambiar de manera dinámica los formularios-->
    <script src="<?php echo SERVER_URL; ?>vistas/assets/js/loginReg.js"></script>
    <!--Script necesario para usar los íconos (fas fa...)-->
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="<?php echo SERVER_URL; ?>vistas/assets/js/evitar_reenvio.js"></script>
</body>
</html>

<?php
if(isset($_POST['documento']) && isset($_POST['correo']) && isset($_POST['clave'])){
    require_once "./controladores/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();

    echo $ins_usuario->agregar_usuario_loginReg_controlador();
}
?>