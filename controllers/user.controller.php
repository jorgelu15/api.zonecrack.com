<?php

class ControllerUser
{
    /****************************************************************
     * CREANDO UN USUARIO NUEVO
     ********************************************************************/
    public function validate($data)
    {
        /****************************************************************
         * VALIDAR CREDENCIALES DEL USUARIO
         ********************************************************************/
        
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            $validate_cred = ModelUser::validation_cred();
            
            if($validate_cred == 200) {
                $json = array(
                    'status' => $validate_cred,
                    'msg'    => 'Acceso Autorizado'
                );

                echo json_encode($json);
                return;
            }

            $json = array(
                'status' => 404,
                'msg'    => 'Los datos no concuerdan con los del sistema'
            );


            echo json_encode($json);
            return;
            
        }

        /****************************************************************
         * SI EXISTEN DATOS POR FORMULARIO Y NO POR CABECERA
         ********************************************************************/

        if(isset($data)) {
            $validate_user = ModelUser::validation_user($data);
            if($validate_user) {
                $json = array(
                    'status' => 200,
                    'msg'    => 'INICIÓ SESION'
                );

                echo json_encode($json);
                return;
            }

            $json = array(
                'status' => 404,
                'msg'    => 'Los datos no concuerdan con los del sistema'
            );


            echo json_encode($json);
            return;
        }

        return;
    }
}
