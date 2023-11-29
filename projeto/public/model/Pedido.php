<?php

use Database\ConnectionController as DB;
class Pedido{
    public function getCategorias()
    {
        $conn = DB::connectDb();
        
        $sql = "SELECT nome_categoria FROM categoria";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount()) {
            return $stmt->fetchAll();
        }
    
    }
}