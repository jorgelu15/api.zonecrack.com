<?php

require_once 'conexion.php';

class ModelRegistro
{
    /****************************************************************
     * METODO PARA CREAR UN USUARIO 
     ********************************************************************/
    static public function createUser($data, $cred_client, $key_secret)
    {
        $statement = Conexion::connect()->prepare("INSERT INTO usuarios(nombre, email, password, cred_client, key_secret)VALUES(:nombre, :email, :password, :cred_client, :key_secret)");
        $statement->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $statement->bindParam(':email', $data['email'], PDO::PARAM_STR);
        $statement->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $statement->bindParam(':cred_client', $cred_client, PDO::PARAM_STR);
        $statement->bindParam(':key_secret', $key_secret, PDO::PARAM_STR);
        // $statement->execute([
        //     ':nombre'     => $data['nombre'],
        //     ':email'      => $data['email'],
        //     ':password'   => $data['password'],
        //     ':key_secret' => $key_secret
        // ]);

        if (!$statement->execute()) {
            return Conexion::connect()->errorInfo();
        }

        return 200;

        $statement = null;
    }

    /****************************************************************
     * VALIDACION PARA COMPROBAR SI HAY EMAIL REPETIDOS 
     ********************************************************************/

    static public function emailRepeat($data)
    {
        $statement = Conexion::connect()->prepare("SELECT email FROM usuarios WHERE email = :email");
        $statement->execute([':email' => $data['email']]);
        if ($statement->rowCount()) {
            return true;
        } else {
            return false;
        }
    }
}
