<?php

?>

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
            <h1>404</h1>
            <p>¡Ups! La página a la que intenta acceder no se encuentra disponible.</p>
        </section>
        <section class="img-section">
            <img src="<?php echo SERVER_URL; ?>assets/img/404Error.png" alt="404 - Page Not Found">
        </section>
        <a href="<?php echo SERVER_URL; ?>home/">
            <button>Volver al inicio</button>
        </a>
    </div>
</body>
</html>