<?php
$peticionAjax = true;
const SERVER_URL = "http://localhost/Repositorio/";

use PHPUnit\Framework\TestCase;
require_once '../controladores/etiquetaControlador.php';

class EtiquetaControladorTest extends TestCase{

    private $etiquetaControlador;

    public function setUp(): void {
        parent::setUp();
        $this->etiquetaControlador = new etiquetaControlador();
    }

    public function testAgregarEtiquetaControlador(){
        // Simulamos los datos del formulario
        $_POST['descripcion_ins'] = "Descripción etiqueta prueba";
        $_SESSION['id_persona'] = 1;

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Etiqueta creada correctamente"), $this->etiquetaControlador->agregarEtiquetaControlador());
    }

    public function testEditarEtiquetaControlador(){
        // Simulamos los datos del formulario
        $_POST['id_etiqueta_edit'] = $this->etiquetaControlador->encryption("1");
        $_POST['descripcion_edit'] = "Nombre etiqueta prueba edición";
        $_POST['estado'] = Utilidades::getIdEstado("ACTIVO");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."panel-palabras-clave/"), $this->etiquetaControlador->editarEtiquetaControlador());
    }

    public function testEliminarEtiquetaControlador(){
        // Simulamos los datos del formulario
        $_POST['id_etiqueta_del'] = $this->etiquetaControlador->encryption("1");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Etiqueta eliminada exitosamente"), $this->etiquetaControlador->eliminarEtiquetaControlador());
    }

    public function testPaginadorEtiquetaControladorNoVacio(){
        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->etiquetaControlador->paginadorEtiquetaControlador(null));
    }

}

?>