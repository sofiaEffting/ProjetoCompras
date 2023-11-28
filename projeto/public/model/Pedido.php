<?php

use Database\ConnectionController;

class Pedido
{

    private $ano;
    private $campus;
    private $setor;
    private $servidor;
    private $siape;
    private $fiscal;
    private $telefone;
    private $email;
    private $lista_itens;
    private $justificativa;
    private $certificacao;
    private $docs_complementares;
    private $prioridade;
    private $data_desejada;
    private $vinculacao;
    private $almoxerifado;
    private $ciencia_direcao;
    private $autorizacao;
    private $local_arq;



    // Definição de uma função chamada todosPedidosIndiviguais
    public function todosPedidosIndiviguais($siape)
    {
        //var_dump($_SESSION['user']);
        $conn = ConnectionController::connectDb();
        $sql = "SELECT * FROM pedido_compra_individual WHERE siape_requisitante = :siape";
        if ($_SESSION['user']['nivel_acesso'] == '1') {
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":siape", $siape, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) {
                $result = $stmt->fetchAll();
                return $result;
            } else {
                return false;
            }
        }
    }



    public function cadastrarPedido($aDados)
    {
        $conn = ConnectionController::connectDb();

        $sql  =  "INSERT INTO pedido_compra_individual (siape_requisitante, valor_estimado_unidade, qtde, justificativa_necessidade, 
        justificativa_qtde, prioridade, data_compra, vinculacao, almoxarifado) 
        VALUES (:siape_requisitante, :valor_estimado, :qtde, :justificativa, :justificativa_qtde, :prioridade, :data_compra,
        :vinculacao, :almoxerifado );";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':siape_requisitante', $aDados['siape_requisitante']);
        $stmt->bindValue(':valor_estiado', $aDados['valor_estimado']);
        $stmt->bindValue(':qtde', $aDados['quantidade']);
        $stmt->bindValue(':justificativa', $aDados['justificativa']);
        $stmt->bindValue(':justificativa_qtde', $aDados['justificativa_qtde']);
        $stmt->bindValue(':prioridade', $aDados['prioridade']);
        $stmt->bindValue(':data_compra', $aDados['datacompra']);
        $stmt->bindValue(':vinculacao', $aDados['vinculacao']);
        $stmt->bindValue(':almoxerifado', $aDados['almoxerifado']);

        if ($stmt->execute()) {
            $pedido_id = $stmt->insert_id; //pegando o id do pedido
            $produtos = $aDados['produtos']; //separando um array somente com ids de produtos
            $qtde = count($produtos);

            for ($i = 0; $i < $qtde; $i++) {

                $sql2 = "INSERT INTO pedido_to_pedido_compra_ind (id_pci, id_produto) 
                VALUES ('$pedido_id','$produtos[$i]')";

                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute();
            }
            return true;
        } else {
            throw new Exception("Houve um erro ao realizar o cadastro!");
        }
    }

    public function setLocalDoArquivo($local_arq)
    {
        $this->local_arq = $local_arq;
    }

    public function getLocalDoArquivo()
    {
        return $this->local_arq;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function setServidor($servidor)
    {
        $this->servidor = $servidor;
    }

    public function getServidor()
    {
        return $this->servidor;
    }

    public function setCampus($campus)
    {
        $this->campus = $campus;
    }

    public function getCampus()
    {
        return $this->campus;
    }

    public function setSetor($setor)
    {
        $this->setor = $setor;
    }

    public function getSetor()
    {
        return $this->setor;
    }

    public function setSiape($siape)
    {
        $this->siape = $siape;
    }

    public function getSiape()
    {
        return $this->siape;
    }

    public function setFiscal($fiscal)
    {
        $this->fiscal = $fiscal;
    }

    public function getFiscal()
    {
        return $this->fiscal;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setLista($lista_itens)
    {
        $this->lista_itens = $lista_itens;
    }

    public function getLista()
    {
        return $this->lista_itens;
    }

    public function setJustificativa($justificativa)
    {
        $this->justificativa = $justificativa;
    }

    public function getJustificativa()
    {
        return $this->justificativa;
    }

    public function setCertificacao($certificacao)
    {
        $this->certificacao = $certificacao;
    }

    public function getCertificacao()
    {
        return $this->certificacao;
    }

    public function setDocsComplementares($docs_complementares)
    {
        $this->docs_complementares = $docs_complementares;
    }

    public function getDocsComplementares()
    {
        return $this->docs_complementares;
    }

    public function setPrioridade($prioridade)
    {
        $this->prioridade = $prioridade;
    }

    public function getPrioridade()
    {
        return $this->prioridade;
    }

    public function setDataDesejada($data_desejada)
    {
        $this->data_desejada = $data_desejada;
    }

    public function getDataDesejada()
    {
        return $this->data_desejada;
    }

    public function setVinculacao($vinculacao)
    {
        $this->vinculacao = $vinculacao;
    }

    public function getVinculacao()
    {
        return $this->vinculacao;
    }

    public function setAlmoxerifado($almoxerifado)
    {
        $this->almoxerifado = $almoxerifado;
    }

    public function getAlmoxerifado()
    {
        return $this->almoxerifado;
    }

    public function setCienciaDirecao($ciencia_direcao)
    {
        $this->ciencia_direcao = $ciencia_direcao;
    }

    public function getCienciaDirecao()
    {
        return $this->ciencia_direcao;
    }

    public function setAutorizacao($autorizacao)
    {
        $this->autorizacao = $autorizacao;
    }

    public function getAutorizacao()
    {
        return $this->autorizacao;
    }
}
