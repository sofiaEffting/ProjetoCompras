<?php

use Database\ConnectionController;

class User{

    //@TODO colocar todos os atributos da tabela usuario
    private $siape;
    private $nivelAcesso;
    private $nome;
    private $email;
    private $senha;
    private $setor;
    private $telefone;

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
                
                $_SESSION['user'] = $result;

                return true;

            } else {
                echo 'nao encontrado';
            }
        }

        throw new \Exception('Login inválido');

    }

    public function setSiape($siape){
        $this->siape = $siape;
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

    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    public function setSetor($setor){
        $this->setor = $setor;
    }

    public function setNivelAcesso($nivelAcesso){
        $this->nivelAcesso = $nivelAcesso;
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

    public function getTelefone(){
        return $this->telefone;
    }

    public function getSetor(){
        return $this->setor;
    }

    public function cadastrar(){

        $conn = ConnectionController::connectDb();

        $sql  =  "INSERT INTO usuario (siape,nivel_acesso,setor,nome,telefone,email,senha) 
        VALUES ('$this->siape','$this->nivelAcesso','$this->setor','$this->nome','$this->telefone','$this->email','$this->senha');";

        $stmt = $conn->prepare($sql);
        if($stmt->execute()){
            return true;
        } else{
            echo "Ocorreu um erro durante o cadastro";
        }
    }
}