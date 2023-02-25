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

    $ins_usuario = new usuarioControlador();
    $total_usuarios = $ins_usuario->datos_usuario_controlador("Conteo", 0);
    
    $ins_programa = new programaControlador();
    $total_programas = $ins_programa->datos_programa_controlador("Conteo", 0);
    
    $ins_curso = new cursoControlador();
    $total_cursos = $ins_curso->datos_curso_controlador("Conteo", 0);

    $ins_autor = new autorControlador();
    $total_autores = $ins_autor->datos_autor_controlador("Conteo", 0);


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
                    <span class="cards-total-count">50</span>
                </a>
                <a href="<?php echo SERVER_URL ?>adminAutores/" class="card">
                    <span class="cards-title-name">Autores</span>
                    <i class="uil uil-pen"></i>
                    <span class="cards-total-count"><?php echo $total_autores->rowCount(); ?></span>
                </a>
                <a href="<?php echo SERVER_URL ?>panelEtiquetas/" class="card">
                    <span class="cards-title-name">Etiquetas</span>
                    <i class="uil uil-tag"></i>
                    <span class="cards-total-count">50</span>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"></script>

<?php
// $sql = "SELECT COUNT(*) AS count FROM usuario WHERE id_tipo_usuario=1";
// $result = $conn->query($sql);
// $admin_count = $result->fetch_assoc()["count"];

// $sql = "SELECT COUNT(*) AS count FROM usuario WHERE id_tipo_usuario=2";
// $result = $conn->query($sql);
// $docente_count = $result->fetch_assoc()["count"];

// $sql = "SELECT COUNT(*) AS count FROM usuario WHERE id_tipo_usuario=3";
// $result = $conn->query($sql);
// $estudiante_count = $result->fetch_assoc()["count"];

// $data = array(
//     $admin_count,
//     $docente_count,
//     $estudiante_count
// );
?>



<script>
const ctx = document.getElementById('myChart');
const earn = document.getElementById('earnings');
new Chart(ctx, {
    type: 'polarArea',
    data: {
    labels: ['Administradores', 'Docentes', 'Estudiantes'],
    datasets: [{
        label: 'Número de usuarios',
        data: [1, 2, 3],
        // data: <?//php echo json_encode($data); ?>

        borderWidth: 1
    }]
    },
    options: {
        scales: {
            y: {
            beginAtZero: true,
            responsive:false
            }
        },
        plugins:{
            title:{
                display:true,
                text: 'Cantidad específica de usuarios',
                font:{
                    size:18,
                    weight:'bold'
                    }
                }
            }
        }
    });

new Chart(earn, {
    type: 'bar',
    data: {
    labels: ['Administradores', 'Docentes', 'Estudiantes'],
    datasets: [{
        label: 'Archivos de recursos:',
        data: [1, 2, 3],
        borderWidth: 1
    }]
    },
    options: {
    scales: {
        y: {
        beginAtZero: true,
        responsive:false
    }
        },
        plugins:{
            title:{
                display:true,
                text: 'Cantidad específica de los tipos de archivos',
                font:{
                    size:18,
                    weight:'bold'
                    }
                }
            }
        }
    });
</script>
</html>