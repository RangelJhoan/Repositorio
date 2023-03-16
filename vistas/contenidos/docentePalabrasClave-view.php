<?php
    require_once "./controladores/etiquetaControlador.php";
    require_once "./utilidades/Utilidades.php";
    $ins_etiqueta = new etiquetaControlador();
    $datos = $ins_etiqueta->paginador_etiqueta_controlador();
?>
    <section class="general-admin-container">
        <div class="overview-general-admin">
            <!--TÍTULO-->
            <div class="title">
                <i class="uil uil-tag"></i>
                <h1 class="panel-title-name">Palabras Clave</h1>
            </div>
            <!--BOTÓN MIS ETIQUETAS-->
            <div class="new-record-container">
                <a class="btn-add-record btnDocenteMis" title="Mis palabras clave" href="<?php echo SERVER_URL ?>docenteMisPalabrasClave/">Mis palabras clave</a>
            </div>
            <!--MODAL CREAR AUTOR-->
            <input type="checkbox" id="btn-modal-admin-add-record">
                <div class="container-modal-add-record">
                <div class="content-modal-add-record">
                    <h3 class="content-modal-titulo">Nueva palabra clave</h3>
                    <p class="content-modal-recordatorio">Recuerde que * indica que el campo es obligatorio.</p>
                    <form action="<?php echo SERVER_URL ?>ajax/etiquetaAjax.php" class="sign-up-form FormularioAjax" method="POST" data-form="save" autocomplete="off">
                        <div class="input-field">
                            <input name="descripcion_ins" type="text" placeholder="Nombre *" title="Por favor, complete el campo" required/>
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
            <div class="table-admin-container">
                <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Creado por</th>
                            <th>Fecha creación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($datos != 0){
                            $contador = 1;
                            foreach($datos as $rows){
                        ?>
                        <tr>
                            <td data-titulo="#"><?php echo $contador ?></td>
                            <td data-titulo="NOMBRE" class="responsive-file"><?php echo $rows['descripcion'] ?></td>
                            <td data-titulo="CREADO POR" class="responsive-file">Creado por</td>
                            <td data-titulo="FECHA CREACIÓN" class="responsive-file">2023-03-07 16:12:14</td>
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
