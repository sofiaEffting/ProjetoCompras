<?php

    // ini_set('display_errors', true);

    require_once './core/Core.php';

    //controllers
    require_once './controller/CadastroController.php';
    require_once './controller/LoginController.php';
    require_once './controller/ConnectionController.php';

    //models
    require_once './model/User.php';

    //twig
    require_once 'vendor/autoload.php';

    $core = new Core();
    echo $core->start($_GET);