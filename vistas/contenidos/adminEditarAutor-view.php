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

require_once "./controladores/autorControlador.php";
$ins_autor = new autorControlador();

$datos_autor = $ins_autor->datos_autor_controlador("Unico", $pagina[1]);

if($datos_autor->rowCount()>0){
    $campos = $datos_autor->fetch();
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
                    <form action="<?php echo SERVER_URL ?>ajax/autorAjax.php" class="FormularioAjax" method="POST" data-form="update" autocomplete="off">
                    <input type="hidden" name="id_autor_edit" value="<?php echo $pagina[1] ?>">
                    <div class="input-field">
                            <input name="nombre_edit" type="text" value="<?php echo $campos['nombre'] ?>" placeholder="Nombres" title="Por favor, complete el campo"/>
                        </div>
                        <div class="input-field">
                            <input name="apellido_edit" type="text" value="<?php echo $campos['apellido'] ?>" placeholder="Apellidos *" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Select tag-->
                        <div class="input-field ">
                            <div class="select-option">
                                <select name="estado" class="combobox-titulo" title="Estado del curso">
                                    <option disabled value="" class="combobox-opciones">Estado</option>
                                    <?php
                                    foreach (EstadosEnum::cases() as $cases) {
                                    ?>
                                    <option <?php if($campos['estado'] == $cases->value){echo "selected";} ?> value="<?php echo $cases->value; ?>"><?php echo $cases->getNameTextByValue($cases->value); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="botones-accion-modal">
                            <button type="submit" class="btn-admin-edit-record" title="Actualizar">Guardar cambios</button>
                            <a href="<?php echo SERVER_URL ?>adminAutores/" class="btn-close-edit-record" title="Autores">Volver atrás</a>
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