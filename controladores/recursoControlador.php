<?php

if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../modelos/recursoModelo.php";
    require_once "../entidades/Recurso.php";
    require_once "../entidades/Archivo.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./modelos/recursoModelo.php";
    require_once "./entidades/Recurso.php";
    require_once "./entidades/Archivo.php";
}

class recursoControlador extends recursoModelo{

    /*---------- Controlador para agregar programa ----------*/
    public function agregar_recurso_controlador(){
        $recurso = new Recurso();
        $recurso->setTitulo(mainModel::limpiarCadena($_POST['titulo_ins']));
        $recurso->setResumen(mainModel::limpiarCadena($_POST['resumen_ins']));
        $recurso->setEstado(Utilidades::getIdEstado("ACTIVO"));
        $recurso->setEtiqueta(array());
        $recurso->setAutor(array());

        if(isset($_POST['editorial_ins'])){
            $recurso->setEditorial(mainModel::limpiarCadena($_POST['editorial_ins']));
        }

        if(isset($_POST['ISBN_ins'])){
            $recurso->setISBN(mainModel::limpiarCadena($_POST['ISBN_ins']));
        }

        if(isset($_POST['autores_ins']))
            $recurso->setAutor($_POST['autores_ins']);

        if(!isset($_POST['cursos_ins'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor seleccione un curso");
            exit();
        }

        $recurso->setCurso($_POST['cursos_ins']);

        if(isset($_POST['etiquetas_ins']))
            $recurso->setEtiqueta($_POST['etiquetas_ins']);

        if(isset($_POST['link_ins'])){
            $recurso->setEnlace(mainModel::limpiarCadena($_POST['link_ins']));
            if($recurso->getEnlace() != "" && !mainModel::verificarDatos("(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?", $recurso->getEnlace())){
                echo Utilidades::getAlertaErrorJSON("simple", "El enlace ingresado no es válido");
                exit();
            }
        }

        if($_POST['anioRecurso']!=""){
            $recurso->setFecha(mainModel::limpiarCadena($_POST['anioRecurso']));
        }else{
            $recurso->setFecha("s.f");
        }

        if ($recurso->getFecha() != "s.f" && !(is_numeric($recurso->getFecha()) && strlen($recurso->getFecha()) == 4 && $recurso->getFecha() >= 1000 && $recurso->getFecha() <= date('Y'))) {
            echo Utilidades::getAlertaErrorJSON("simple", "La fecha ingresada no es válida");
            exit();
        }

        if($recurso->getTitulo() == "" || $recurso->getResumen() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }else{
            if(!isset($_FILES["archivo"]["name"]) && $recurso->getEnlace() == ""){
                echo Utilidades::getAlertaErrorJSON("simple", "Por favor ingrese un enlace o seleccione un archivo");
                exit();
            }

            //El tamaño máximo permitido para almacenar un archivo son 100 megas = 104857600 bytes
            if(isset($_FILES["archivo"]["name"]) && $_FILES["archivo"]["size"] > 104857600){
                echo Utilidades::getAlertaErrorJSON("simple", "El tamaño del archivo excede el limite permitido (100MB)");
                exit();
            }

            $agregar_recurso = recursoModelo::agregar_recurso_modelo($recurso);

            if(is_string($agregar_recurso) || $agregar_recurso < 0){
                echo Utilidades::getAlertaErrorJSON("simple", "Ups! Hubo un problema al cargar el recurso. Por favor intente nuevamente.");
                exit();
            }

            self::crearArchivo($recurso);

            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Recurso creado correctamente", SERVER_URL."admin-recursos/");
        }

    }

    /**
     * Paginador de recursos, vista en panel de Admin
     *
     * @return Object Lista de los recursos consultados
     */
    public function paginador_recurso_controlador($idPersona, $isActivo = false){
        $consulta = "SELECT r.id as idRecurso, r.titulo, r.puntos_positivos, r.puntos_negativos, r.estado, r.fecha_publicacion_profesor, p.nombre, p.apellido 
        FROM recurso r 
        JOIN persona p ON p.id = r.id_docente 
        WHERE r.estado != " . Utilidades::getIdEstado("ELIMINADO") . " ";

        if($idPersona != null)
            $consulta .= " AND p.id = " . $idPersona;

        if($isActivo)
            $consulta .= " AND r.estado = " . Utilidades::getIdEstado("ACTIVO");

        $consulta .= " ORDER BY r.id;";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

    /*---------- Controlador datos recurso ----------*/
    public function datos_recurso_controlador($tipo, $id){
        $id = mainModel::decryption($id);

        return recursoModelo::datos_recurso_modelo($tipo, $id);
    }

    /*---------- Controlador archivo por recurso ----------*/
    public function archivoXRecursoControlador($id){
        return recursoModelo::archivoXRecursoModelo($id)->fetch();
    }

    public function eliminar_recurso_controlador(){
        $recurso = new Recurso();
        $recurso->setIdRecurso(mainModel::limpiarCadena(mainModel::decryption($_POST['id_recurso_del'])));
        $recurso->setEstado(Utilidades::getIdEstado("ELIMINADO"));

        $eliminarRecurso = recursoModelo::editar_estado_recurso_modelo($recurso);

        if(is_string($eliminarRecurso) || $eliminarRecurso < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el recurso");
            exit();
        }

        echo Utilidades::getAlertaExitosoJSON("recargar", "Recurso eliminado exitosamente");

    }

    public function editar_recurso_controlador(){
        $recurso = new Recurso();

        if(!isset($_POST['cursos_edit'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor seleccione un curso");
            exit();
        }

        $recurso->setIdRecurso(mainModel::limpiarCadena(mainModel::decryption($_POST['id_recurso_edit'])));

        //Comprobar que el recurso existe
        $checkRecurso = mainModel::ejecutar_consulta_simple("SELECT * FROM recurso WHERE id = '". $recurso->getIdRecurso() ."';");
        if($checkRecurso->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el recurso a editar");
            exit();
        }

        //Construimos el objeto de recurso con información actual o nueva
        $recurso->setTitulo(mainModel::limpiarCadena($_POST['titulo_edit']));
        $recurso->setResumen(mainModel::limpiarCadena($_POST['resumen_edit']));

        if($_POST['anioRecurso_edit']!=""){
            $recurso->setFecha(mainModel::limpiarCadena($_POST['anioRecurso_edit']));
        }else{
            $recurso->setFecha("s.f");
        }

        if(isset($_POST['editorial_edit'])){
            $recurso->setEditorial(mainModel::limpiarCadena($_POST['editorial_edit']));
        }

        if(isset($_POST['ISBN_edit'])){
            $recurso->setISBN(mainModel::limpiarCadena($_POST['ISBN_edit']));
        }

        $recurso->setEstado(mainModel::limpiarCadena($_POST['estado_edit']));
        $recurso->setCurso($_POST['cursos_edit']);
        $recurso->setEnlace(mainModel::limpiarCadena($_POST['link_edit']));
        $recurso->setAutor(array());
        $recurso->setEtiqueta(array());

        if(isset($_POST['etiquetas_edit']))
            $recurso->setEtiqueta($_POST['etiquetas_edit']);

        if(isset($_POST['autores_edit']))
            $recurso->setAutor($_POST['autores_edit']);

        if(isset($_POST['link_ins']))
            $recurso->setEnlace(mainModel::limpiarCadena($_POST['link_ins']));


        //Obtener las etiquetas seleccionadas (Agregar nuevas y Eliminar no seleccionadas)
        $etiquetasActuales = recursoModelo::idEtiquetasRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $etiquetasAgregadas = array_diff($recurso->getEtiqueta(), $etiquetasActuales);
        $etiquetasEliminadas = array_diff($etiquetasActuales, $recurso->getEtiqueta());

        recursoModelo::editar_recurso_etiqueta_modelo($recurso, $etiquetasAgregadas, $etiquetasEliminadas);

        //Obtener los autores seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $autoresActuales = recursoModelo::idAutoresRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $autoresAgregados = array_diff($recurso->getAutor(), $autoresActuales);
        $autoresEliminados = array_diff($autoresActuales, $recurso->getAutor());

        recursoModelo::editar_recurso_autor_modelo($recurso, $autoresAgregados, $autoresEliminados);

        //Obtener los cursos seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $cursosActuales = recursoModelo::idCursosRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $cursosAgregados = array_diff($recurso->getCurso(), $cursosActuales);
        $cursosEliminados = array_diff($cursosActuales, $recurso->getCurso());
        $editarRecurso = recursoModelo::editar_recurso_modelo($recurso, $cursosAgregados, $cursosEliminados);

        //Editamos o creamos la información del archivo del recurso
        self::editarArchivoRecurso($recurso);

        if(is_string($editarRecurso) || $editarRecurso->rowCount() < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información");
        }else{
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."admin-recursos/");
        }
    }

    /*---------- Controlador para agregar recurso desde el perfil de docente ----------*/
    public function agregar_docente_recurso_controlador(){
        $recurso = new Recurso();
        $recurso->setTitulo(mainModel::limpiarCadena($_POST['titulo_docente_ins']));
        $recurso->setResumen(mainModel::limpiarCadena($_POST['resumen_docente_ins']));
        $recurso->setEstado(Utilidades::getIdEstado("ACTIVO"));
        $recurso->setEtiqueta(array());
        $recurso->setAutor(array());

        if(isset($_POST['autores_docente_ins']))
            $recurso->setAutor($_POST['autores_docente_ins']);

        if(!isset($_POST['cursos_docente_ins'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor seleccione un curso");
            exit();
        }

        if(isset($_POST['editorial_docente_ins'])){
            $recurso->setEditorial(mainModel::limpiarCadena($_POST['editorial_docente_ins']));
        }

        if(isset($_POST['ISBN_docente_ins'])){
            $recurso->setISBN(mainModel::limpiarCadena($_POST['ISBN_docente_ins']));
        }

        $recurso->setCurso($_POST['cursos_docente_ins']);

        if(isset($_POST['etiquetas_docente_ins']))
            $recurso->setEtiqueta($_POST['etiquetas_docente_ins']);

        if(isset($_POST['link_docente_ins'])){
            $recurso->setEnlace(mainModel::limpiarCadena($_POST['link_docente_ins']));
            if($recurso->getEnlace() != "" && !mainModel::verificarDatos('(http(s)?:\/\/)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?(\/[a-zA-Z0-9\-\._\?\,\'\/\\\+&%\$#\=~]*)?', $recurso->getEnlace())){
                echo Utilidades::getAlertaErrorJSON("simple", "El enlace ingresado no es válido");
                exit();
            }
        }

        if($_POST['anioRecurso_docente']!=""){
            $recurso->setFecha(mainModel::limpiarCadena($_POST['anioRecurso_docente']));
        }else{
            $recurso->setFecha("s.f");
        }

        if ($recurso->getFecha() != "s.f" && !(is_numeric($recurso->getFecha()) && strlen($recurso->getFecha()) == 4 && $recurso->getFecha() >= 1000 && $recurso->getFecha() <= date('Y'))) {
            echo Utilidades::getAlertaErrorJSON("simple", "La fecha ingresada no es válida");
            exit();
        }

        if($recurso->getTitulo() == "" || $recurso->getResumen() == ""){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor llene todos los campos requeridos");
            exit();
        }else{
            if(!isset($_FILES["archivo"]["name"]) && $recurso->getEnlace() == ""){
                echo Utilidades::getAlertaErrorJSON("simple", "Por favor ingrese un enlace o seleccione un archivo");
                exit();
            }

            //El tamaño máximo permitido para almacenar un archivo son 100 megas = 104857600 bytes
            if(isset($_FILES["archivo"]["name"]) && $_FILES["archivo"]["size"] > 104857600){
                echo Utilidades::getAlertaErrorJSON("simple", "El tamaño del archivo excede el limite permitido (100MB)");
                exit();
            }

            $agregar_recurso = recursoModelo::agregar_recurso_modelo($recurso);

            if(is_string($agregar_recurso) || $agregar_recurso < 0){
                echo Utilidades::getAlertaErrorJSON("simple", "Ups! Hubo un problema al cargar el recurso. Por favor intente nuevamente.");
                exit();
            }

            self::crearArchivo($recurso);

            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Recurso creado correctamente", SERVER_URL."docente-mis-recursos/");
        }

    }

    public function editar_docente_recurso_controlador(){
        $recurso = new Recurso();

        if(!isset($_POST['cursos_docente_edit'])){
            echo Utilidades::getAlertaErrorJSON("simple", "Por favor seleccione un curso");
            exit();
        }

        $recurso->setIdRecurso(mainModel::limpiarCadena(mainModel::decryption($_POST['id_docente_recurso_edit'])));

        //Comprobar que el recurso existe
        $checkRecurso = mainModel::ejecutar_consulta_simple("SELECT * FROM recurso WHERE id = '". $recurso->getIdRecurso() ."';");
        if($checkRecurso->rowCount() <= 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se encontró el recurso a editar");
            exit();
        }

        //Construimos el objeto de recurso con información actual o nueva
        $recurso->setTitulo(mainModel::limpiarCadena($_POST['titulo_docente_edit']));
        $recurso->setResumen(mainModel::limpiarCadena($_POST['resumen_docente_edit']));

        if($_POST['anioRecurso_docente_edit']!=""){
            $recurso->setFecha(mainModel::limpiarCadena($_POST['anioRecurso_docente_edit']));
        }else{
            $recurso->setFecha("s.f");
        }

        $recurso->setEstado(mainModel::limpiarCadena($_POST['estado_docente_edit']));
        $recurso->setCurso($_POST['cursos_docente_edit']);
        $recurso->setEnlace(mainModel::limpiarCadena($_POST['link_docente_edit']));
        $recurso->setAutor(array());
        $recurso->setEtiqueta(array());

        if(isset($_POST['editorial_docente_edit'])){
            $recurso->setEditorial(mainModel::limpiarCadena($_POST['editorial_docente_edit']));
        }

        if(isset($_POST['ISBN_docente_edit'])){
            $recurso->setISBN(mainModel::limpiarCadena($_POST['ISBN_docente_edit']));
        }

        if(isset($_POST['etiquetas_docente_edit']))
            $recurso->setEtiqueta($_POST['etiquetas_docente_edit']);
        
        if(isset($_POST['autores_docente_edit']))
            $recurso->setAutor($_POST['autores_docente_edit']);

        if(isset($_POST['link_docente_edit'])){
            $recurso->setEnlace(mainModel::limpiarCadena($_POST['link_docente_edit']));

            if(isset($_POST['link_docente_edit'])){
                $recurso->setEnlace(mainModel::limpiarCadena($_POST['link_docente_edit']));
                if($recurso->getEnlace() != "" && !mainModel::verificarDatos('(http(s)?:\/\/)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,}(\.[a-zA-Z]{2,})?(\/[a-zA-Z0-9\-\._\?\,\'\/\\\+&%\$#\=~]*)?', $recurso->getEnlace())){
                    echo Utilidades::getAlertaErrorJSON("simple", "El enlace ingresado no es válido");
                    exit();
                }
            }
        }

        //Obtener las etiquetas seleccionadas (Agregar nuevas y Eliminar no seleccionadas)
        $etiquetasActuales = recursoModelo::idEtiquetasRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $etiquetasAgregadas = array_diff($recurso->getEtiqueta(), $etiquetasActuales);
        $etiquetasEliminadas = array_diff($etiquetasActuales, $recurso->getEtiqueta());

        recursoModelo::editar_recurso_etiqueta_modelo($recurso, $etiquetasAgregadas, $etiquetasEliminadas);

        //Obtener los autores seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $autoresActuales = recursoModelo::idAutoresRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $autoresAgregados = array_diff($recurso->getAutor(), $autoresActuales);
        $autoresEliminados = array_diff($autoresActuales, $recurso->getAutor());

        recursoModelo::editar_recurso_autor_modelo($recurso, $autoresAgregados, $autoresEliminados);

        //Obtener los cursos seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $cursosActuales = recursoModelo::idCursosRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $cursosAgregados = array_diff($recurso->getCurso(), $cursosActuales);
        $cursosEliminados = array_diff($cursosActuales, $recurso->getCurso());
        $editarRecurso = recursoModelo::editar_recurso_modelo($recurso, $cursosAgregados, $cursosEliminados);

        //Editamos o creamos la información del archivo
        self::editarArchivoRecurso($recurso);

        if(is_string($editarRecurso) || $editarRecurso->rowCount() < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo actualizar la información");
        }else{
            echo Utilidades::getAlertaExitosoJSON("redireccionar", "Los datos han sido actualizados con éxito", SERVER_URL."docente-mis-recursos/");
        }
    }

    /**
     * Retorna la lista de recursos marcados como favoritos por una persona
     *
     * @return Object Lista de recursos
     */
    public function obtenerListaFavoritosXPersona($idPersona){
        $consulta = "SELECT r.id as id_recurso, r.titulo, a.nombre, pDoc.nombre as nombre_docente, pDoc.apellido as apellido_docente
        FROM recurso r
        LEFT JOIN archivo a ON a.id_recurso = r.id
        JOIN recurso_favorito rf ON rf.id_recurso = r.id
        JOIN persona p ON p.id = rf.id_persona
        JOIN persona pDoc ON pDoc.id = r.id_docente
        WHERE r.estado != " . Utilidades::getIdEstado("ELIMINADO") . " ";

        if($idPersona != null)
            $consulta .= " AND p.id = " . $idPersona;

        $consulta .= " ORDER BY r.id;";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

    /**
     * Retorna la lista de recursos calificados por una persona
     *
     * @return Object Lista de recursos
     */
    public function obtenerListaCalificadosXPersona($idPersona){
        $consulta = "SELECT r.id as id_recurso, r.titulo, a.nombre, pr.tipo_voto
        FROM recurso r
        LEFT JOIN archivo a ON a.id_recurso = r.id
        JOIN puntuacion_recurso pr ON pr.id_recurso = r.id
        JOIN persona p ON p.id = pr.id_estudiante
        WHERE r.estado != " . Utilidades::getIdEstado("ELIMINADO") . " ";

        if($idPersona != null)
            $consulta .= " AND p.id = " . $idPersona;

        $consulta .= " ORDER BY r.id;";

        $conexion = mainModel::conectar();

        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        return $datos;
    }

    public function eliminarRecursoFavoritoControlador(){
        $idRecurso = mainModel::limpiarCadena(mainModel::decryption($_POST['id_recurso_favorito_del']));
        session_start(['name'=>"REPO"]);
        $idPersona = $_SESSION['id_persona'];

        $eliminarRecurso = recursoModelo::eliminarRecursoFavoritoModelo($idPersona, $idRecurso);

        if(is_string($eliminarRecurso) || $eliminarRecurso < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar el recurso favorito");
            exit();
        }

        echo Utilidades::getAlertaExitosoJSON("recargar", "Recurso favorito eliminado exitosamente");
    }

    public function eliminarCalificacionRecursoControlador(){
        $idRecurso = mainModel::limpiarCadena(mainModel::decryption($_POST['id_calificacion_recurso_del']));
        session_start(['name'=>"REPO"]);
        $idPersona = $_SESSION['id_persona'];

        $eliminarRecurso = recursoModelo::eliminarCalificacionRecursoModelo($idPersona, $idRecurso);

        if(is_string($eliminarRecurso) || $eliminarRecurso < 0){
            echo Utilidades::getAlertaErrorJSON("simple", "No se pudo eliminar la calificación del recurso");
            exit();
        }

        echo Utilidades::getAlertaExitosoJSON("recargar", "Calificación eliminada exitosamente");
    }

    /**
     * Guarda la información del archivo en la base de datos. Si falla este proceso se muestra una alerta de error
     * y se detienen los procesos del controlador (exit)
     * 
     * @param Recurso recurso Objeto con información del recurso necesaria para relacionar la tabla archivo
     */
    public function crearArchivo(Recurso $recurso){
        if(isset($_FILES["archivo"]["name"])){
            $rutaCarpeta = "recursos/".$_SESSION['documento_usuario'];
            $rutaCarpetaGuardado = "../recursos/".$_SESSION['documento_usuario']; 
            //Si la carpeta del usuario no existe, se crea
            if(!file_exists($rutaCarpetaGuardado)){
                mkdir($rutaCarpetaGuardado, 0777, true);
            }
            //El archivo se crea fechaactual_nombrearchivo.extension
            $nombreArchivo = date('dmYHis')."_".$_FILES["archivo"]["name"];
            $rutaGuardado = $rutaCarpetaGuardado."/".$nombreArchivo; //Ruta donde se almacena físicamente el archivo
            $ruta = $rutaCarpeta."/".$nombreArchivo; //Ruta que se almacena en la base de datos
            move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaGuardado);
        }else{
            $ruta = "null";
        }

        if($ruta != "null"){
            $archivo = new Archivo();

            $archivo->setRuta($ruta);
            $archivo->setTamano($_FILES["archivo"]["size"]);
            $archivo->setNombre($_FILES["archivo"]["name"]);

            $archivo->setEstado(Utilidades::getIdEstado("ACTIVO"));

            $recurso->setArchivo($archivo);

            $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM recurso WHERE titulo = '". $recurso->getTitulo() ."'");
            $sqlQuery->execute();

            $codrecurso = $sqlQuery->fetch();
            $recurso->setIdRecurso($codrecurso['id']);

            $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

            if(is_string($agregar_archivo)){
                echo Utilidades::getAlertaErrorJSON("simple", "Ups! Hubo un problema al cargar el archivo. Por favor intente nuevamente.");
                exit();
            }
        }
    }

    /**
     * Edita la información del archivo de un recurso. Si el recurso tiene un archivo previamene cargado se edita la información. Si no,
     * se crea un nuevo registro y se relaciona con la información enviada por parámetro del recurso.
     * Si se presenta algún fallo en el proceso se detienen las demás funcionalidades del controlador (exit)
     * 
     * @param Recurso recurso Objeto con información necesaria para relacionar el registro de archivo
     */
    public function editarArchivoRecurso(Recurso $recurso){
        //Revisamos si se subió un archivo a editar
        if(isset($_FILES["archivo"]["name"])){
            session_start(['name'=>"REPO"]);
            $rutaCarpeta = "recursos/".$_SESSION['documento_usuario'];
            $rutaCarpetaGuardado = "../recursos/".$_SESSION['documento_usuario']; 
            //Si la carpeta del usuario no existe, se crea
            if(!file_exists($rutaCarpetaGuardado)){
                mkdir($rutaCarpetaGuardado, 0777, true);
            }
            //El archivo se crea fechaactual_nombrearchivo.extension
            $nombreArchivo = date('dmYHis')."_".$_FILES["archivo"]["name"];
            $rutaGuardado = $rutaCarpetaGuardado."/".$nombreArchivo; //Ruta donde se almacena físicamente el archivo
            $ruta = $rutaCarpeta."/".$nombreArchivo; //Ruta que se almacena en la base de datos
            move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaGuardado);
        }else{
            $ruta = "null";
        }

        //Si viene archivo revisamos si el recurso ya tenía archivo o se va a crear
        if($ruta != "null"){
            //Comprobamos si el recurso tiene archivo o no
            $datosArchivo = mainModel::ejecutar_consulta_simple("SELECT a.id as idRecurso, a.ruta FROM archivo a JOIN recurso r ON r.id = a.id_recurso WHERE r.id = '". $recurso->getIdRecurso() ."';");

            //Cargamos la información del formulario
            $archivo = new Archivo();
            $archivo->setRuta($ruta);
            $archivo->setTamano($_FILES["archivo"]["size"]);
            $archivo->setNombre($_FILES["archivo"]["name"]);

            $archivo->setEstado($recurso->getEstado());

            $recurso->setArchivo($archivo);

            //Si NO tiene archivo
            if($datosArchivo->rowCount() <= 0){
                //Creamos el registro

                $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

                if(is_string($agregar_archivo)){
                    echo Utilidades::getAlertaErrorJSON("simple", "Ups! Hubo un problema al crear el archivo. Por favor intente nuevamente.");
                    exit();
                }
            }else{ //Si tiene archivo
                //Editamos la información del archivo
                $archivoAntiguo = new Archivo();

                $fetchArchivo = $datosArchivo->fetch();
                $archivoAntiguo->setIdArchivo($fetchArchivo['idRecurso']);

                $agregar_archivo = recursoModelo::editar_archivo_modelo($recurso, $archivoAntiguo);

                if(is_string($agregar_archivo)){
                    echo Utilidades::getAlertaErrorJSON("simple", "Ups! Hubo un problema al editar el archivo. Por favor intente nuevamente.");
                    exit();
                }
            }
        }
    }

    /**
     * Obtiene las calificaciones (puntos positivos y negativos) totales que tiene un publicador en sus recursos y las imprime en pantalla
     * para ser recibidas por medio de AJAX
     * 
     * @return void
     */
    public function calificacionesTotalesXPublicador(){
        session_start(['name'=>"REPO"]);
        $consulta = mainModel::ejecutar_consulta_simple("SELECT SUM(r.puntos_positivos) total_positivos, SUM(r.puntos_negativos) total_negativos
                                                        FROM recurso r
                                                        WHERE r.id_docente = " . $_SESSION['id_persona']);

        $consulta = $consulta->fetch();
        $puntosPositivosTotales = $consulta['total_positivos'];
        $puntosNegativosTotales = $consulta['total_negativos'];

        $puntuacionTotal = array($puntosPositivosTotales, $puntosNegativosTotales);
        echo json_encode($puntuacionTotal);
    }

}

?>