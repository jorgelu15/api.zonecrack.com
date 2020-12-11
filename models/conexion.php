<?php

class Conexion
{
   /****************************************************************
    * CONEXION A LA BASE DE DATOS CON METODO ESTATICO
    ********************************************************************/
    static public function connect()
    {
        $enlace = new PDO('mysql:host=localhost;dbname=zonacrack',
        'root',
        '');

        $enlace->exec('set names utf8');

        return $enlace;
    }
}
