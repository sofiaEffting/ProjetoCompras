<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Database\ConnectionController as DB;

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
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1G');

        $descricoes = array();
        
        foreach ($_POST as $key => $descricao) {
            if (substr($key, 0, 5) != "valor") {
                $descricoes[] = $descricao;
            }
        }

        $placeholders = implode(',', array_fill(0, count($descricoes), '?'));

        $conn = DB::connectDb();

        $sql = "SELECT * FROM produto WHERE `sipac` IN ($placeholders)";

        $stmt = $conn->prepare($sql);

        foreach ($descricoes as $index => $descricao) {
            $stmt->bindValue(($index + 1), $descricao); // Os índices dos placeholders no PDO começam em 1
        }

        if ($stmt->execute()) {
            $itens = $stmt->fetchAll();
        }

        $spreadsheet = IOFactory::load('teste.xlsx');

        $worksheet = $spreadsheet->getActiveSheet();

        foreach($itens as $key => $item){

            $linha = strval(8 + $key);

            $worksheet->getCell('A' . $linha)->setValue($item['sipac']);
            $worksheet->getCell('B' . $linha)->setValue($item['catmat_catser']);
            $worksheet->getCell('C' . $linha)->setValue($item['natureza_despesa']);
            $worksheet->getCell('D' . $linha)->setValue($key + 1);
            $worksheet->getCell('E' . $linha)->setValue($item['item_pe']);
            $worksheet->getCell('F' . $linha)->setValue($item['unidade_medida']);
            $worksheet->getCell('G' . $linha)->setValue($item['descricao']);
            $worksheet->getCell('H' . $linha)->setValue($_POST['valor' . strval($key + 1)]);

        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Configurar cabeçalhos HTTP para forçar o download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="write.xlsx"');
        header('Cache-Control: max-age=0');

        // Envie o conteúdo do arquivo para a saída
        $writer->save('php://output');

    }

    public function historicoPedidoIndividual($siape) {

        $loader = new Twig\Loader\FilesystemLoader('view');
        $twig = new Twig\Environment($loader, [
            'auto_reload' => true,
        ]);

        $model = new Pedido();
    
        $params['pedidos'] = $model->todosPedidosIndiviguais($siape);
    
        $template = $twig->load('historicoPedido.html');
        
        return $template->render($params);
    }
}