<?php

class ItemController{
    
    public function index()
    {
        
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);
        
        
        $model = new Item();
        $params['itens'] = array($model->getItens());
        
        $template = $twig->load('item.html');
        return $template->render($params);
    }

    public function cadastrar()
    {

    }

    public function modificar()
    {

    }

    public function deletar()
    {

    }
}