<?php
require_once "./controladores/recursoControlador.php";
require_once "./controladores/autorControlador.php";
require_once "./controladores/cursoControlador.php";

$ins_recurso = new recursoControlador();
$insAutor = new autorControlador();
$insCurso = new cursoControlador();

$datos = $ins_recurso->paginadorRecursoControlador(null, true);
?>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-file-blank"></i>
                <h1 class="panel-title-name">Recursos</h1>
            </div>
            <!--BOTÓN MIS RECURSOS-->
            <div class="new-record-container">
                <a class="btn-add-record btnDocenteMis" title="Mis recursos" href="<?php echo SERVER_URL ?>docente-mis-recursos/">Mis recursos</a>
            </div>
            <!--TABLA-->
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Autor(es)</th>
                            <th>Curso</th>
                            <th>Publicado por</th>
                            <th>Fecha publicación</th>
                            <!-- <th>Archivo</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($datos != 0){
                            $contador = 1;
                            foreach($datos as $rows){
                                $autoresRecurso = $insAutor->autoresXRecursoControlador($rows['idRecurso']);
                                $archivo = $ins_recurso->archivoXRecursoControlador($rows['idRecurso']);
                                $cursosRecurso = $insCurso->cursosXRecursoControlador($rows['idRecurso']);
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="TÍTULO" class="responsive-file">
                                <a href="<?php echo SERVER_URL?>handle/<?php echo $ins_recurso->encryption($rows['idRecurso'])?>/" target="_blank" class="irAlRecurso" title="Ir al recurso"><?php echo $rows['titulo'] ?></a></td>
                            </td>
                            <td data-titulo="AUTOR(ES)" class="responsive-file">
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
                            <td data-titulo="CURSO(S)" class="responsive-file">
                            <?php
                                foreach($cursosRecurso as $camposCurso){
                                    ?>
                                    <ul>
                                        <li><?php echo $camposCurso['nombre'] ?></li>
                                    </ul>
                                    <?php
                                }
                            ?>
                            </td>
                            <td data-titulo="PUBLICADO POR" class="responsive-file"><?php echo $rows['nombre'] . " " . $rows['apellido'] ?></td>
                            <td data-titulo="FECHA PUBLICACIÓN" class="responsive-file"><?php echo $rows['fecha_publicacion_profesor'] ?></td>
                            <!-- <td data-titulo="ARCHIVO"><?php if($archivo != false) echo $archivo['nombre'] ?></td> -->
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
