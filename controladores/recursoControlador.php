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
        $recurso->setTitulo($_POST['titulo_ins']);
        $recurso->setResumen($_POST['resumen_ins']);
        $recurso->setEstado(Utilidades::getIdEstado("ACTIVO"));
        $recurso->setEtiqueta(array());
        $recurso->setAutor(array());

        if(isset($_POST['autores_ins']))
            $recurso->setAutor($_POST['autores_ins']);

        if(!isset($_POST['cursos_ins'])){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor seleccione un curso",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $recurso->setCurso($_POST['cursos_ins']);

        if(isset($_POST['etiquetas_ins']))
            $recurso->setEtiqueta($_POST['etiquetas_ins']);

        if(isset($_POST['link_ins']))
            $recurso->setEnlace($_POST['link_ins']);

        if($_POST['anioRecurso']!=""){
            $recurso->setFecha($_POST['anioRecurso']);
        }else{
            $recurso->setFecha("s.f");
        }

        if($recurso->getTitulo() == "" || $recurso->getResumen() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            if(!isset($_FILES["archivo"]["name"]) && $recurso->getEnlace() == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Por favor ingrese un enlace o seleccione un archivo",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            //El tamaño máximo permitido para almacenar un archivo son 100 megas = 104857600 bytes
            if(isset($_FILES["archivo"]["name"]) && $_FILES["archivo"]["size"] > 104857600){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"El tamaño del archivo excede el limite permitido (100MB)",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $agregar_recurso = recursoModelo::agregar_recurso_modelo($recurso);

            if(is_string($agregar_recurso) || $agregar_recurso < 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Ups! Ups! Hubo un problema al cargar el recurso. Por favor intente nuevamente.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

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

                if(isset($_POST['editorial_ins'])){
                    $archivo->setEditorial($_POST['editorial_ins']);
                }

                if(isset($_POST['ISBN_ins'])){
                    $archivo->setISBN($_POST['ISBN_ins']);
                }

                $archivo->setEstado(Utilidades::getIdEstado("ACTIVO"));

                $recurso->setArchivo($archivo);

                $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM recurso WHERE titulo = '". $recurso->getTitulo() ."'");
                $sqlQuery->execute();

                $codrecurso = $sqlQuery->fetch();
                $recurso->setIdRecurso($codrecurso['id']);

                $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Ups! Hubo un problema al cargar el archivo. Por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Exitoso",
                "URL"=>SERVER_URL."adminRecursos/",
                "Texto"=>"Recurso creado correctamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
        }

    }

    /**
     * Paginador de recursos, vista en panel de Admin
     *
     * @return Object Lista de los recursos consultados
     */
    public function paginador_recurso_controlador($idPersona){
        $consulta = "SELECT r.id as idRecurso, r.titulo, r.puntos_positivos, r.puntos_negativos, r.estado, r.fecha_publicacion_profesor, p.nombre, p.apellido 
        FROM recurso r 
        JOIN persona p ON p.id = r.id_docente 
        WHERE r.estado != " . Utilidades::getIdEstado("ELIMINADO") . " ";

        if($idPersona != null)
            $consulta .= " AND p.id = " . $idPersona;

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
        $recurso->setIdRecurso(mainModel::decryption($_POST['id_recurso_del']));
        $recurso->setEstado(Utilidades::getIdEstado("ELIMINADO"));

        $eliminarRecurso = recursoModelo::editar_estado_recurso_modelo($recurso);

        if(is_string($eliminarRecurso) || $eliminarRecurso < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo eliminar el recurso",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $alerta=[
            "Alerta"=>"recargar",
            "Titulo"=>"Exitoso",
            "Texto"=>"Recurso eliminado exitosamente",
            "Tipo"=>"success"
        ];
        echo json_encode($alerta);

    }

    public function editar_recurso_controlador(){
        $recurso = new Recurso();

        if(!isset($_POST['cursos_edit'])){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor seleccione un curso",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $recurso->setIdRecurso(mainModel::decryption($_POST['id_recurso_edit']));

        //Comprobar que el recurso existe
        $checkRecurso = mainModel::ejecutar_consulta_simple("SELECT * FROM recurso WHERE id = '". $recurso->getIdRecurso() ."';");
        if($checkRecurso->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el recurso a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        //Construimos el objeto de recurso con información actual o nueva
        $recurso->setTitulo($_POST['titulo_edit']);
        $recurso->setResumen($_POST['resumen_edit']);

        if($_POST['anioRecurso_edit']!=""){
            $recurso->setFecha($_POST['anioRecurso_edit']);
        }else{
            $recurso->setFecha("s.f");
        }

        $recurso->setEstado($_POST['estado_edit']);
        $recurso->setCurso($_POST['cursos_edit']);
        $recurso->setEnlace($_POST['link_edit']);
        $recurso->setAutor(array());
        $recurso->setEtiqueta(array());

        if(isset($_POST['etiquetas_edit']))
            $recurso->setEtiqueta($_POST['etiquetas_edit']);

        //Obtener las etiquetas seleccionadas (Agregar nuevas y Eliminar no seleccionadas)
        $etiquetasActuales = recursoModelo::idEtiquetasRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $etiquetasAgregadas = array_diff($recurso->getEtiqueta(), $etiquetasActuales);
        $etiquetasEliminadas = array_diff($etiquetasActuales, $recurso->getEtiqueta());

        recursoModelo::editar_recurso_etiqueta_modelo($recurso, $etiquetasAgregadas, $etiquetasEliminadas);

        if(isset($_POST['autores_edit']))
            $recurso->setAutor($_POST['autores_edit']);

        //Obtener los autores seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $autoresActuales = recursoModelo::idAutoresRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $autoresAgregados = array_diff($recurso->getAutor(), $autoresActuales);
        $autoresEliminados = array_diff($autoresActuales, $recurso->getAutor());

        recursoModelo::editar_recurso_autor_modelo($recurso, $autoresAgregados, $autoresEliminados);

        if(isset($_POST['link_ins']))
            $recurso->setEnlace($_POST['link_ins']);

        //Obtener los cursos seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $cursosActuales = recursoModelo::idCursosRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $cursosAgregados = array_diff($recurso->getCurso(), $cursosActuales);
        $cursosEliminados = array_diff($cursosActuales, $recurso->getCurso());
        $editarRecurso = recursoModelo::editar_recurso_modelo($recurso, $cursosAgregados, $cursosEliminados);

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

            if(isset($_POST['editorial_edit'])){
                $archivo->setEditorial($_POST['editorial_edit']);
            }

            if(isset($_POST['ISBN_edit'])){
                $archivo->setISBN($_POST['ISBN_edit']);
            }

            $archivo->setEstado($recurso->getEstado());

            $recurso->setArchivo($archivo);

            //Si NO tiene archivo
            if($datosArchivo->rowCount() <= 0){
                //Creamos el registro

                $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Ups! Hubo un problema al crear el archivo. Por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }else{ //Si tiene archivo
                //Editamos la información del archivo
                $archivoAntiguo = new Archivo();

                $fetchArchivo = $datosArchivo->fetch();
                $archivoAntiguo->setIdArchivo($fetchArchivo['idRecurso']);

                $agregar_archivo = recursoModelo::editar_archivo_modelo($recurso, $archivoAntiguo);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Ups! Hubo un problema al editar el archivo. Por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
        }

        if(is_string($editarRecurso) || $editarRecurso->rowCount() < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo actualizar la información",
                "Tipo"=>"error"
            ];
        }else{
            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Datos actualizados",
                "URL"=>SERVER_URL."adminRecursos/",
                "Texto"=>"Los datos han sido actualizados con éxito",
                "Tipo"=>"success"
            ];
        }
        echo json_encode($alerta);
    }

    /*---------- Controlador para agregar recurso desde el perfil de docente ----------*/
    public function agregar_docente_recurso_controlador(){
        $recurso = new Recurso();
        $recurso->setTitulo($_POST['titulo_docente_ins']);
        $recurso->setResumen($_POST['resumen_docente_ins']);
        $recurso->setEstado(Utilidades::getIdEstado("ACTIVO"));
        $recurso->setEtiqueta(array());
        $recurso->setAutor(array());

        if(isset($_POST['autores_docente_ins']))
            $recurso->setAutor($_POST['autores_docente_ins']);

        if(!isset($_POST['cursos_docente_ins'])){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor seleccione un curso",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $recurso->setCurso($_POST['cursos_docente_ins']);

        if(isset($_POST['etiquetas_docente_ins']))
            $recurso->setEtiqueta($_POST['etiquetas_docente_ins']);

        if(isset($_POST['link_docente_ins']))
            $recurso->setEnlace($_POST['link_docente_ins']);

        if($_POST['anioRecurso_docente']!=""){
            $recurso->setFecha($_POST['anioRecurso_docente']);
        }else{
            $recurso->setFecha("s.f");
        }

        if($recurso->getTitulo() == "" || $recurso->getResumen() == ""){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor llene todos los campos requeridos",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }else{
            if(!isset($_FILES["archivo"]["name"]) && $recurso->getEnlace() == ""){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Por favor ingrese un enlace o seleccione un archivo",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            //El tamaño máximo permitido para almacenar un archivo son 100 megas = 104857600 bytes
            if(isset($_FILES["archivo"]["name"]) && $_FILES["archivo"]["size"] > 104857600){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"El tamaño del archivo excede el limite permitido (100MB)",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

            $agregar_recurso = recursoModelo::agregar_recurso_modelo($recurso);

            if(is_string($agregar_recurso) || $agregar_recurso < 0){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Error",
                    "Texto"=>"Ups! Ups! Hubo un problema al cargar el recurso. Por favor intente nuevamente.",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }

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

                if(isset($_POST['editorial_docente_ins'])){
                    $archivo->setEditorial($_POST['editorial_docente_ins']);
                }

                if(isset($_POST['ISBN_docente_ins'])){
                    $archivo->setISBN($_POST['ISBN_docente_ins']);
                }

                $archivo->setEstado(Utilidades::getIdEstado("ACTIVO"));

                $recurso->setArchivo($archivo);

                $sqlQuery = mainModel::conectar()->prepare("SELECT id FROM recurso WHERE titulo = '". $recurso->getTitulo() ."'");
                $sqlQuery->execute();

                $codrecurso = $sqlQuery->fetch();
                $recurso->setIdRecurso($codrecurso['id']);

                $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Ups! Hubo un problema al cargar el archivo. Por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }

            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Exitoso",
                "URL"=>SERVER_URL."docenteMisRecursos/",
                "Texto"=>"Recurso creado correctamente",
                "Tipo"=>"success"
            ];
            echo json_encode($alerta);
        }

    }

    public function editar_docente_recurso_controlador(){
        $recurso = new Recurso();

        if(!isset($_POST['cursos_docente_edit'])){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"Por favor seleccione un curso",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $recurso->setIdRecurso(mainModel::decryption($_POST['id_docente_recurso_edit']));

        //Comprobar que el recurso existe
        $checkRecurso = mainModel::ejecutar_consulta_simple("SELECT * FROM recurso WHERE id = '". $recurso->getIdRecurso() ."';");
        if($checkRecurso->rowCount() <= 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error",
                "Texto"=>"No se encontró el recurso a editar",
                "Tipo"=>"error"
            ];
            echo json_encode($alerta);
            exit();
        }

        //Construimos el objeto de recurso con información actual o nueva
        $recurso->setTitulo($_POST['titulo_docente_edit']);
        $recurso->setResumen($_POST['resumen_docente_edit']);

        if($_POST['anioRecurso_docente_edit']!=""){
            $recurso->setFecha($_POST['anioRecurso_docente_edit']);
        }else{
            $recurso->setFecha("s.f");
        }

        $recurso->setEstado($_POST['estado_docente_edit']);
        $recurso->setCurso($_POST['cursos_docente_edit']);
        $recurso->setEnlace($_POST['link_docente_edit']);
        $recurso->setAutor(array());
        $recurso->setEtiqueta(array());

        if(isset($_POST['etiquetas_docente_edit']))
            $recurso->setEtiqueta($_POST['etiquetas_docente_edit']);

        //Obtener las etiquetas seleccionadas (Agregar nuevas y Eliminar no seleccionadas)
        $etiquetasActuales = recursoModelo::idEtiquetasRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $etiquetasAgregadas = array_diff($recurso->getEtiqueta(), $etiquetasActuales);
        $etiquetasEliminadas = array_diff($etiquetasActuales, $recurso->getEtiqueta());

        recursoModelo::editar_recurso_etiqueta_modelo($recurso, $etiquetasAgregadas, $etiquetasEliminadas);

        if(isset($_POST['autores_docente_edit']))
            $recurso->setAutor($_POST['autores_docente_edit']);

        //Obtener los autores seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $autoresActuales = recursoModelo::idAutoresRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $autoresAgregados = array_diff($recurso->getAutor(), $autoresActuales);
        $autoresEliminados = array_diff($autoresActuales, $recurso->getAutor());

        recursoModelo::editar_recurso_autor_modelo($recurso, $autoresAgregados, $autoresEliminados);

        if(isset($_POST['link_docente_ins']))
            $recurso->setEnlace($_POST['link_docente_ins']);

        //Obtener los cursos seleccionados (Agregar nuevos y Eliminar no seleccionados)
        $cursosActuales = recursoModelo::idCursosRecurso($recurso->getIdRecurso())->fetchAll(PDO::FETCH_COLUMN, 0);
        $cursosAgregados = array_diff($recurso->getCurso(), $cursosActuales);
        $cursosEliminados = array_diff($cursosActuales, $recurso->getCurso());
        $editarRecurso = recursoModelo::editar_recurso_modelo($recurso, $cursosAgregados, $cursosEliminados);

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

            if(isset($_POST['editorial_docente_edit'])){
                $archivo->setEditorial($_POST['editorial_docente_edit']);
            }

            if(isset($_POST['ISBN_docente_edit'])){
                $archivo->setISBN($_POST['ISBN_docente_edit']);
            }

            $archivo->setEstado($recurso->getEstado());

            $recurso->setArchivo($archivo);

            //Si NO tiene archivo
            if($datosArchivo->rowCount() <= 0){
                //Creamos el registro

                $agregar_archivo = recursoModelo::agregar_archivo_modelo($recurso);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Ups! Hubo un problema al crear el archivo. Por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }else{ //Si tiene archivo
                //Editamos la información del archivo
                $archivoAntiguo = new Archivo();

                $fetchArchivo = $datosArchivo->fetch();
                $archivoAntiguo->setIdArchivo($fetchArchivo['idRecurso']);

                $agregar_archivo = recursoModelo::editar_archivo_modelo($recurso, $archivoAntiguo);

                if(is_string($agregar_archivo)){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Error",
                        "Texto"=>"Ups! Hubo un problema al editar el archivo. Por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alerta);
                    exit();
                }
            }
        }

        if(is_string($editarRecurso) || $editarRecurso->rowCount() < 0){
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Error",
                "Texto"=>"No se pudo actualizar la información",
                "Tipo"=>"error"
            ];
        }else{
            $alerta=[
                "Alerta"=>"redireccionar",
                "Titulo"=>"Datos actualizados",
                "URL"=>SERVER_URL."docenteMisRecursos/",
                "Texto"=>"Los datos han sido actualizados con éxito",
                "Tipo"=>"success"
            ];
        }
        echo json_encode($alerta);
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

}

?>