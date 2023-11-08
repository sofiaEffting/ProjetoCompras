<?php

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

        echo $_SERVER['DOCUMENT_ROOT'];

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'Hello World !');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello world.xlsx');


        // // Obtenha a planilha ativa (geralmente é a primeira)
        // $sheet = $spreadsheet->getActiveSheet();

        // // Faça alterações na planilha
        // $sheet->setCellValue('B8', 'Teste');

        // // Salve as alterações de volta para o arquivo Excel
        // $writer = IOFactory::createWriter($spreadsheet, 'xlsx');
        // $writer->save('exemplo.xlsx');

    }
}