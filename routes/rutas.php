<?php

$arrayRoutes = explode('/', $_SERVER['REQUEST_URI']);


/****************************************************************
 * EL SIGUIENTE CONDICIONAL ES PARA CUANDO NO HAY NIGÚN ENDPOINT
 ********************************************************************/
if (count(array_filter($arrayRoutes)) == 0) {
    $json = array(
        "DETAILS" => "Not Found"
    );

    echo json_encode($json, true);
} else {
    /****************************************************************
     * SE ASEGURA DE SI EXISTE UN UNICO INDICE
     ********************************************************************/
    if (count(array_filter($arrayRoutes)) == 1) {
        /****************************************************************
         * EL SIGUIENTE CONDICIONAL ES PARA CUANDO SE ESTÁ REGISTRANDO
         ********************************************************************/
        if (array_filter($arrayRoutes)[1] == 'registro') {
            /****************************************************************
             * SI HAY PETICIONES DE TIPO POST
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = array(
                    "nombre"      => $_POST['nombre'],
                    "email"       => $_POST['email'],
                    "password"    => $_POST['password']
                );

                $registro = new ControllerRegistro();
                $registro->create($data);
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO GET
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                $json = array(
                    "status"  => 404,
                    "msg" => 'No se encuentra la ruta'
                );
        
                echo json_encode($json, true);
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO PUT
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                $json = array(
                    "status"  => 404,
                    "msg" => 'No se encuentra la ruta'
                );
        
                echo json_encode($json, true);
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO DELETE
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $json = array(
                    "status"  => 404,
                    "msg" => 'No se encuentra la ruta'
                );
        
                echo json_encode($json, true);
                return;
            }
        }

        /****************************************************************
         * EL SIGUIENTE CONDICIONAL ES PARA CUANDO SE ESTÁ LOGUEANDO
         ********************************************************************/
        if (array_filter($arrayRoutes)[1] == 'user') {
            /****************************************************************
             * SI HAY PETICIONES DE TIPO POST
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $email = isset($_POST['email']) ? $_POST['email'] : null;
                $password = isset($_POST['password']) ? $_POST['password'] : null;
                $data = array(
                    'email' => $email,
                    'password' => $password
                );
                $registro = new ControllerUser();
                $registro->validate($data);
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO GET
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                $registro = new ControllerRegistro();
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO PUT
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                $registro = new ControllerRegistro();
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO DELETE
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $registro = new ControllerRegistro();
                return;
            }
        }

        if (array_filter($arrayRoutes)[1] == 'game') {
            /****************************************************************
             * SI HAY PETICIONES DE TIPO POST
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                // $data = array(
                //     "nombre"   => $_POST['nombre'],
                //     "email"    => $_POST['email'],
                //     "password" => $_POST['password']
                // );

                $url = urltotitle($_POST['nombre']);
                $nombre = htmlentities($_POST['nombre']);
                $descripcion = htmlentities($_POST['descripcion']);
                $nivel = $_POST['nivel'];
                $genero = htmlentities($_POST['genero']);
                $plataforma = htmlentities($_POST['plataforma']);
                $distribuidor = htmlentities($_POST['distribuidor']);
                $desarrollador = htmlentities($_POST['desarrollador']);
                $lanzamiento = htmlentities($_POST['lanzamiento']);
                $img = htmlentities($_POST['imagen']);
                $servidor = $_POST['servidor']; //es array
                $descarga = $_POST['descarga']; //es array
                $so = $_POST['so'];
                $procesador = $_POST['procesador'];
                $memoria = $_POST['memoria'];
                $graficos = $_POST['graficos'];
                $libreria = $_POST['libreria'];
                $red = $_POST['red'];
                $almacenamiento = $_POST['almacenamiento'];

                $reqMin = [];
                array_push($reqMin, htmlentities($so[0]));
                array_push($reqMin, htmlentities($procesador[0]));
                array_push($reqMin, htmlentities($memoria[0]));
                array_push($reqMin, htmlentities($graficos[0]));
                array_push($reqMin, htmlentities($libreria[0]));
                array_push($reqMin, htmlentities($red[0]));
                array_push($reqMin, htmlentities($almacenamiento[0]));
                //echo var_dump($reqMin);
                $reqRec = [];
                array_push($reqRec, htmlentities($so[1]));
                array_push($reqRec, htmlentities($procesador[1]));
                array_push($reqRec, htmlentities($memoria[1]));
                array_push($reqRec, htmlentities($graficos[1]));
                array_push($reqRec, htmlentities($libreria[1]));
                array_push($reqRec, htmlentities($red[1]));
                array_push($reqRec, htmlentities($almacenamiento[1]));
                //echo var_dump($reqRec);

                $imagenes = $_POST['img'];

                $obs = $_POST['observaciones'];

                $game = new ControladorGame();
                $game->subirJuego($url, $nombre, $servidor, $descarga, $descripcion, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, urlencode($obs));
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO GET
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                $game = new ControladorGame();
                $game->games();
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO PUT
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                $id = $_POST['id'];
                $url = urltotitle($_POST['nombre']);
                $nombre = htmlentities($_POST['nombre']);
                $descripcion = htmlentities($_POST['descripcion']);
                $nivel = $_POST['nivel'];
                $genero = htmlentities($_POST['genero']);
                $plataforma = htmlentities($_POST['plataforma']);
                $distribuidor = htmlentities($_POST['distribuidor']);
                $desarrollador = htmlentities($_POST['desarrollador']);
                $lanzamiento = htmlentities($_POST['lanzamiento']);
                $img = htmlentities($_POST['imagen']);
                $servidor = $_POST['servidor']; //es array
                $descarga = $_POST['descarga']; //es array
                $so = $_POST['so'];
                $procesador = $_POST['procesador'];
                $memoria = $_POST['memoria'];
                $graficos = $_POST['graficos'];
                $libreria = $_POST['libreria'];
                $red = $_POST['red'];
                $almacenamiento = $_POST['almacenamiento'];

                $reqMin = [];
                array_push($reqMin, htmlentities($so[0]));
                array_push($reqMin, htmlentities($procesador[0]));
                array_push($reqMin, htmlentities($memoria[0]));
                array_push($reqMin, htmlentities($graficos[0]));
                array_push($reqMin, htmlentities($libreria[0]));
                array_push($reqMin, htmlentities($red[0]));
                array_push($reqMin, htmlentities($almacenamiento[0]));
                //echo var_dump($reqMin);
                $reqRec = [];
                array_push($reqRec, htmlentities($so[1]));
                array_push($reqRec, htmlentities($procesador[1]));
                array_push($reqRec, htmlentities($memoria[1]));
                array_push($reqRec, htmlentities($graficos[1]));
                array_push($reqRec, htmlentities($libreria[1]));
                array_push($reqRec, htmlentities($red[1]));
                array_push($reqRec, htmlentities($almacenamiento[1]));
                //echo var_dump($reqRec);

                $imagenes = $_POST['img'];

                $obs = $_POST['observaciones'];

                $game = new ControladorGame();
                $game->actualizarJuego($id, $url, $nombre, $servidor, $descarga, $descripcion, $nivel, $genero, $plataforma, $distribuidor, $desarrollador, $lanzamiento, $reqMin, $reqRec, $img, $imagenes, urlencode($obs));

                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO DELETE
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $registro = new ControladorGame();
                return;
            }
        }

        if (array_filter($arrayRoutes)[1] == 'banner') {
            /****************************************************************
             * SI HAY PETICIONES DE TIPO POST
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = array(
                    "nombre"   => $_POST['nombre'],
                    "img"    => $_POST['imagen'],
                    "link" => $_POST['link']
                );

                $banner = new ControladorBanner();
                $banner->create($data);
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO GET
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                $registro = new ControladorBanner();
                echo $registro->getBanners();
                return;
            }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO PUT
             ********************************************************************/
            // if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
            //     $registro = new ControladorBanner();
            //     return;
            // }
            /****************************************************************
             * SI HAY PETICIONES DE TIPO DELETE
             ********************************************************************/
            // if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            //     $registro = new ControladorBanner();
            //     return;
            // }
        }
    } else {
        /****************************************************************
         * EL SIGUIENTE CONDICIONAL ES PARA CUANDO EXISTEN MAS DE 1 INDICE
         ********************************************************************/
        if (array_filter($arrayRoutes)[1] == 'user' && is_numeric(array_filter($arrayRoutes)[2])) {
            /****************************************************************
             * SI HAY PETICIONES DE TIPO POST
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }
        }

        if (array_filter($arrayRoutes)[1] == 'game' && is_numeric(array_filter($arrayRoutes)[2])) {
            /****************************************************************
             * SI HAY PETICIONES DE TIPO POST
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                $id = array_filter($arrayRoutes)[2];

                $game = new ControladorGame();
                $game->juego($id);

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                $id = array_filter($arrayRoutes)[2];

                $game = new ControladorGame();
                $game->borrar($id);

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }
        }

        if (array_filter($arrayRoutes)[1] == 'banner' && is_numeric(array_filter($arrayRoutes)[2])) {
            /****************************************************************
             * SI HAY PETICIONES DE TIPO POST
             ********************************************************************/
            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }

            if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
                // $registro = new ControllerRegistro();
                // $registro->create();

                //SE DEBEN CREAR LOS CONTROLADORES CORRESPONDIENTES
                return;
            }
        }
    }
}
