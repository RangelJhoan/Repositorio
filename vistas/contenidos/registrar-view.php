<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Nuevo</title>
</head>
<body>
    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
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
                <select name="tipoDocumento" class="combobox-titulo">
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
</body>
</html>