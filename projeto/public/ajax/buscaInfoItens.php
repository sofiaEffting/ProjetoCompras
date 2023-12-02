<?php

    require_once '../controller/ConnectionController.php';

    use Database\ConnectionController;

    $sipac = $_GET['sipac'];
    $conn = ConnectionController::connectDb();

    $sql = 'SELECT sipac, catmat_catser FROM produto WHERE sipac = :sipac';

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':sipac', $sipac);

    $stmt->execute();

    if ($stmt->rowCount()) {
        $result = $stmt->fetchAll();
    }

    print(json_encode($result));