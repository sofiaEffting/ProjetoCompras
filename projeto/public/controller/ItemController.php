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
        $params['msg'] = $_SESSION['msg'] ?? null;
        
        $template = $twig->load('item.html');
        return $template->render($params);
    }


    public function cadastrar()
    {
        unset($_SESSION['msg']);

        try {
            Item::cadastrarItem($_POST);
            $_SESSION['msg'] = 'Cadastro realizado com sucesso!';
        } catch (\Exception $e) {
            $_SESSION['msg'] = 'Houve um erro ao cadastrar! ' . $e->getMessage();
        }
        header("Location: ../item/index");
    }
    public function modificar()
    {

    }

    public function deletar()
    {

    }
}