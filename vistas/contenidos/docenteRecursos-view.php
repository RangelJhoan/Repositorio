<?php
require_once "./controladores/recursoControlador.php";
require_once "./controladores/autorControlador.php";

$ins_recurso = new recursoControlador();
$insAutor = new autorControlador();

$datos = $ins_recurso->paginador_recurso_controlador();
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
                <a class="btn-add-record btnDocenteMis" title="Mis recursos" href="<?php echo SERVER_URL ?>docenteMisRecursos/">Mis recursos</a>
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
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="TÍTULO">
                                <a href="" target="_blank" class="irAlRecurso" title="Ir al recurso"><?php echo $rows['titulo'] ?></a></td>
                            </td>
                            <td data-titulo="AUTOR(ES)" class="responsive-file">
                            <?php
                                foreach($autoresRecurso as $campo){
                                    ?>
                                    <li><?php echo $campo['nombre'] . " " . $campo['apellido'] ?></li>
                                    <?php
                                }
                            ?>
                            </td>
                            <td data-titulo="CURSO(S)" class="responsive-file">
                            <?php
                                foreach($autoresRecurso as $campo){
                                    ?>
                                    <li><?php echo $campo['nombre'] . " " . $campo['apellido'] ?></li>
                                    <?php
                                }
                            ?>
                            </td>
                            <td data-titulo="PUBLICADO POR" class="responsive-file">Publicado por</td>
                            <td data-titulo="FECHA PUBLICACIÓN" class="responsive-file">2023-03-07 16:12:14</td>
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
