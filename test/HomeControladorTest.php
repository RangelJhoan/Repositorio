<?php
$peticionAjax = true;
const SERVER_URL = "http://localhost/Repositorio/";

use PHPUnit\Framework\TestCase;
require_once '../controladores/homeControlador.php';

class HomeControladorTest extends TestCase{

    private $homeControlador;

    public function setUp(): void {
        parent::setUp();
        $this->homeControlador = new homeControlador();
    }

    public function testListadoFiltroRecursosNoVacioBusqueda(){
        // Simulamos los datos enviados por parámetro
        $pTipo = "Busqueda";
        $pBuscar = $this->homeControlador->encryption("Bases");

        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->homeControlador->listadoFiltroRecursos($pTipo, $pBuscar));
    }

    public function testListadoFiltroRecursosNoVacioFiltro(){
        // Simulamos los datos enviados por parámetro
        $pTipo = "Curso";
        $pBuscar = "";

        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->homeControlador->listadoFiltroRecursos($pTipo, $pBuscar));
    }

    public function testBuscarInfoRecursoExistente(){
        // Simulamos los datos enviados por parámetro
        $pId = $this->homeControlador->encryption("1");

        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->homeControlador->buscarInfoRecurso($pId));
    }

    public function testCalificarRecursoUsuarioEstudianteODocente(){
        // Simulamos los datos enviados en el formulario
        $_POST['codrecurso'] = $this->homeControlador->encryption(1);;
        $_POST['respuestaFeedback'] = "Si";

        // Simulamos la sesión de la persona a calificar recurso
        $_SESSION['id_persona'] = 1;
        $_SESSION['tipo_usuario'] = "Estudiante";

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Gracias por evaluar el recurso y ayudar a mejorar su calidad. Su retroalimentación es muy valiosa y nos ayudará a identificar áreas de oportunidad para seguir mejorando y ofrecer recursos de gran utilidad."), $this->homeControlador->calificarRecurso());
    }

    public function testAgregarFavoritoEstudiante(){
        // Simulamos los datos enviados en el formulario
        $pId = $this->homeControlador->encryption(1);

        // Simulamos la sesión de la persona a calificar recurso
        $_SESSION['id_persona'] = 1;
        $_SESSION['tipo_usuario'] = "Estudiante";

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Recurso Agregado a Favoritos"), $this->homeControlador->agregarFavorito($pId));
    }

}

?>