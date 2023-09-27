<?php

use Database\ConnectionController;

class User{

    //@TODO colocar todos os atributos da tabela usuario
    private $siape;
    private $nivelAcesso;
    private $nome;
    private $email;
    private $senha;

    public function validateLogin()
    {

        $conn = ConnectionController::connectDb();
        var_dump($conn);
        //conectar no banco de dados
        echo 'teste';
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setnome($nome){
        $this->nome = $nome;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getSenha(){
        return $this->nome;
    }
}