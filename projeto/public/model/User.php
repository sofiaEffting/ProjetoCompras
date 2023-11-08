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

    public static function cadastrar($aDados){

        $conn = ConnectionController::connectDb();

        $aDados['nome_substituto'] = $aDados['nome_substituto'] ?? null;
        $aDados['nome_social']     = $aDados['nome_social'] ?? null;

        $sql  =  "INSERT INTO usuario (siape, nivel_acesso, setor, nome, telefone, nome_substituto, email, senha, nome_social) 
        VALUES (:siape, :nivel_acesso, :setor, :nome, :telefone, :nome_substituto, :email, :senha, :nome_social);";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':siape', $aDados['siape']);
        $stmt->bindValue(':nivel_acesso', $aDados['nivel_acesso']);
        $stmt->bindValue(':setor', $aDados['setor']);
        $stmt->bindValue(':nome', $aDados['nome']);
        $stmt->bindValue(':telefone', $aDados['telefone']);
        $stmt->bindValue(':nome_substituto', $aDados['nome_substituto']);
        $stmt->bindValue(':email', $aDados['email']);
        $stmt->bindValue(':senha', $aDados['senha']);
        $stmt->bindValue(':nome_social', $aDados['nome_social']);
        
        if($stmt->execute()){
            return true;
        }else{
            throw new Exception("Houve um erro ao realizar o cadastro!");
        }
    }  


    public static function atualizar($dadosAtualizados){
        $conn = ConnectionController::connectDb();

        $dadosAtualizados['nome_substituto'] = $dadosAtualizados['nome_substituto'] ?? null;
        $dadosAtualizados['nome_social']     = $dadosAtualizados['nome_social'] ?? null;

        $sql  =  "UPDATE usuario SET  setor=:setor, nome=:nome, telefone=:telefone, nome_substituto=:nome_substituto, email=:email, senha=:senha, nome_social=:nome_social  WHERE siape = :siape";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':siape', $dadosAtualizados['siape']);
        $stmt->bindValue(':setor', $dadosAtualizados['setor']);
        $stmt->bindValue(':nome', $dadosAtualizados['nome']);
        $stmt->bindValue(':telefone', $dadosAtualizados['telefone']);
        $stmt->bindValue(':nome_substituto', $dadosAtualizados['nome_substituto']);
        $stmt->bindValue(':email', $dadosAtualizados['email']);
        $stmt->bindValue(':senha', $dadosAtualizados['senha']);
        $stmt->bindValue(':nome_social', $dadosAtualizados['nome_social']);

        if($stmt->execute()){
            $_SESSION['user']['setor'] = $dadosAtualizados['setor'];
            $_SESSION['user']['nome'] = $dadosAtualizados['nome'];
            $_SESSION['user']['telefone'] = $dadosAtualizados['telefone'];
            $_SESSION['user']['nome_substituto'] = $dadosAtualizados['nome_substituto'];
            $_SESSION['user']['email'] = $dadosAtualizados['email'];
            $_SESSION['user']['senha'] = $dadosAtualizados['senha'];
            $_SESSION['user']['nome_social'] = $dadosAtualizados['nome_social'];
            return true;
        }else{
            throw new Exception("Houve um erro ao realizar o Alteração!");
        }
    }

    public static function deletarConta($siape){
        $conn = ConnectionController::connectDb();
        $sql  =  "DELETE FROM usuario WHERE siape = :siape";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':siape', $siape);
        if($stmt->execute()){
            return true;
        }

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

}