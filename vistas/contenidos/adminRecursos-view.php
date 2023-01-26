<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
</head>
    <title>Repositorio Institucional</title>
</head>
<body>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-file-blank"></i>
                <h1 class="panel-title-name">Recursos</h1>
            </div>
            <!--BOTÓN CREAR-->
            <div class="new-record-container">
                <label for="btn-modal-admin-add-record" class="btn-add-record" title="Crear recurso">
                    <i class="uil uil-plus-circle"></i>Nuevo
                </label>

                <a class="btn-add-record" title="Crear autor" href="<?php echo SERVER_URL ?>adminAutores/">
                    <i class="uil uil-plus-circle"></i>Autor
                </a>
            </div>
            <!--MODAL CREAR RECURSO-->
            <input type="checkbox" id="btn-modal-admin-add-record">
                <div class="container-modal-add-record-resource">
                <div class="content-modal-add-record">
                    <h3 class="content-modal-titulo">Nuevo recurso</h3>
                    <p class="content-modal-recordatorio">Recuerde que * indica que el campo es obligatorio.</p>

                    <!--enctype="multipart/form-data" Es para poder enviar archivos en el form-->
                    <form action="<?php echo SERVER_URL ?>ajax/recursoAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off" enctype="multipart/form-data">
                        <!--Título recurso-->
                        <div class="input-field">
                            <input name="titulo_ins" type="text" placeholder="Título *" title="Por favor, complete el campo" required/>
                        </div>
                        <!--Lista de autores-->
                        <label for="programaSeleccion" class="titleComboMultiple">Autor *</label>
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
                        &nbsp; Seleccionar archivo del recurso
                        </label>
                            <ul id="files-list"></ul>
                        </div>
                        <!--Botones de acción-->
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" />
                            <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cerrar</label>
                        </div>
                    </form>
                </div>
            </div>

            <!--TABLA-->
            <?php
                require_once "./controladores/cursoControlador.php";
                $ins_curso = new cursoControlador();

                $cantidadRegistros = 1000;
                if(count($pagina) == 0){
                    $paginaActual = $pagina[1];
                    $datos = $ins_curso->paginador_curso_controlador($paginaActual, $cantidadRegistros, 0, $pagina[0], "");
                }else{
                    $paginaActual = -1;
                    $datos = $ins_curso->paginador_curso_controlador($paginaActual, $cantidadRegistros, 0, $pagina[0], "");
                }
            ?>
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Archivo</th>
                            <th>Útil (Si/No)</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $inicio = ($paginaActual>0) ? (($paginaActual*$cantidadRegistros)-$cantidadRegistros) : 0;
                        $contador = $inicio+1;
                        if($datos != 0){
                            foreach($datos as $rows){
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="TÍTULO"><?php echo $rows['nombre_curso'] ?></td>
                            <td data-titulo="AUTOR"><?php echo $rows['descripcion_curso'] ?></td>
                            <td data-titulo="ARCHIVO"><?php echo $rows['nombre_programa'] ?></td>
                            <td data-titulo="ÚTIL (SI/NO)"><?php echo "6/10" ?></td>
                            <td data-titulo="ACCIÓN">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>adminEditarCurso/<?php echo $ins_curso->encryption($rows['id_curso'])?>/" class="btn-admin-edit-record" title="Editar recurso"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/cursoAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="id_curso_del" value="<?php echo $ins_curso->encryption($rows['id_curso']) ?>">
                                            <button type="submit" class="btn-delete-record" title="Eliminar recurso"><i class="uil uil-trash-alt"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php
                            $contador++;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <div>
    </section>
    <!--SCRIPTS NECESARIOS PARA EL DATATABLE-->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script> -->

    <script src="<?php echo SERVER_URL ?>vistas/assets/js/datatables.js"></script> 
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/multipleCombo.js"></script> 
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/uploadFile.js"></script> 


</body>
</html>