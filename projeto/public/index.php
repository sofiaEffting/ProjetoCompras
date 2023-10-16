<?php

    ini_set('display_errors', true);

    session_start();

    require_once './core/Core.php';

    //controllers
    require_once './controller/LoginController.php';
    require_once './controller/ConnectionController.php';
    require_once './controller/MainController.php';
    require_once './controller/ItemController.php';

    //models
    require_once './model/User.php';
    require_once './model/Item.php';

    //twig
    require_once 'vendor/autoload.php';

    $core = new Core();
    echo $core->start($_GET);