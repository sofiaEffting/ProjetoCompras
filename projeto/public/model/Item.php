<?php

use Database\ConnectionController;

class Item{
    private $sipac;
    private $prod_categoria;
    private $catmat_catser;
    private $natureza_despesa;
    private $descricao;
    private $item_pe;
    private $unidade_medida;

    public function getItens()
    {
        $conn = ConnectionController::connectDb();

        $sql = "SELECT * FROM produto";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount())
        {
            $result = $stmt->fetchAll();
            return $result;

        } else {
            return false;
        }

    }

    public static function cadastrarItem($dadosPost)
    {
        if (
            empty($dadosPost['sipac']) or empty($dadosPost['prod_categoria'])
            or empty($dadosPost['catmat_catser']) or empty($dadosPost['natureza_despesa'])
            or empty($dadosPost['descricao']) or empty($dadosPost['item_pe'])
            or empty($dadosPost['unidade_medida'])
        ) {
            throw new Exception("Preencha todos os campos");

            return false;
        }

        $conn = ConnectionController::connectDb();
    
        $sql = "INSERT INTO produto (sipac, prod_categoria, catmat_catser, natureza_despesa, descricao, item_pe, unidade_medida) 
        VALUES (:sipac, :prod_categoria, :catmat_catser, :natureza_despesa, :descricao, :item_pe, :unidade_medida)";
        $sql = $conn->prepare($sql);
        //coloca os dados que veio como parametro no campo dadoPost['nome']
        $sql->bindValue(":sipac", $dadosPost['sipac']);
        $sql->bindValue(":prod_categoria", $dadosPost['prod_categoria']);
        $sql->bindValue(":catmat_catser", $dadosPost['catmat_catser']);
        $sql->bindValue(":natureza_despesa", $dadosPost['natureza_despesa']);
        $sql->bindValue(":descricao", $dadosPost['descricao']);
        $sql->bindValue(":item_pe", $dadosPost['item_pe']);
        $sql->bindValue(":unidade_medida", $dadosPost['unidade_medida']);
        $res = $sql->execute();

        if ($res == 0) {
            throw new Exception("falha ao inserir a publicação");
            return false;
        } else {
            return true;
        }
    }

    //Getters e Setters
    public function setSipac($sipac)
    {
        $this->sipac = $sipac;
    }
    public function setProd_categoria($prod_categoria)
    {
        $this->prod_categoria = $prod_categoria;
    }
    public function setCatmat_catser($catmat_catser)
    {
        $this->catmat_catser = $catmat_catser;
    }
    public function setNatureza_despesa($natureza_despesa)
    {
        $this->natureza_despesa = $natureza_despesa;
    }
    public function setDscricao($descricao)
    {
        $this->descricao = $descricao;
    }
    public function setItem_pe($item_pe)
    {
        $this->item_pe = $item_pe;
    }
    public function setUnidade_medida($unidade_medida)
    {
        $this->unidade_medida = $unidade_medida;
    }


    public function getSipac()
    {
        return $this->sipac;
    }
    public function getProd_categoria()
    {
        return $this->prod_categoria;
    }
    public function getCatmat_catser()
    {
        return $this->catmat_catser;
    }
    public function getNatureza_despesa()
    {
        return $this->natureza_despesa;
    }
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function getItem_pe()
    {
        return $this->item_pe;
    }
    public function getUnidade_medida()
    {
        return $this->unidade_medida;
    }

}