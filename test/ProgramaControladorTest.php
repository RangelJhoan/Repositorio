<?php
$peticionAjax = true;
const SERVER_URL = "http://localhost/Repositorio/";

use PHPUnit\Framework\TestCase;
require_once '../controladores/programaControlador.php';

class ProgramaControladorTest extends TestCase{

    private $programaControlador;

    public function setUp(): void {
        parent::setUp();
        $this->programaControlador = new programaControlador();
    }

    public function testAgregarProgramaControlador(){
        // Simulamos los datos del formulario
        $_POST['nombre_ins'] = "Ingeniería Electrónica";
        $_POST['descripcion_ins'] = "Descripción del programa de prueba";

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Programa creado correctamente"), $this->programaControlador->agregarProgramaControlador());
    }

    public function testEditarProgramaControlador(){
        // Simulamos los datos del formulario
        $_POST['id_programa_edit'] = $this->programaControlador->encryption("1");
        $_POST['nombre_edit'] = "Programa prueba edición";
        $_POST['descripcion_edit'] = "Nueva descripción del programa de prueba a editar los datos";
        $_POST['estado'] = Utilidades::getIdEstado("ACTIVO");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-programas/"), $this->programaControlador->editarProgramaControlador());
    }

    public function testEliminarProgramaControlador(){
        // Simulamos los datos del formulario
        $_POST['id_programa_del'] = $this->programaControlador->encryption("1");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Programa eliminado exitosamente"), $this->programaControlador->eliminarProgramaControlador());
    }

    public function testPaginadorProgramaControladorNoVacio(){
        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->programaControlador->paginadorProgramaControlador());
    }

}

?>