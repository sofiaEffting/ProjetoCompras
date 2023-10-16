<?php

use Database\ConnectionController;

class Item{

    public function getItens()
    {
        $conn = ConnectionController::connectDb();

        $sql = "SELECT * FROM produto";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount())
        {
            $result = $stmt->fetch();
            return $result;

        } else {
            return false;
        }

    }

}