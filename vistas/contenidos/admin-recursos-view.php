<?php
require_once "./controladores/recursoControlador.php";
require_once "./controladores/autorControlador.php";

$ins_recurso = new recursoControlador();
$insAutor = new autorControlador();

$datos = $ins_recurso->paginadorRecursoControlador(null);
?>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-file-blank"></i>
                <h1 class="panel-title-name">Recursos</h1>
            </div>
            <!--BOTÓN CREAR-->
            <div class="new-record-container">
                <a class="btn-add-record" title="Ir a autores" href="<?php echo SERVER_URL ?>admin-autores/">
                <i class="uil uil-pen"></i>Autores
                </a>
                <a class="btn-add-record" title="Ir a palabras clave" href="<?php echo SERVER_URL ?>panel-palabras-clave/">
                <i class="uil uil-tag"></i>Palabras clave
                </a>
            </div>
            <!--TABLA-->
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Autor(es)</th>
                            <th>Archivo</th>
                            <th>Feedback</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($datos != 0){
                            $contador = 1;
                            foreach($datos as $rows){
                                $autoresRecurso = $insAutor->autoresXRecursoControlador($rows['idRecurso']);
                                $archivo = $ins_recurso->archivoXRecursoControlador($rows['idRecurso']);
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="TÍTULO" class="responsive-file"><?php echo $rows['titulo'] ?></td>
                            <td data-titulo="AUTOR" class="responsive-file">
                            <?php
                                foreach($autoresRecurso as $campo){
                                    ?>
                                    <ul>
                                        <li><?php echo $campo['nombre'] . " " . $campo['apellido'] ?></li>
                                    </ul>
                                    <?php
                                }
                            ?>
                            </td>
                            <td data-titulo="ARCHIVO" class="responsive-file fileStyleResp"><?php if($archivo != false) echo $archivo['nombre'] ?></td>
                            <td data-titulo="FEEDBACK" class="responsive-file listFeedback">
                                <ul>
                                    <li title="Calificación positiva" class="liFeedback"><i class="uil uil-thumbs-up iconFeedback plus"></i>: <?php echo $rows['puntos_positivos'] ?> </li>
                                    <li title="Calificación negativa" class="liFeedback"><i class="uil uil-thumbs-down iconFeedback minus"></i>: <?php echo $rows['puntos_negativos'] ?> </li>
                                </ul>
                            </td>
                            <td data-titulo="ESTADO" class="responsive-file"><?php echo Utilidades::getNombreEstado($rows['estado']) ?></td>
                            <td data-titulo="ACCIÓN" class="responsive-file">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL?>handle/<?php echo $ins_recurso->encryption($rows['idRecurso'])?>/" target="_blank" class="btn-admin-view-record" title="Ir al recurso"><i class="uil uil-eye btn-admin-view-record"></i></a>
                                    </div>
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>editar-recurso/<?php echo $ins_recurso->encryption($rows['idRecurso'])?>/" class="btn-admin-edit-record" title="Editar recurso"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/recursoAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="id_recurso_del" value="<?php echo $ins_recurso->encryption($rows['idRecurso']) ?>">
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
