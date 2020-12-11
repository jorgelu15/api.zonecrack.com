<?php

require_once 'conexion.php';

class ModelBanner
{

    //retorna true si existe algun banner
    static public function there_is_banner(){
        try{
            $statement = Conexion::connect()->query("SELECT * FROM banner");
            $statement->execute(array());
            $items = $statement->rowCount();
            if($items>0){
                return true;
            }
            return false;

        }catch(PDOException $e){
            return[];
        }
    }

    static public function uploadBanner($nombre, $img, $link){
        try {
            for($i=0; $i<5; $i++){
                $statement = Conexion::connect()->prepare("INSERT INTO banner (nombre, img, link) VALUES (:nombre, :img, :link)");
                $statement->execute([':nombre' => $nombre[$i], ':img' => $img[$i], ':link' => $link[$i]]);
            }
            return;
        } catch (PDOException $e) {
            return [];
        }
    }

    static public function updateBanner($nombre, $img, $link){
        
        try {
            for($i=0; $i<5; $i++){
                $statement = Conexion::connect()->prepare("UPDATE banner SET nombre = '$nombre[$i]', img = '$img[$i]', link = '$link[$i]' WHERE id = '" . ($i+1) . "'");
                $statement->execute();
            }
        } catch (PDOException $e) {
            return [];
        }
    }

    static public function getBanners(){
        

        try {
            $statement = Conexion::connect()->prepare("SELECT * FROM banner");
            $statement->execute();
            
            return $statement->fetchAll(PDO::FETCH_CLASS);
        } catch (PDOException $e) {
            return [];
        }
    }

}