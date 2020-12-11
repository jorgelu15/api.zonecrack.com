<?php

    require_once "lib/config.php";

    require_once "controllers/routes.controller.php";
    require_once "controllers/registro.controller.php";
    require_once "controllers/user.controller.php";
    require_once "controllers/game.controller.php";
    require_once "controllers/banner.controller.php";

    require_once "models/registro.model.php";
    require_once "models/user.model.php";
    require_once "models/banner.model.php";
    require_once "models/game.model.php";


    $routes = new ControllerRoutes();
    $routes->index();