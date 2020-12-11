<?php
require_once 'conexion.php';

class ModelUser
{

    /****************************************************************
     * VALIDACION DE CREDENCIALES DE USUARIO CON METODO ESTATICO, EVALUAR METODO Y DEFINIR 
     ********************************************************************/
    static public function validation_cred()
    {
        $statement = Conexion::connect()->prepare("SELECT cred_client, key_secret FROM usuarios");
        $statement->execute();

        while ($logs = $statement->fetch()) {
            /****************************************************************
             * COMPARA LOS DATOS TRAIDOS POR CABECERA CON LOS DE LA BASE DE DATOS 
             ********************************************************************/
            if (
                'Basic ' . base64_encode(secured_decrypt($_SERVER['PHP_AUTH_USER']) . ':' . secured_decrypt($_SERVER['PHP_AUTH_PW']))
                ==
                'Basic ' . base64_encode(secured_decrypt($logs['cred_client']) . ':' . secured_decrypt($logs['key_secret']))
            ) {
                return 200;
            }
        }

        return 404;

        $statement = null;
    }

    /****************************************************************
     * VALIDACION DE USUARIO CON METODO ESTATICO,  
     ********************************************************************/

    static public function validation_user($data)
    {
        $statement = Conexion::connect()->prepare("SELECT email, password FROM usuarios WHERE email = :email AND password = :password");
        $statement->execute([':email' => $data['email'], ':password' => $data['password']]);
        if(!$statement->rowCount()) {
            return false;
        }

        return true;
    }
}
