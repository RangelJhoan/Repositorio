<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
            <i class="uil uil-graduation-cap"></i>
                <h1 class="panel-title-name">Editar Programa</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="FormularioAjax" method="POST" data-form="update" autocomplete="off">
                        <input type="hidden" name="id_programa_editar" value="<?php echo $pagina[1] ?>">
                        <div class="input-field">
                            <input name="nombre" type="text" placeholder="Nombre" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}"  title="Por favor, complete el campo" required/>
                        </div>
                        <div class="input-field">
                            <input name="descripcion" type="text" placeholder="Descripción" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,300}" title="Por favor, complete el campo" required/>
                        </div>
                        <div class="botones-accion-modal">
                            <button type="submit" class="btn-admin-edit-record">Guardar cambios</button>
                            <a href="<?php echo SERVER_URL ?>adminProgramas/" class="btn-close-edit-record" title="Volver atrás">Volver atrás</a>
                        </div>
                    </form>
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
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar programa.">
            <a href="<?php echo SERVER_URL; ?>adminProgramas/" class="btn-UserNotFound" title="Ir a programas">Volver atrás</a>
        </section>
    </div>
<?php } ?>
</body>
</html>