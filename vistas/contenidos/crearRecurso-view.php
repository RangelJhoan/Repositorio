<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
            <i class="uil uil-file-blank"></i>
                <h1 class="panel-title-name">Nuevo Recurso</h1>
            </div>

            <div class="container-modal-edit-record" id="modal-container-add-record">
                <div class="content-modal-add-record">
                <p class="content-modal-recordatorio">Recuerde que * indica que el campo es obligatorio.</p>
    
                <form action="<?php echo SERVER_URL ?>ajax/recursoAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                        <!--Título recurso-->
                        <div class="input-field">
                            <input name="titulo_ins" type="text" placeholder="Título *" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Lista de autores-->
                        <label for="programaSeleccion" class="titleComboMultiple">Autor(es) *</label>
                            <select name="programas_ins[]" id="programaSeleccionarCur" multiple="multiple" title="Por favor, selecciona el o los autores del recurso">
                                <?php
                                foreach($datos_programas as $campos){
                                ?>
                                <option value="<?php echo $campos['id'] ?>"><?php echo $campos['nombre'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        <!--Resumen-->
                        <textarea class="textAreaStl" name="resumen_ins" type="text" placeholder="Resumen *" title="Por favor, complete el campo" required></textarea>
                        <!--Fecha recurso-->
                        <label for="programaSeleccion" class="titleComboMultiple">Fecha del recurso *</label>
                        <div class="input-field">
                            <input name="fecha_ins" type="date" placeholder="Fecha del recurso" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Editorial-->
                        <div class="input-field">
                            <input name="editorial_ins" type="text" placeholder="Editorial " title="Por favor, complete el campo"/>
                        </div>
                        <!--ISBN-->
                        <div class="input-field">
                            <input name="ISBN_ins" type="number" placeholder="ISBN" title="Por favor, complete el campo"/>
                        </div>
                        <!--Cargue del archivo-->
                        <div class="fileUploadContainer">
                            <input class="inputUploadFile" type="file" id="file-input"/>
                        <label class="labelFileUpload" for="file-input">
                        <i class="uil uil-upload"></i>
                        &nbsp; Subir archivo
                        </label>
                            <ul id="files-list"></ul>
                        </div>
                        <!--Botones de acción-->
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" title="Crear recurso"/>
                            <a href="javascript:history.back()" class="btn-close-add-record" title="Volver atrás">Volver atrás</a>
                        </div>
                    </form>
                </div>
            </div>
        <div>
    </section>

    <script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleCombo.js"></script> 
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/uploadFile.js"></script> 
</body>
</html>