<?php

    try{

        /*Colocar o codigo abaixo em uma classe*/

        $hostname = 'dev_ifc.db4free.net';
        $username = 'dev_ifc';
        $password = 'q1w2e3r4t5';
        $dbname = 'compras_ifc';
    
        // Cria uma conexão PDO
        $conexao = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }catch(PDOException $e){

        echo 'Não foi possível se conectar ao Banco de dados. Verifique sua conexão com a internet e tente novamente mais tarde. <br>';
        echo 'ERROR: ' . $e->getMessage();

    }

    $siape = $_POST['siape'];
    $senha = md5($_POST['senha']);

    $queryLogin = "SELECT * FROM `usuario` WHERE siape = '$siape' AND senha = '$senha'";
    $stmt = $conexao->query($queryLogin);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    var_dump($row);

    //@TODO if $row -> login e setar sessions, else volta pra tela de login
