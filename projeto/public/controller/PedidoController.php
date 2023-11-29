<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

//Classe do pedido INDIVIDUAL
class PedidoController{

    public function index()
    {
        $pedido = new Pedido();

        $categorias = $pedido->getCategorias();
        
        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig   = new Twig\Environment($loader,[
            'auto_reload' => true
        ]);
        $template = $twig->load('pedido.html');

        $params['categorias'] = $categorias;

        return $template->render($params);
    }

    public function gerarPedido()
    {
        var_dump($_POST);

        

        // ini_set('max_execution_time', 300);
        // ini_set('memory_limit', '1G');

        // $spreadsheet = IOFactory::load('teste.xlsx');
        // $worksheet = $spreadsheet->getActiveSheet();
        // $worksheet->getCell('G8')->setValue('2');
        // $worksheet->getCell('G9')->setValue('abacate');
        // $worksheet->getCell('G10')->setValue('3');

        // $writer = IOFactory::createWriter($spreadsheet, 'Xls');

        // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        // header('Content-Disposition: attachment; filename="pedido.xlsx"');

        // $writer->save('pedido.xlsx');
    }
}