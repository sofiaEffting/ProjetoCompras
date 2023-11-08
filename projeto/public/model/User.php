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

    
    public function atualizadDados($dadosPost) {
        // Conectar ao banco de dados
        $conn = ConnectionController::connectDb();
    
        
        $dadosPost['nome_substituto'] = $dadosPost['nome_substituto'] ?? null;
        $dadosPost['nome_social']     = $dadosPost['nome_social'] ?? null;

        // Preparar a consulta SQL
        $stmt = $conn->prepare('UPDATE usuario SET nome=:nome, email=:email, senha=:senha, telefone=:telefone WHERE id=:id');
    
        // Vincular os parâmetros à consulta SQL
        $stmt->bindValue(':siape', $dadosPost['siape']);
        $stmt->bindValue(':nivel_acesso', $dadosPost['nivel_acesso']);
        $stmt->bindValue(':setor', $dadosPost['setor']);
        $stmt->bindValue(':nome', $dadosPost['nome']);
        $stmt->bindValue(':telefone', $dadosPost['telefone']);
        $stmt->bindValue(':nome_substituto', $dadosPost['nome_substituto']);
        $stmt->bindValue(':email', $dadosPost['email']);
        $stmt->bindValue(':senha', $dadosPost['senha']);
        $stmt->bindValue(':nome_social', $dadosPost['nome_social']);
    
        // Executar a consulta SQL
        if ($stmt->execute()) {
            echo " Dados atualizados com sucesso";
            return true;
        } else {
            // Tratar erros de atualização
            echo "erro ao atualizar";
            return false;
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