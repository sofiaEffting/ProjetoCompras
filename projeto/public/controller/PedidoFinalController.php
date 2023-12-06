<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Database\ConnectionController as DB;

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
        $pedidoFinal->setHabilitacao_especial($_POST['habilitacao']);
        $pedidoFinal->setDotacao($_POST['dotacao']);

        $lista = $pedidoFinal->faz_tudo($_POST['data_ini'],$_POST['data_final']);
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Sipac');
        $sheet->setCellValue('B1', 'Descricao');
        $sheet->setCellValue('C1', 'Quantidade');
        
        $row = 2;
        foreach ($lista as $dadosProduto) {
            $sheet->setCellValue('A' . $row, $dadosProduto['sipac']);
            $sheet->setCellValue('B' . $row, $dadosProduto['descricao']);
            $sheet->setCellValue('C' . $row, $dadosProduto['quantidade']);
            $row++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="dados_produtos.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer = new Xlsx($spreadsheet);

        $writer->save('php://output');
        }catch(\Exception $e) {

            $_SESSION['msg_error'] = array('msg' => $e->getMessage(), 'count' => 0);

            header('Location: ../');
            
        }

        header('Location: ../main/index');
}
}