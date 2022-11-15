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
            <i class="uil uil-book-open"></i>
                <h1 class="panel-title-name">Editar Curso</h1>
            </div>
            <div class="container-modal-edit-record" id="modal-container-edit-user">
                <div class="content-modal-edit-record">
                    <form action="<?php echo SERVER_URL ?>ajax/usuarioAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                            <div class="input-field">
                                <input name="nombre" type="text" placeholder="Nombre" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,30}"  title="Nombre" required/>
                            </div>
                            <div class="input-field">
                                <input name="descripcion" type="text" placeholder="Descripción" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{3,300}" title="Descripción" required/>
                            </div>

                            <label for="programaSeleccion" class="titleComboMultiple">Programa(s)</label>
                                <select name="seleccionProg" id="programaSeleccionarCur" multiple title="Programas asociados al curso">
                                    <option value="1">Ingeniería de Sistemas</option>
                                    <option value="2">Diseño gráfico</option>
                                    <option value="3">Ingeniería industrial</option>
                                    <option value="4">Ingeniería electrónica</option>
                                    <option value="5">Ingeniería eléctrica</option>
                                    <option value="6">Diseño industrial</option>
                                    <option value="7">Derecho</option>
                                </select>
                            <div class="botones-accion-modal">
                                <button type="submit" class="btn-admin-edit-record" title="Actualizar">Guardar cambios</button>
                                <a href="<?php echo SERVER_URL ?>adminCursos/" class="btn-close-edit-record" title="Cursos">Volver atrás</a>
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
            <img class="image-errorEditRecord"src="<?php echo SERVER_URL; ?>vistas/assets/img/errorEditarRegistro.svg" alt="Error al intentar editar curso.">
            <a href="<?php echo SERVER_URL; ?>adminCursos/" class="btn-UserNotFound" title="Ir a cursos">Volver atrás</a>
        </section>
    </div>
<?php } ?>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleCombo.js"></script> 

</body>
</html>