<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo SERVER_URL ?>vistas/assets/css/404-Style.css">
    <title>404</title>
</head>
<body>
    <div class="container">
        <section class="text-section">
            <div class="wrapper">
                <h1>404 :(</h1>
            </div>
            <p>¡Ups! La página a la que intenta acceder del repositorio institucional no se encuentra disponible.</p>
            <div class="buttons-Section">
                <a href="<?php echo SERVER_URL; ?>home/" class="button-404" title="Repositorio Institucional">Ir a inicio</a>
                <a href="javascript:history.back()" class="button-404 btn404Back" title="Volver">Volver atrás</a>
            </div>

        </section>
        <section class="img-section">
            <img src="<?php echo SERVER_URL; ?>vistas/assets/img/404Error.png" alt="404 - Page Not Found">
        </section>
    </div>
</body>
</html>
