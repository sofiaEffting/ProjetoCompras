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

    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    public function setSetor($setor){
        $this->setor = $setor;
    }

    public function setNivelAcesso($nivelAcesso){
        $this->nivelAcesso = $nivelAcesso;
    }

    public function setSiape($siape){
        $this->siape = $siape;
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

    public function getSiape(){
        return $this->siape;
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

        if ($conn->query($sql) === TRUE) {
            echo "Cadastro realizado com sucesso!";
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    }
}