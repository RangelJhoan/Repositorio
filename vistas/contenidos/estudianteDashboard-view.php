<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8"> -->
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="<?php echo SERVER_URL; ?>vistas/assets/css/estudiante/estudianteGestion-Style.css">
    <title>Repositorio Institucional</title>
</head>
<body>
    <?php 
    require_once "./controladores/usuarioControlador.php";
    require_once "./controladores/programaControlador.php";
    require_once "./controladores/cursoControlador.php";
    $ins_usuario = new usuarioControlador();
    $total_usuarios = $ins_usuario->datos_usuario_controlador("Conteo", 0);
    $ins_programa = new programaControlador();
    $total_programas = $ins_programa->datos_programa_controlador("Conteo", 0);
    $ins_curso = new cursoControlador();
    $total_cursos = $ins_curso->datos_curso_controlador("Conteo", 0);

    ?>
    <section class="dashboard-container">
        <div class="overview">
            <div class="title">
                <i class="uil uil-dashboard"></i>
                <h1 class="panel-title-name">Dashboard</h1>
            </div>
            <div class="cards-container" id="cards">
                <a href="<?php echo SERVER_URL ?>estudianteFavoritos/" class="card">
                    <span class="cards-title-name">Favoritos</span>
                    <i class="uil uil-users-alt"></i>
                    <span class="cards-total-count"><?php echo $total_usuarios->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>estudianteFeedbacks/" class="card">
                    <span class="cards-title-name">Feedbacks</span>
                    <i class="uil uil-feedback"></i>
                    <span class="cards-total-count"><?php echo $total_programas->rowCount(); ?></span>
                </a>
            </div>
        </div>
    </section>
</body>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/dashboard.js"></script> 
</html>