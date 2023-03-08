<!--//* Contenedor principal  -->
<main class="mainContarinerFilters">
    <section class = "tableWithContent">
        <!--//* DATATABLE  -->
        <section class="general-tableJQ-container">
            <div class="overview-general-admin">
                <!--TÍTULO-->
                <div class="title">
                    <i><img src="<?php echo SERVER_URL; ?>vistas/assets/img/fechaHome.svg" class="titleImgIcon" alt="Fecha Img" /></i>
                    <h1 class="panel-title-name">Filtro por fecha de creación</h1>
                </div>

<!--FILTRO POR COMBO AÑOS-->
                <?php
                require_once "./controladores/homeControlador.php";
                $ins_home = new homeControlador();
                $fechas = $ins_home->capturar_fecha_recurso();

                // Función de comparación para ordenar los años
                function comparar_anos($a, $b) {
                    return $b - $a;
                }

                // Extraer los años de las fechas y eliminar duplicados
                $array = array_unique(array_map(function($fecha) {
                    /* 
                    1. El primer parámetro $fecha['fecha'] es la cadena de la cual se va a extraer una parte.
                    2. El segundo parámetro 0 indica que la extracción debe comenzar desde el primer caracter de la cadena (índice 0).
                    3. El tercer parámetro 4 indica que se deben extraer 4 caracteres a partir del índice 0, es decir, los primeros 4 caracteres de la cadena.*/
                    return substr($fecha['fecha'], 0, 4);
                }, $fechas));

                // Ordenar los años de forma descendente
                usort($array, 'comparar_anos');
                ?>
                <form action="<?php echo SERVER_URL ?>ajax/homeAjax.php" method="POST">
                    <div class="containerComboAños">
                        <p class="dataTables_length">Recursos creados en </p>
                        <select name="codano" id="codano">
                            <option value="" disabled selected>año</option>
                            <?php foreach($array AS $ano){?>
                                <option value="<?php echo $ano; ?>"><?php echo $ano; ?></option>
                            <?php } ?>
                        </select>
                        <input type="submit" value="Buscar" class="buttonSearchYear">
                    </div>
                </form>

                <div class="panel-title-name table-dataJQ-container">
                    <table id="tablaUsuarios" class="tb-admin-records">
                    <thead>
                            <tr>
                                <td class="titleTableFilterSearch">Fecha</td>
                                <td class="titleTableFilterSearch">Título</td>
                                <td class="titleTableFilterSearch">Autor(es)</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $datos_filtro = $ins_home->listado_filtro_recursos($pagina[1],$pagina[2]);
                            foreach($datos_filtro as $vRecurso){
                            $autores = $ins_home->cargar_informacion_recurso($vRecurso['id']);
                            ?>
                            <tr>
                                <td data-titulo="FECHA"><a href="#" class="deleteRedireccionTable"><?php echo $vRecurso['fecha_publicacion_recurso'];?></a></td>
                                <td data-titulo="TITULO"><a href="#" class="redireccionTable"><?php echo $vRecurso['titulo']; ?> </a></td>
                                <td data-titulo="AUTOR(ES)"><a href="#" class="deleteRedireccionTable italicTableStyle"><?php echo $autores; ?></a></td>
                            </tr>
                            <?php } ?>  
                            </tbody>
                    </table>
                </div>
            <div>
        </section>        
    </section>
<!--//* Contenedor aside filtros  -->
<?php include "asideHomeFilters-view.php";?>
</main>
<!--SCRIPTS NECESARIOS PARA EL DATATABLE-->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/datatables.js"></script>
</body>
</html>