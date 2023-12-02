<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//Classe do pedido INDIVIDUAL
class PedidoFinalController{

    public function index()
    {
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);
        $template = $twig->load('pedidoFinal.html');

        return $template->render();
    }


    public function  criarPedido(){
        
        try{

        $pedidoFinal = new PedidoFinal;
        $pedidoFinal->setSiape_requisitante($_POST['siape']);
        $pedidoFinal->setHabilitacao_especial($_POST['habilitacaoEspecial']);
        $pedidoFinal->setDotacao($_POST['Dotacao']);

        $pedidoFinal->faz_tudo($_POST['data_ini'],$_POST['data_final']);
        
        }catch(\Exception $e) {

            $_SESSION['msg_error'] = array('msg' => $e->getMessage(), 'count' => 0);

            header('Location: ../');
            
        }

        header('Location: ../main/index');
}
}