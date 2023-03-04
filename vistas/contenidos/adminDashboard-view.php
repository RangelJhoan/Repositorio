<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8"> -->
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/admin/adminGestion-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
    <?php 
    require_once "./controladores/usuarioControlador.php";
    require_once "./controladores/programaControlador.php";
    require_once "./controladores/cursoControlador.php";
    require_once "./controladores/autorControlador.php";
    require_once "./controladores/etiquetaControlador.php";
    require_once "./controladores/recursoControlador.php";

    $ins_usuario = new usuarioControlador();
    $total_usuarios = $ins_usuario->datos_usuario_controlador("Conteo", 0);

    $ins_programa = new programaControlador();
    $total_programas = $ins_programa->datos_programa_controlador("Conteo", 0);

    $ins_curso = new cursoControlador();
    $total_cursos = $ins_curso->datos_curso_controlador("Conteo", 0);

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
                <a href="<?php echo SERVER_URL ?>adminUsuarios/" class="card">
                    <span class="cards-title-name">Usuarios</span>
                    <i class="uil uil-users-alt"></i>
                    <span class="cards-total-count"><?php echo $total_usuarios->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>adminProgramas/" class="card">
                    <span class="cards-title-name">Programas</span>
                    <i class="uil uil-graduation-cap"></i>
                    <span class="cards-total-count"><?php echo $total_programas->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>adminCursos/" class="card">
                    <span class="cards-title-name">Cursos</span>
                    <i class="uil uil-book-open"></i>
                    <span class="cards-total-count"><?php echo $total_cursos->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>adminRecursos/" class="card">
                    <span class="cards-title-name">Recursos</span>
                    <i class="uil uil-file-blank"></i>
                    <span class="cards-total-count"><?php echo $totalRecursos->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>adminAutores/" class="card">
                    <span class="cards-title-name">Autores</span>
                    <i class="uil uil-pen"></i>
                    <span class="cards-total-count"><?php echo $total_autores->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>panelEtiquetas/" class="card">
                    <span class="cards-title-name">Etiquetas</span>
                    <i class="uil uil-tag"></i>
                    <span class="cards-total-count"><?php echo $total_etiquetas->rowCount(); ?></span>
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

</html>