<?php

use Database\ConnectionController;

class PedidoFinal{

    private $siape_requisitante;
    private $habilitacao_especial;
    private $dotacao_orcamentaria;

    public function setSiape_requisitante($siape_requisitante){
        $this->siape_requisitante = $siape_requisitante;
    }

    public function getSiape_requisitante (){
        return $this->siape_requisitante;
    }

    public function setHabilitacao_especial($habilitacao_especial){
        $this->habilitacao_especial = $habilitacao_especial;
    }

    public function getHabilitacao_especial (){
        return $this->habilitacao_especial;
    }

    public function setDotacao($dotacao_orcamentaria){
        $this->dotacao_orcamentaria = $dotacao_orcamentaria;
    }

    public function getDotacao(){
        return $this->dotacao_orcamentaria;
    }

    private function juntar_pedido($date_ini, $date_final){
        $conn = ConnectionController::connectDb();
        
        $idsPedidos = array();
        
        $sql = "SELECT id FROM pedido_compra_individual WHERE data BETWEEN :date_ini AND :date_final";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date_ini', $date_ini);
        $stmt->bindParam(':date_final', $date_final);
    
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : "Erro desconhecido ao executar a consulta SQL";
            throw new Exception("Erro ao executar a consulta SQL: " . $errorMessage);
        }
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $idsPedidos[] = $row['id'];
        }
    
        return $idsPedidos;
    }

    private function geraListaProdutos($idsPedidos){
        $conn = ConnectionController::connectDb();
        
        $produtosQuantidades = array();
        
        // Consulta SQL para obter os IDs dos produtos e quantidades associadas aos IDs dos pedidos
        $sql = "SELECT id_pci, id_produto, SUM(qtde) as qtde FROM pedido_to_pedido_compra_ind WHERE id_pci IN (" . implode(",", $idsPedidos) . ") GROUP BY id_pci, id_produto";
        $stmt = $conn->prepare($sql);
        
        // Verifica se a preparação da consulta foi bem-sucedida
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : "Erro desconhecido ao executar a consulta SQL";
            throw new Exception("Erro ao executar a consulta SQL: " . $errorMessage);
        }
    
        // Adiciona os produtos e quantidades ao array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $idProduto = $row['id_produto'];
            $quantidade = $row['qtde']; // corrigi o nome do campo
    
            if (!isset($produtosQuantidades[$idProduto])) {
                $produtosQuantidades[$idProduto] = $quantidade;
            } else {
                $produtosQuantidades[$idProduto] += $quantidade;
            }
        }
    
        return $produtosQuantidades;
    }

    private function geraListaFinal($idsProdutosQuantidades){
        $conn = ConnectionController::connectDb();
        
        $detalhesProdutos = array();
        
        // Consulta SQL para obter informações detalhadas dos produtos
        $sql = "SELECT * FROM produto WHERE sipac IN (" . implode(",", array_keys($idsProdutosQuantidades)) . ")";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Adiciona as informações detalhadas dos produtos ao array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sipac = $row['sipac'];
            $descricao = $row['descricao'];
            $quantidade = $idsProdutosQuantidades[$sipac];
    
            $detalhesProdutos[] = array(
                'sipac' => $sipac,
                'descricao' => $descricao,
                'quantidade' => $quantidade
            );
        }
    
        return $detalhesProdutos;
    }

    private function cadastra_pedido(){
        $conn = ConnectionController::connectDb();
    
        $sql = "INSERT INTO pedidofinal (siape_requisitante, habilitacao_especifica, dotacao_orcamentaria) VALUES (:siape, :habilitacao, :dotacao)";
        
        // Prepara e executa a declaração
        $stmt = $conn->prepare($sql);
    
        // Vincula os parâmetros
        $stmt->bindValue(':siape', $this->siape_requisitante);
        $stmt->bindValue(':habilitacao', $this->habilitacao_especial);
        $stmt->bindValue(':dotacao', $this->dotacao_orcamentaria);
    
        // Executa a consulta
        $result = $stmt->execute();
        
        return true;
    }

    public function faz_tudo($date_ini, $date_final){
        // Função que fará tudo para facilitar a implementação do pedido final no controller.
        $idpedidos = $this->juntar_pedido($date_ini,$date_final);
        echo "saiu";
        $lista_idprodutos = $this->geraListaProdutos($idpedidos);
        echo "saiu 2";
        $lista_final = $this->geraListaFinal($lista_idprodutos);
        echo "saiu 3";
        // Nesta linha sera inserida a função que gera o excel.
        echo "passou aqui 3";
        $this->cadastra_pedido();
        echo "passou aqui 4";
        return true;
    }
}