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

    
    public function cadastrarItem()
    {
        try {
            Item::cadastrarItem($_POST);
            echo '<script>alert("Item inserido com sucesso SLA!");</script>';
            //manda o usuario para a pagia onde consta todos os itens
            header("Location: ../main/index");

        } catch (\Exception $e) {
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            //volta para o formulario para preencher todos os campos
            header("Location: ../main/index");

        }
    }
    public function modificar()
    {

    }

    public function deletar()
    {

    }
}