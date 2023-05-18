<?php
$peticionAjax = true;
const SERVER_URL = "http://localhost/Repositorio/";

use PHPUnit\Framework\TestCase;
require_once '../controladores/cursoControlador.php';

class CursoControladorTest extends TestCase{

    private $cursoControlador;

    public function setUp(): void {
        parent::setUp();
        $this->cursoControlador = new cursoControlador();
    }

    public function testAgregarCursoControlador(){
        // Simulamos los datos del formulario
        $_POST['nombre_ins'] = "Desarrollo de Aplicaciones Móviles I";
        $_POST['descripcion_ins'] = "Curso de desarrollo de aplicaciones móviles en lenguaje Java";
        $_POST['programas_ins'] = array(1);
        $_POST['docentes_ins'] = array(1);

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Curso creado correctamente"), $this->cursoControlador->agregarCursoControlador());
    }

    public function testEditarCursoControlador(){
        // Simulamos los datos del formulario
        $_POST['id_curso_edit'] = $this->cursoControlador->encryption(1);
        $_POST['nombre_edit'] = "Minería de Datos I";
        $_POST['descripcion_edit'] = "Descripción del programa de Minería de Datos I";
        $_POST['programas_edit'] = array(1);
        $_POST['docentes_edit'] = array(2);
        $_POST['estado'] = Utilidades::getIdEstado("ACTIVO");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-cursos/"), $this->cursoControlador->editarCursoControlador());
    }

    public function testEliminarAutorControlador(){
        // Simulamos los datos del formulario
        $_POST['id_curso_del'] = $this->cursoControlador->encryption(1);

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Curso eliminado exitosamente"), $this->cursoControlador->eliminarCursoControlador());
    }

    public function testPaginadorCursoControladorNoVacio(){
        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->cursoControlador->paginadorCursoControlador());
    }

}

?>