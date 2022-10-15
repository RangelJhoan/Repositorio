<body>
    <?php
        $peticionAjax = false;
        require_once "./controladores/vistasControlador.php";
        $IV = new vistasControlador();

        $vistas = $IV->obtener_vistas_controlador();

        if($vistas == "login" || $vistas == "404" || $vistas == "home"){
            require_once "./vistas/contenidos/".$vistas."-view.php";
        }else{
            echo "Poner plantilla";
            require_once $vistas;
        }
    ?>
</body>