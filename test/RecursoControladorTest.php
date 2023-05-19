<?php
$peticionAjax = true;
const SERVER_URL = "http://localhost/Repositorio/";

use PHPUnit\Framework\TestCase;
require_once '../controladores/recursoControlador.php';

class RecursoControladorTest extends TestCase{

    private $recursoControlador;

    public function setUp(): void {
        parent::setUp();
        $this->recursoControlador = new recursoControlador();
    }

    public function testAgregarRecursoControlador(){
        // Simulamos los datos del formulario
        $_POST['titulo_docente_ins'] = "Título recurso";
        $_POST['resumen_docente_ins'] = "Resumen prueba inserción";
        $_POST['editorial_docente_ins'] = "Editorial";
        $_POST['ISBN_docente_ins'] = "ISBN recurso";
        $_POST['anioRecurso_docente'] = "2023";
        $_POST['link_docente_ins'] = "";

        $_POST['cursos_docente_ins'] = array(1);
        $_POST['etiquetas_docente_ins'] = array();
        $_POST['autores_docente_ins'] = array();

        $_SESSION['id_persona'] = 1;
        $_SESSION['documento_usuario'] = "1234567890";

        // Simulamos los datos del archivo
        $archivoSubido = [
            'name' => 'prueba.txt',
            'type' => 'text/plain',
            'size' => 100,
            'tmp_name' => '../test/prueba.txt',
            'error' => UPLOAD_ERR_OK
        ];
        $_FILES['archivo'] = $archivoSubido;

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("redireccionar", "Recurso creado correctamente", SERVER_URL."docente-mis-recursos/"), $this->recursoControlador->agregarDocenteRecursoControlador());
    }

    public function testEditarRecursoControlador(){
        // Simulamos los datos del formulario
        $_POST['id_recurso_edit'] = $this->recursoControlador->encryption(1);
        $_POST['titulo_edit'] = "Título prueba edición";
        $_POST['resumen_edit'] = "Resumen prueba edición";
        $_POST['editorial_edit'] = "Editorial prueba edición";
        $_POST['ISBN_edit'] = "ISBN prueba edición";
        $_POST['anioRecurso_edit'] = "2023";
        $_POST['link_edit'] = "https://chat.openai.com/";
        $_POST['estado_edit'] = Utilidades::getIdEstado("ACTIVO");

        $_POST['cursos_edit'] = array(1);
        $_POST['etiquetas_edit'] = array();
        $_POST['autores_edit'] = array();

        $_SESSION['documento_usuario'] = "123456789";

        // Simulamos los datos del archivo
        $archivoSubido = [
            'name' => 'prueba.txt',
            'type' => 'text/plain',
            'size' => 100,
            'tmp_name' => '../test/prueba.txt',
            'error' => UPLOAD_ERR_OK
        ];
        $_FILES['archivo'] = $archivoSubido;

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-recursos/"), $this->recursoControlador->editarRecursoControlador());
    }

    public function testEliminarRecursoControlador(){
        // Simulamos los datos del formulario
        $_POST['id_recurso_del'] = $this->recursoControlador->encryption(1);

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Recurso eliminado exitosamente"), $this->recursoControlador->eliminarRecursoControlador());
    }

    public function testPaginadorRecursoControladorNoVacio(){
        // Ejecutamos el método a probar
        $this->assertNotEmpty($this->recursoControlador->paginadorRecursoControlador(null));
    }

}

?>