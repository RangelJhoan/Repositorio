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
            <div class="cards-container">
                <div class="card card1">
                    <span class="cards-title-name">Usuarios</span>
                    <i class="uil uil-users-alt"></i>
                    <span class="cards-total-count"><?php echo $total_usuarios->rowCount(); ?></span>
                </div>
                <div class="card card2">
                    <span class="cards-title-name">Programas</span>
                    <i class="uil uil-graduation-cap"></i>
                    <span class="cards-total-count"><?php echo $total_programas->rowCount(); ?></span>
                </div>
                <div class="card card3">
                    <span class="cards-title-name">Cursos</span>
                    <i class="uil uil-book-open"></i>
                    <span class="cards-total-count"><?php echo $total_cursos->rowCount(); ?></span>
                </div>
                <div class="card card4">
                    <span class="cards-title-name">Recursos</span>
                    <i class="uil uil-file-blank"></i>
                    <span class="cards-total-count">50</span>
                </div>
            </div>
        </div>
    </section>
</body>
</html>