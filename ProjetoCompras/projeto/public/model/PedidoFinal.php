<?php

use Database\ConnectionController;

class PedidoFinal{

    private $id;
    private $siape_requisitante;
    private $habilitacao_especial;
    private $dotacao_orcamentaria;

    function juntar_pedido($date_ini, $date_final){

        $conn = ConnectionController::connectDb();

        $idsPedidos = array();
        
        $sql = "SELECT id FROM pedido_compra_individual WHERE data BETWEEN '$date_ini' AND '$date_final'";
        $result = $conn->query($sql);
    
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $idsPedidos[] = $row['id'];
        }
        
    }

}





}