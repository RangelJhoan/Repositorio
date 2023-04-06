<?php

require_once "mainModel.php";
if($peticionAjax){
    //Modelo llamado desde el archivo Ajax
    require_once "../entidades/Etiqueta.php";
}else{
    //Modelo llamado desde la vista Index
    require_once "./entidades/Etiqueta.php";
}

class etiquetaModelo extends mainModel{

    protected static function agregar_etiqueta_modelo(Etiqueta $etiqueta){
        try {
            $sql = mainModel::conectar()->prepare("INSERT INTO etiqueta(descripcion, estado, id_docente) VALUES(?, ?, ?);");
            $sql->execute([$etiqueta->getDescripcion(), $etiqueta->getEstado(), $etiqueta->getIdDocente()]);

            return $sql->rowCount();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /*---------- Modelo para editar información de etiqueta ----------*/
    protected static function editar_etiqueta_modelo(Etiqueta $etiqueta){
        try {
            $sql = mainModel::conectar()->prepare("UPDATE etiqueta SET descripcion=?, estado=? WHERE id=?");
            $sql->execute([$etiqueta->getDescripcion(), $etiqueta->getEstado(), $etiqueta->getIdEtiqueta()]);

            return $sql->rowCount();
        } catch (Exception $e) {
            return "Error " . $e->getMessage();
        }
    }

    /*---------- Modelo para eliminar etiqueta ----------*/
    protected static function eliminar_etiqueta_modelo(Etiqueta $etiqueta){
        try {
            $sql = mainModel::conectar()->prepare("UPDATE etiqueta SET estado=? WHERE id=?");
            $sql->execute([$etiqueta->getEstado(), $etiqueta->getIdEtiqueta()]);
            return $sql->rowCount();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /*---------- Modelo datos etiqueta ----------*/
    protected static function datos_etiqueta_modelo($tipo, $id){
        if($tipo == "Unico"){
            $sql = mainModel::conectar()->prepare("SELECT * 
            FROM etiqueta 
            WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") ." AND id = :ID;");
            $sql->bindParam(":ID", $id);
        }elseif($tipo == "Conteo"){
            $sql = mainModel::conectar()->prepare("SELECT id 
            FROM etiqueta
            WHERE estado != ". Utilidades::getIdEstado("ELIMINADO") .";");
        }
        $sql->execute();
        return $sql;
    }

    /*---------- Modelo etiquetas por recurso ----------*/
    protected static function etiquetasXRecursoModelo($id){
        $sql = mainModel::conectar()->prepare("SELECT e.id, e.descripcion 
        FROM etiqueta e 
        JOIN etiqueta_recurso er ON e.id = er.id_etiqueta 
        JOIN recurso r ON r.id = er.id_recurso 
        WHERE e.estado != ". Utilidades::getIdEstado("ELIMINADO"). " and r.id = :ID;");
        $sql->bindParam(":ID", $id);
        $sql->execute();
        return $sql;
    }
}

?>