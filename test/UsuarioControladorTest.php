<?php
$peticionAjax = true;
const SERVER_URL = "http://localhost/Repositorio/";
const SUPER_ADMIN_EMAIL = "sa.repositorioinstitucional@gmail.com";

use PHPUnit\Framework\TestCase;
require_once '../controladores/usuarioControlador.php';

class UsuarioControladorTest extends TestCase{

    private $usuarioControlador;

    public function setUp(): void {
        parent::setUp();
        $this->usuarioControlador = new usuarioControlador();
    }

    public function testAgregarUsuarioControladorConSesionSuperAdmin(){
        // Simulamos la sesión
        $_SESSION['correo_usuario'] = "sa.repositorioinstitucional@gmail.com";

        // Simulamos los datos del formulario
        // Datos de la persona
        $_POST['nombre'] = "Ana";
        $_POST['apellido'] = "Correa";
        $_POST['tipoDocumento'] = 1;
        $_POST['documento'] = "1202615845";
        $_POST['estado'] = "1";

        //Datos del usuario
        $_POST['tipoUsuario'] = 1;
        $_POST['correo'] = "ana.correa@gmail.com";

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Usuario creado correctamente"), $this->usuarioControlador->agregarUsuarioControlador());
    }

    public function testAgregarAdministradorSinSesionSuperAdmin(){
        // Simulamos la sesión
        $_SESSION['correo_usuario'] = "pedro.claveles@gmail.com";

        // Simulamos los datos del formulario
        // Datos de la persona
        $_POST['nombre'] = "Carlos";
        $_POST['apellido'] = "Valenzuela";
        $_POST['tipoDocumento'] = 1;
        $_POST['documento'] = "109814531";
        $_POST['estado'] = "1";

        //Datos del usuario
        $_POST['tipoUsuario'] = 1;
        $_POST['correo'] = "carlos.valenzuela@gmail.com";

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaErrorJSON("simple", "Usted no cuenta con los permisos necesarios para realizar esta acción"), $this->usuarioControlador->agregarUsuarioControlador());
    }

    public function testEditarUsuarioControlador(){
        // Simulamos la sesión
        $_SESSION['correo_usuario'] = "sa.repositorioinstitucional@gmail.com";

        // Simulamos los datos del formulario
        // Datos de la persona
        $_POST['id_usuario_editar'] = $this->usuarioControlador->encryption("2");;
        $_POST['nombre'] = "Ana";
        $_POST['apellido'] = "Correa Dos";
        $_POST['tipoDocumento'] = 1;
        $_POST['documento'] = "109754212";
        $_POST['estado'] = "1";

        //Datos del usuario
        $_POST['tipoUsuario'] = 1;
        $_POST['correo'] = "ana.correa@gmail.com";
        $_POST['clave'] = "Repo2023*";
        $_POST['confirmarClave'] = "Repo2023*";

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados exitosamente", SERVER_URL."admin-usuarios/"), $this->usuarioControlador->editarUsuarioControlador());
    }

    public function testEliminarUsuarioControlador(){
        // Simulamos los datos del formulario
        $_POST['idPersona'] = $this->usuarioControlador->encryption("3");
        $_POST['idUsuario'] = $this->usuarioControlador->encryption("3");

        // Ejecutamos el método a probar
        $this->assertEquals(Utilidades::getAlertaExitosoJSON("recargar", "Usuario eliminado exitosamente"), $this->usuarioControlador->eliminarUsuarioControlador());
    }

    public function testPaginadorUsuarioControladorNoVacio(){
        // Ejecutamos el método a probar
        $_SESSION['correo_usuario'] = "sa.repositorioinstitucional@gmail.com";
        $this->assertNotEmpty($this->usuarioControlador->paginadorUsuarioControlador(null));
    }

}

?>