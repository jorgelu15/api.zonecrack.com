<?php

class ControllerRegistro
{
    /****************************************************************
     * CREANDO UN USUARIO NUEVO
     ********************************************************************/
    public function create($data)
    {
        /****************************************************************
         * VALIDA QUE EL NOMBRE SOLO CONTENGA LETRAS
         ********************************************************************/
        if (isset($data['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚ ]+$/', $data['nombre'])) {
            $json = array(
                "status"  => 404,
                "msg" => 'El campo solo puede contener letras'
            );

            echo json_encode($json, true);

            return;
        }

        /****************************************************************
         * VALIDA QUE EL EMAIL NO ESTE REPETIDO
         ********************************************************************/
        if (ModelRegistro::emailRepeat($data)) {
            $json = array(
                "status"  => 404,
                "msg" => 'La cuenta de correo electronico ya esta en uso'
            );

            echo json_encode($json, true);

            return;
        }

        /****************************************************************
         * GENERAR CREDENCIALES DEL USUARIO
         ********************************************************************/
        $cred_client = secured_encrypt(FIRST_KEY);
        $key_secret = secured_encrypt(SECOND_KEY);
        /****************************************************************
         * SI TODO SALE BIEN CREA EL USUARIO
         ********************************************************************/
        $validate = ModelRegistro::createUser($data, $cred_client, $key_secret);
        if($validate == 200) {
            $json = array(
                "status"  => 200,
                "msg" => 'USUARIO CREADO EXITOSAMENTE'
            );
        } else {
            $json = array(
                "status"  => 404,
                "msg" => $validate
            );
        }

        echo json_encode($json);

        return;
    }
}
