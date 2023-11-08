<?php

    require_once '../controller/ConnectionController.php';

    use Database\ConnectionController;

    $categoria = $_GET['categoria'];
    $conn = ConnectionController::connectDb();

    $sql = 'SELECT sipac, descricao FROM produto WHERE prod_categoria = :categoria';

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':categoria', $categoria);

    $stmt->execute();

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();
    }

    print(json_encode($result));


