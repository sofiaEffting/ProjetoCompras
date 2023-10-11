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

        $sql  = "SELECT * FROM usuario WHERE siape=:siape";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":siape", $this->siape);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $result = $stmt->fetch();

            if ($result['senha'] == $this->senha) {
                
                return true;

            } else {
                echo 'nao encontrado';
            }
        }

        throw new \Exception('Login inválido');

    }

    public function setSiape($siape){
        $this->email = $siape;
    }

    public function getSiape(){
        return $this->siape;
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