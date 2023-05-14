<?php
$peticionAjax = true;
const SERVER_URL = "http://localhost/Repositorio/";

use PHPUnit\Framework\TestCase;
require_once '../controladores/autorControlador.php';

class AutorControladorTest extends TestCase{

    private $autorControlador;

    public function setUp(): void {
        parent::setUp();
        $this->autorControlador = new autorControlador();
    }

    public function testAgregarAutorControlador(){
        // Simulamos los datos del formulario
        $_POST['nombre_ins'] = "Carlos Rodrigo";
        $_POST['apellido_ins'] = "Guzmán";

        // Simulamos la sesión del usuario
        $_SESSION['id_persona'] = 1; // Debemos eliminar en el controlador la inicialización de la variable sesión para evitar duplicados

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Autor creado correctamente"), $this->autorControlador->agregarAutorControlador());
    }

    public function testEditarAutorControlador(){
        // Simulamos los datos del formulario
        $_POST['id_autor_edit'] = $this->autorControlador->encryption("1");
        $_POST['nombre_edit'] = "Nombre autor prueba edición";
        $_POST['apellido_edit'] = "Apellido autor prueba edición";
        $_POST['estado'] = Utilidades::getIdEstado("ACTIVO");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-autores/"), $this->autorControlador->editarAutorControlador());
    }

    public function testEliminarAutorControlador(){
        // Simulamos los datos del formulario
        $_POST['id_autor_del'] = $this->autorControlador->encryption("1");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Autor eliminado exitosamente"), $this->autorControlador->eliminarAutorControlador());
    }

    public function testPaginadorAutorControladorNoVacio(){
        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->autorControlador->paginadorAutorControlador(null));
    }

}

?>