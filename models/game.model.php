<?php

require_once 'conexion.php';

class ModelGame
{
    public static function getAllGames()
    {
        try {
            $statement = Conexion::connect()->prepare("SELECT * FROM informacion_juegos WHERE borrado = 0 ORDER BY id DESC LIMIT 12");
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }
    }

    public static function game($id)
    {
        try {
            $statement = Conexion::connect()->prepare("SELECT * FROM informacion_juegos WHERE id = '" . $id . "'");
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }
    }

    public static function req($id, $tipo){

        try{
            $statement = Conexion::connect()->prepare("SELECT * FROM requisitos WHERE id_informacion_juegos = '" . $id . "' AND tipo = '" . $tipo . "'");
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS);
        }catch(PDOException $e){
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }
    }

    public static function imgGame($id){

        try{
            $statement = Conexion::connect()->prepare("SELECT * FROM img_juego WHERE id_juego = '" . $id . "'");
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS);
        }catch(PDOException $e){
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }
    }

    public static function descargas($id){

        try{
            $statement = Conexion::connect()->prepare("SELECT * FROM descargas WHERE id_juego = '" . $id . "'");
            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_CLASS);
        }catch(PDOException $e){
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }
    }
//funciones para subir un juego
    public static function uploadInfoGames($url, $nombre, $servidor, $link, $desc, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, $obs)
    {
        try{
            $statement = Conexion::connect()->prepare("INSERT INTO informacion_juegos (url, nombre, descripcion, genero, plataforma, distribuidor, desarrollador, lanzamiento, imagen, observaciones, nivel) 
            VALUES (:url, :nombre, :desc, :genero, :plataforma, :distribuidor, :desarrollador, :lanzamiento, :img, :obs, :nivel)");
            
            $statement->execute([':url' => $url, ':nombre' => $nombre, ':desc' => $desc, ':genero' => $genero, ':plataforma' => $plataforma, ':distribuidor' => $distribuidor, ':desarrollador' => $desarrollador, ':lanzamiento' => $lanzamiento, ':img' => $img, ':obs' => $obs, ':nivel' => $nivel]);
            //si se guarda otro juego con el mismo nombre coloca los requisitos y las imagenes con la id del primer juego
            $idJuego = Conexion::connect()->query("SELECT id FROM informacion_juegos WHERE nombre = '$nombre'");
            $row = $idJuego->fetch();
            
            foreach($imagenes as $i){
                self::subirImagen($row['id'], $i);
            }

            for($i = 0; $i < count($link); $i++){
                self::subirDescarga($row['id'], $servidor[$i], $link[$i]);
            }
            
            self::subirReq($row['id'], $reqMin, '1');
            self::subirReq($row['id'], $reqRec, '2');

            $json = array(
                "status"  => 200,
                "DETAILS" => 'JUEGO SUBIDO'
            );

            return $json;

        }catch(PDOException $e){
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }
    }

    public static function subirReq($id, $req, $tipo)
    {
        try {
            $statement = Conexion::connect()->prepare("INSERT INTO requisitos (so, procesador, memoria, graficos, libreria, red, almacenamiento, tipo, id_informacion_juegos) VALUES (:so, :procesador, :memoria, :graficos, :libreria, :red, :almacenamiento, :tipo, :idInfoJuego)");
            $statement->execute([':so' => $req[0], ':procesador' => $req[1], ':memoria' => $req[2], ':graficos' => $req[3], ':libreria' => $req[4], ':red' => $req[5], ':almacenamiento' => $req[6], ':tipo' => $tipo, ':idInfoJuego' => $id]);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function subirImagen($id, $img){
        try {
            $statement = Conexion::connect()->prepare("INSERT INTO img_juego (id_juego, img) VALUES (:id_juego, :img)");
            $statement->execute([':id_juego' => $id, ':img' => $img]);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function subirDescarga($id, $servidor, $desc){
        try {
            $statement = Conexion::connect()->prepare("INSERT INTO descargas (servidor, link, id_juego) VALUES (:servidor, :link, :id_juego)");
            $statement->execute([':servidor' => $servidor, ':link' => $desc, ':id_juego' => $id]);
        } catch (PDOException $e) {
            return [];
        }
    }
    //funciones para actualizar un juego
    public static function updateInfoGames($id, $url, $nombre, $servidor, $link, $desc, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, $obs)
    {
        try{
            $statement = Conexion::connect()->prepare("UPDATE informacion_juegos SET url = '$url', nombre = '$nombre', descripcion = '$desc', genero = '$genero', plataforma = '$plataforma', distribuidor = '$distribuidor', desarrollador = '$desarrollador', lanzamiento = '$lanzamiento', imagen = '$img', observaciones = '$obs', nivel = '$nivel' WHERE id = '" . $id . "'");
            $statement->execute();

            $statement = Conexion::connect()->prepare("DELETE FROM img_juego WHERE id_juego = '" . $id . "'");
            $statement->execute();

            foreach($imagenes as $i){
                self::actualizarImagen($id, $i);
            }

            $statement = Conexion::connect()->prepare("DELETE FROM descargas WHERE id_juego = '" . $id . "'");
            $statement->execute();

            for($i = 0; $i < count($link); $i++){
                self::actualizarDescarga($id, $servidor[$i], $link[$i]);
            }

            $statement = Conexion::connect()->query("SELECT * FROM requisitos WHERE id_informacion_juegos = '" . $id . "'");
            $statement->execute();
            while ($row = $statement->fetch()) {
                if($row['tipo'] === 1){
                    self::actualizarReq($row['id'], $reqMin);
                }else{
                    self::actualizarReq($row['id'], $reqRec);
                }
            }

            $json = array(
                "status"  => 200,
                "DETAILS" => 'JUEGO ACTUALIZADO'
            );

            return $json;
            
        }catch(PDOException $e){
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }   
    }

    public static function actualizarImagen($id, $img){
        try {
            $statement = Conexion::connect()->prepare("INSERT INTO img_juego (id_juego, img) VALUES (:id_juego, :img)");
            $statement->execute([':id_juego' => $id, ':img' => $img]);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function actualizarReq($id, $req)
    {
        try {
            $statement = Conexion::connect()->prepare("UPDATE requisitos SET so = '$req[0]', procesador = '$req[1]', memoria = '$req[2]', graficos = '$req[3]', libreria = '$req[4]', red = '$req[5]', almacenamiento = '$req[6]' WHERE id = '" . $id . "'");
            $statement->execute();
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function actualizarDescarga($id, $servidor, $desc){
        try {
            $statement = Conexion::connect()->prepare("INSERT INTO descargas (servidor, link, id_juego) VALUES (:servidor, :link, :id_juego)");
            $statement->execute([':servidor' => $servidor, ':link' => $desc, ':id_juego' => $id]);
        } catch (PDOException $e) {
            return [];
        }
    }
    //funciones de borrado
    public static function delete($id){
        try{
            $statement = Conexion::connect()->prepare("UPDATE descargas SET borrado = 1, fecha_borrado = NOW() WHERE id_juego = '$id'");
            $statement->execute();
            $statement = Conexion::connect()->prepare("UPDATE requisitos SET borrado = 1, fecha_borrado = NOW() WHERE id_informacion_juegos = '$id'");
            $statement->execute();
            $statement = Conexion::connect()->prepare("UPDATE img_juego SET borrado = 1, fecha_borrado = NOW() WHERE id_juego = '$id'");
            $statement->execute();
            $statement = Conexion::connect()->prepare("UPDATE informacion_juegos SET borrado = 1, fecha_borrado = NOW() WHERE id = '$id'");
            $statement->execute();

            $json = array(
                "status"  => 200,
                "DETAILS" => 'JUEGO EN PAPELERA'
            );

            return $json;
        } catch (PDOException $e) {
            $json = array(
                "status"  => 404,
                "DETAILS" => $e->getMessage()
            );
            return $json;
        }
    }
}