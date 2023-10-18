<?php

class MainController{
    public function index()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);

        $template = $twig->load('main.html');
        $params['user'] = $_SESSION['user']; 


        return $template->render($params);
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();

        echo 'sair';

        header('Location: http://localhost:8001/projetocompras/projeto/public');
    }
}