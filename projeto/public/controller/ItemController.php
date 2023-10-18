<?php

class ItemController{
    
    public function index()
    {
        
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true,
            'debug' => true
        ]);
        
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $model = new Item();
        $params['itens'] = $model->getItens();
        
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