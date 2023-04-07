<?php
    require_once "./controladores/autorControlador.php";
    require_once "./controladores/etiquetaControlador.php";
    require_once "./controladores/recursoControlador.php";

    $insRecurso = new recursoControlador();
    $totalRecursos = $insRecurso->datos_recurso_controlador("Conteo", 0);

    $ins_autor = new autorControlador();
    $total_autores = $ins_autor->datos_autor_controlador("Conteo", 0);

    $ins_etiqueta = new etiquetaControlador();
    $total_etiquetas = $ins_etiqueta->datos_etiqueta_controlador("Conteo", 0);

    ?>
    <section class="dashboard-container">
        <div class="overview">
            <div class="title">
                <i class="uil uil-dashboard"></i>
                <h1 class="panel-title-name">Dashboard</h1>
            </div>
            <div class="cards-container" id="cards">
                <a href="<?php echo SERVER_URL ?>docenteAutores/" class="card">
                    <span class="cards-title-name">Autores</span>
                    <i class="uil uil-pen"></i>
                    <span class="cards-total-count"><?php echo $total_autores->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>docentePalabrasClave/" class="card">
                    <span class="cards-title-name">Palabras Clave</span>
                    <i class="uil uil-tag"></i>
                    <span class="cards-total-count"><?php echo $total_etiquetas->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>docenteRecursos/" class="card">
                    <span class="cards-title-name">Recursos</span>
                    <i class="uil uil-file-blank"></i>
                    <span class="cards-total-count"><?php echo $totalRecursos->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>estudianteFeedbacks/" class="card">
                    <span class="cards-title-name">Feedbacks</span>
                    <i class="uil uil-feedback"></i>
                    <span class="cards-total-count">Meter contador</span>
                </a>
            </div>
        </div>
        <section class="graphics">
            <div class="graphBox">
                <div class="box">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="box">
                    <canvas id="earnings"></canvas>
                </div>
            </div>
        </section>
    </section>
</body>
<script type="module" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.1/chart.umd.js"></script>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/dashboard.js"></script> 

