<section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-pen"></i>
                <h1 class="panel-title-name">Mis Autores</h1>
            </div>
            <!--BOTÓN CREAR-->
            <div class="new-record-container">
                <label for="btn-modal-admin-add-record" class="btn-add-record" title="Crear autor">
                    <i class="uil uil-plus-circle"></i>Nuevo
                </label>
            </div>
            <!--MODAL CREAR AUTOR-->
            <input type="checkbox" id="btn-modal-admin-add-record">
                <div class="container-modal-add-record">
                <div class="content-modal-add-record">
                    <h3 class="content-modal-titulo">Nuevo autor</h3>
                    <p class="content-modal-recordatorio">Recuerde que * indica que el campo es obligatorio.</p>
                    <form action="<?php echo SERVER_URL ?>ajax/autorAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field">
                            <input name="nombre_ins" type="text" placeholder="Nombres" title="Por favor, complete el campo"/>
                        </div>
                        <div class="input-field">
                            <input name="apellido_ins" type="text" placeholder="Apellidos *" title="Por favor, complete el campo" required/>
                        </div>
                        <div class="botones-accion-modal">
                            <input type="submit" class="btn-submit-add-record" value="Crear" />
                            <label for="btn-modal-admin-add-record" class="btn-close-add-record">Cerrar</label>
                        </div>
                    </form>
                </div>
                <label for="btn-modal-admin-add-record" class="cerrar-modal"></label>
            </div>

            <!--TABLA-->
            <?php
                require_once "./controladores/autorControlador.php";
                require_once "./utilidades/Utilidades.php";
                $ins_autor = new autorControlador();
                $datos = $ins_autor->paginador_autor_controlador($_SESSION['id_persona']);
            ?>
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($datos != 0){
                            $contador = 1;
                            foreach($datos as $rows){
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador; ?></td>
                            <td data-titulo="NOMBRE" class="responsive-file"><?php echo $rows['nombre'] ?></td>
                            <td data-titulo="APELLIDO" class="responsive-file"><?php echo $rows['apellido'] ?></td>
                            <td data-titulo="ESTADO" class="responsive-file"><?php echo Utilidades::getNombreEstado($rows['estado']) ?></td>
                            <td data-titulo="ACCIÓN" class="responsive-file">
                                <div class="action-options-container">
                                    <div class="btn-group-action">
                                        <a href="<?php echo SERVER_URL ?>adminEditarAutor/<?php echo $ins_autor->encryption($rows['id'])?>/" class="btn-admin-edit-record" title="Editar autor"><i class="uil uil-edit btn-admin-edit-record"></i></a>
                                    </div>
                                    <form class="FormularioAjax" action="<?php echo SERVER_URL?>ajax/autorAjax.php" method="POST" data-form="delete" autocomplete="off">
                                        <div class="btn-group-action">
                                            <input type="hidden" name="id_autor_del" value="<?php echo $ins_autor->encryption($rows['id']) ?>">
                                            <button type="submit" class="btn-delete-record" title="Eliminar autor"><i class="uil uil-trash-alt"></i></button>
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