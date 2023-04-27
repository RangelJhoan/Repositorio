<?php
    require_once "./controladores/autorControlador.php";
    require_once "./controladores/etiquetaControlador.php";
    require_once "./controladores/recursoControlador.php";

    $insRecurso = new recursoControlador();
    $totalRecursos = $insRecurso->datos_recurso_controlador("Conteo", 0);
    $recursosCalificados = $insRecurso->obtenerListaCalificadosXPersona($_SESSION['id_persona']);

    $ins_autor = new autorControlador();
    $total_autores = $ins_autor->datosAutorControlador("Conteo", 0);

    $ins_etiqueta = new etiquetaControlador();
    $total_etiquetas = $ins_etiqueta->datosEtiquetaControlador("Conteo", 0);

    ?>
    <section class="dashboard-container">
        <div class="overview">
            <div class="title">
                <i class="uil uil-dashboard"></i>
                <h1 class="panel-title-name">Dashboard</h1>
            </div>
            <div class="cards-container" id="cards">
                <a href="<?php echo SERVER_URL ?>docente-autores/" class="card">
                    <span class="cards-title-name">Autores</span>
                    <i class="uil uil-pen"></i>
                    <span class="cards-total-count"><?php echo $total_autores->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>docente-palabras-clave/" class="card">
                    <span class="cards-title-name">Palabras Clave</span>
                    <i class="uil uil-tag"></i>
                    <span class="cards-total-count"><?php echo $total_etiquetas->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>docente-recursos/" class="card">
                    <span class="cards-title-name">Recursos</span>
                    <i class="uil uil-file-blank"></i>
                    <span class="cards-total-count"><?php echo $totalRecursos->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>estudiante-feedbacks/" class="card">
                    <span class="cards-title-name">Feedbacks</span>
                    <i class="uil uil-feedback"></i>
                    <span class="cards-total-count"><?php echo count($recursosCalificados); ?></span>
                </a>
            </div>
        </div>
        <section class="graphics">
            <div class="graphBox">
                <div class="box">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </section>
    </section>
</body>
<script type="module" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.1/chart.umd.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/docente_dashboard.js"></script> 

