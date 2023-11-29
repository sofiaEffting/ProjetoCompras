<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//Classe do pedido INDIVIDUAL
class PedidoController{

    public function index()
    {

        
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);
        $template = $twig->load('pedido.html');

        return $template->render();
    }

    public function gerarPedido()
    {
        echo 'gerando pedido...';

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1G');

        $spreadsheet = IOFactory::load('teste.xlsx');
        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->getCell('G8')->setValue('2');
        $worksheet->getCell('G9')->setValue('abacate');
        $worksheet->getCell('G10')->setValue('3');

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('write.xlsx');

    }

    public function check(){
        

    }
}