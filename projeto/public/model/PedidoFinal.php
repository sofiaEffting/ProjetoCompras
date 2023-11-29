<?php

use Database\ConnectionController;

class PedidoFinal{

    private $siape_requisitante;
    private $habilitacao_especial;
    private $dotacao_orcamentaria;

    public function siape_requisitante($siape_requisitante){
        $this->siape_requisitante = $siape_requisitante;
    }

    public function getsiape_requisitante (){
        return $this->siape_requisitante;
    }

    public function setHabilitacao_especial($habilitacao_especial){
        $this->habilitacao_especial = $habilitacao_especial;
    }

    public function getHabilitacao_especial (){
        return $this->habilitacao_especial;
    }

    public function setDotacao($dotacao_orcamentaria){
        $this->$dotacao_orcamentaria = $dotacao_orcamentaria;
    }

    public function getDotacao(){
        return $this->dotacao_orcamentaria;
    }

    function juntar_pedido($date_ini, $date_final){

        $conn = ConnectionController::connectDb();

        $idsPedidos = array();
        
        $sql = "SELECT id FROM pedido_compra_individual WHERE data BETWEEN '$date_ini' AND '$date_final'";
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $idsPedidos[] = $row['id'];
        }}
        return $idsPedidos;
    }

    function geraListaProdutos($idsPedidos){
        $conn = ConnectionController::connectDb();

        $produtosQuantidades = array();

        // Consulta SQL para obter os IDs dos produtos e quantidades associadas aos IDs dos pedidos
        $sql = "SELECT id_pedido, id_produto, SUM(qtde) as qtde FROM pedido_to_pedido_compra_ind WHERE id_pedido IN (" . implode(",", $idsPedidos) . ") GROUP BY id_pedido, id_produto";
        $result = $conn->query($sql);

        // Verifica se a consulta foi bem-sucedida
        if ($result) {
            // Adiciona os produtos e quantidades ao array
            while ($row = $result->fetch_assoc()) {
                $idProduto = $row['id_produto'];
                $quantidade = $row['quantidade'];

                if (!isset($produtosQuantidades[$idProduto])) {
                    $produtosQuantidades[$idProduto] = $quantidade;
                } else {
                    $produtosQuantidades[$idProduto] += $quantidade;
                }
            }
        }
            return $produtosQuantidades;
        }

    function geraListaFinal($idsProdutosQuantidades){
        $conn = ConnectionController::connectDb();

        $detalhesProdutos = array();

        // Consulta SQL para obter informações detalhadas dos produtos
        $sql = "SELECT * FROM produto WHERE sipac IN (" . implode(",", array_keys($idsProdutosQuantidades)) . ")";
        $result = $conn->query($sql);

        // Verifica se a consulta foi bem-sucedida
        if ($result) {
            // Adiciona as informações detalhadas dos produtos ao array
            while ($row = $result->fetch_assoc()) {
                $sipac = $row['sipac'];
                $descricao = $row['descricao'];
                $quantidade = $idsProdutosQuantidades[$sipac];

                $detalhesProdutos[] = array(
                    'sipac' => $sipac,
                    'descricao' => $descricao,
                    'quantidade' => $quantidade
                );
            }
        }
        return $detalhesProdutos;
    }

    function cadastra_pedido(){
        $conn = ConnectionController::connectDb();

        $sql = "INSERT INTO pedidofinal (siape_requisitante, habilitacao_especifica, dotacao_orcamentaria) VALUES (?, ?, ?)";
    
        // Prepara e executa a declaração
        $stmt = $conn->prepare($sql);

        // Vincula os parâmetros
        $stmt->bind_param("sss", $this->siape_requisitante, $this->habilitacao_especial, $this->dotacao_orcamentaria);

        // Executa a consulta
        $result = $stmt->execute();
        return true;
    }

    function faz_tudo($date_ini, $date_final){
        // Função que fará tudo para facilitar a implementação do pedido final no controller.
        $idpedidos = $this->juntar_pedido($date_ini,$date_final);
        $lista_idprodutos = $this->geraListaProdutos($idpedidos);
        $lista_final = $this->geraListaFinal($lista_idprodutos);

        $this->cadastra_pedido();
    }
}