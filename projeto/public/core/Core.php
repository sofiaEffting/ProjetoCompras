<?php

class Core
{

    private $url;

    private $controller;
    private $method = 'index';
    private $params = array();

    private $user;

    private $error;

    public function __construct()
    {
        $this->user = $_SESSION['user'] ?? null;
        $this->error = $_SESSION['msg_error'] ?? null;

        if (isset($this->error)) {

            if ($this->error['count'] === 0) {

                $_SESSION['msg_error']['count']++;

            } else {

                unset($_SESSION['msg_error']);

            }
        }
    }

    public function start($request) {

        if (isset($request['url'])) {

            //Primeira informacao = controller, segunda = metodo, terceira = parametros
            $this->url = explode('/',$request['url']);
    
            $this->controller = ucfirst($this->url[0]).'Controller';

            if (!empty($this->url[1]))
                $this->method     = $this->url[1];
            if(!empty($this->url[2]))
                $this->params     = $this->url[2];

        }

        if ($this->user) {
            //Controllers que o usuário tem acesso
            $pg_permission = ['MainController', 'ItemController'];

            if (!isset($this->controller) || !in_array( $this->controller , $pg_permission )){
                $this->controller = 'MainController';
                $this->method = 'index';
            } 
        } else {
            $pg_permission = ['LoginController','CadastroController'];

            if (!isset($this->controller) || !in_array( $this->controller , $pg_permission )){
                $this->controller = 'LoginController';
                $this->method = 'index';
            }
        }

        return call_user_func(array(new $this->controller, $this->method), $this->params);

    }
}