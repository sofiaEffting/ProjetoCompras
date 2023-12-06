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
        
        $pedidosInfo = array(); // Agora armazenará tanto o ID quanto a quantidade
        
        $sql = "SELECT id, qtde FROM pedido_compra_individual WHERE data BETWEEN :date_ini AND :date_final";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':date_ini', $date_ini);
        $stmt->bindParam(':date_final', $date_final);
    
        if (!$stmt->execute()) {
            $errorInfo = $stmt->errorInfo();
            $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : "Erro desconhecido ao executar a consulta SQL";
            throw new Exception("Erro ao executar a consulta SQL: " . $errorMessage);
        }
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedidoInfo = array(
                'idpedido' => $row['idpedido'],
                'quantidade' => $row['qtde']
            );
            $pedidosInfo[] = $pedidoInfo;
        }
        return $pedidosInfo;
    }

    private function geraListaProdutos($pedidosInfo) {
        $conn = ConnectionController::connectDb();
        
        // Array para armazenar as informações finais
        $result = array();
        
        // Itera sobre cada pedido no array $pedidosInfo
        foreach ($pedidosInfo as $pedido) {
            $idPedido = $pedido['idpedido'];
            $quantidade = $pedido['quantidade'];
            
            // Consulta para obter os IDs de produtos relacionados ao pedido
            $sql = "SELECT idproduto FROM pedido_to_pedido_compra_ind WHERE idpedido = :idPedido";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idPedido', $idPedido);
            
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : "Erro desconhecido ao executar a consulta SQL";
                throw new Exception("Erro ao executar a consulta SQL: " . $errorMessage);
            }
            
            // Itera sobre os resultados da consulta
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $idProduto = $row['idproduto'];
                
                // Combina o ID do produto com a quantidade do pedido
                $result[] = array(
                    'idproduto' => $idProduto,
                    'quantidade' => $quantidade
                );
            }
        }
        
        return $result;
    }

    private function geraListaFinal($result) {
        $conn = ConnectionController::connectDb();
        
        // Array para armazenar os dados finais do produto
        $dadosProdutos = array();
        
        // Itera sobre cada entrada no array $result
        foreach ($result as $item) {
            $idProduto = $item['idproduto'];
            $quantidade = $item['quantidade'];
            
            // Consulta para obter os dados do produto
            $sql = "SELECT sipac, descricao FROM produto WHERE id = :idProduto";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idProduto', $idProduto);
            
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                $errorMessage = isset($errorInfo[2]) ? $errorInfo[2] : "Erro desconhecido ao executar a consulta SQL";
                throw new Exception("Erro ao executar a consulta SQL: " . $errorMessage);
            }
            
            // Obtém os dados do produto e armazena no array final
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $dadosProduto = array(
                    'sipac' => $row['sipac'],
                    'descricao' => $row['descricao'],
                    'quantidade' => $quantidade
                );
                $dadosProdutos[] = $dadosProduto;
            }
        }
        
        return $dadosProdutos;
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
        $lista_idprodutos = $this->geraListaProdutos($idpedidos);
        $lista_final = $this->geraListaFinal($lista_idprodutos);
        $this->cadastra_pedido();
        return $lista_final;
    }
}