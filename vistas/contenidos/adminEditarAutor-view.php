<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<?php

require_once "./controladores/usuarioControlador.php";
$ins_usuario = new usuarioControlador();

$datos_usuario = $ins_usuario->datos_usuario_controlador("Unico", $pagina[1]);

if($datos_usuario->rowCount()>0){
    $campos = $datos_usuario->fetch();
    ?>
<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-pen"></i>
                <h1 class="panel-title-name">Editar Autor</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="FormularioAjax" method="POST" data-form="update" autocomplete="off">
                    <div class="input-field">
                            <input name="nombre_ins" type="text" placeholder="Nombres" title="Por favor, complete el campo" required/>
                        </div>
                        <div class="input-field">
                            <input name="nombre_ins" type="text" placeholder="Apellidos" title="Por favor, complete el campo" required/>
                        </div>
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" />
                            <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cerrar</label>
                        </div>
                </div>
            </div>
        <div>
    </section>
<?php }else{ ?>
    <div class="errorEditContainer">
        <section class="errorTextSection">
            <h3 class="title-errorTextSection">Hmmm...</h3>
            <p class="message-record-not-found">Ha ocurrido un error inesperado.</p>
        </section>
        <section class="img-section">
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar autor.">
            <a href="<?php echo SERVER_URL; ?>adminAutores/" class="btn-UserNotFound" title="Ir a autores">Volver atrás</a>
        </section>
    </div>
<?php } ?>
</body>
</html>