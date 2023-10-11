<?php

class MainController{
    public function index()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);

        $template = $twig->load('main.html');

        return $template->render();
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();

        echo 'sair';

        header('Location: http://localhost:8001/');
    }
}