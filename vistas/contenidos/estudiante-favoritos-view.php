<section class="dashboard-container">
        <div class="overview">
            <div class="title">
                <i class="uil uil-heart-alt"></i>
                <h1 class="panel-title-name">Favoritos</h1>
            </div>
            <!--TABLA-->
            <?php
                require_once "./controladores/recursoControlador.php";
                $insRecurso = new recursoControlador();
                $recursosFavoritos = $insRecurso->obtenerListaFavoritosXPersona($_SESSION['id_persona']);

            ?>
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Título</th>
                            <th>Autor(es)</th>
                            <th>Archivo</th>
                            <th>Publicado por</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($recursosFavoritos != 0){
                            require_once "./controladores/autorControlador.php";
                            $insAutor = new autorControlador();
                            $contador = 1;
                            foreach($recursosFavoritos as $recurso){
                                $autoresRecurso = $insAutor->autoresXRecursoControlador($recurso['id_recurso']);
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="TÍTULO" class="responsive-file"><?php echo $recurso['titulo'] ?></td>
                            <td data-titulo="AUTOR(ES)" class="responsive-file">
                            <?php
                                foreach($autoresRecurso as $campo){
                                    ?><ul>
                                        <li><?php echo $campo['nombre'] . " " . $campo['apellido'] ?></li>
                                    </ul>
                                    <?php
                                }
                            ?>
                            </td>
                            <td data-titulo="ARCHIVO" class="responsive-file fileStyleResp"><?php echo $recurso['nombre'] ?></td>
                            <td data-titulo="PUBLICADO POR" class="responsive-file"><?php echo $recurso['nombre_docente'] . " " . $recurso['apellido_docente'] ?></td>
                            <td data-titulo="ACCIÓN" class="responsive-file">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL?>handle/<?php echo $insRecurso->encryption($recurso['id_recurso'])?>/" target="_blank" class="btn-admin-view-record" title="Ir al recurso"><i class="uil uil-eye btn-admin-view-record"></i></a>
                                    </div>
                                    <form action="<?php echo SERVER_URL ?>ajax/recursoAjax.php" class="FormularioAjax" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="id_recurso_favorito_del" value="<?php echo $insRecurso->encryption($recurso['id_recurso'])?>">
                                            <button type="submit" class="btn-delete-record" title="Eliminar de favoritos"><i class="uil uil-heart-alt"></i></button>
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
    <script src="<?php echo SERVER_URL ?>vistas/assets/js/datatables.js"></script> 