<?php

class ControladorGame {
    /****************************************************************
    * CREANDO UN REGISTRO NUEVO
    ********************************************************************/

    public function games() {

        echo json_encode(ModelGame::getAllGames(), true);

        return;
    }

    public function juego($id){
        echo json_encode(ModelGame::game($id), true);
        echo json_encode(ModelGame::req($id, 1), true);
        echo json_encode(ModelGame::req($id, 2), true);
        echo json_encode(ModelGame::imgGame($id), true);
        echo json_encode(ModelGame::descargas($id), true);

        return;
    }

    public function subirJuego($url, $nombre, $servidor, $descarga, $descripcion, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, $obs){
        
        echo json_encode(ModelGame::uploadInfoGames($url, $nombre, $servidor, $descarga, $descripcion, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, $obs), true);
        
        return;
    }

    public function actualizarJuego($id, $url, $nombre, $servidor, $link, $desc, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, $obs){
        
        echo json_encode(ModelGame::updateInfoGames($id, $url, $nombre, $servidor, $link, $desc, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, $obs), true);

        return;
    }

    public function borrar($id){

        echo json_encode(ModelGame::delete($id), true);

        return;
    }


}