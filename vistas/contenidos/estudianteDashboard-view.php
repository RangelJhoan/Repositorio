<?php 
require_once "./controladores/recursoControlador.php";
require_once "./controladores/recursoControlador.php";

$insRecurso = new recursoControlador();
$insRecurso = new recursoControlador();

$recursosFavoritos = $insRecurso->obtenerListaFavoritosXPersona($_SESSION['id_persona']);
$recursosCalificados = $insRecurso->obtenerListaCalificadosXPersona($_SESSION['id_persona']);
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
                <i class="uil uil-heart-alt"></i>
                <span class="cards-total-count"><?php echo count($recursosFavoritos); ?></span>
            </a>
            <a href="<?php echo SERVER_URL ?>estudianteFeedbacks/" class="card">
                <span class="cards-title-name">Feedbacks</span>
                <i class="uil uil-feedback"></i>
                <span class="cards-total-count"><?php echo count($recursosCalificados); ?></span>
            </a>
        </div>
    </div>
</section>
<script src="<?php echo SERVER_URL ?>vistas/assets/js/dashboard.js"></script> 
