<?php

use Database\ConnectionController;

class Pedido{

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

    public function setAno($ano){
        $this->ano = $ano;
    }

    public function getAno (){
        return $this->ano;
    }

    public function setServidor($servidor){
        $this->servidor = $servidor;
    }

    public function getServidor (){
        return $this->servidor;
    }

    public function setCampus($campus){
        $this->campus = $campus;
    }

    public function getCampus (){
        return $this->campus;
    }

    public function setSetor($setor){
        $this->setor = $setor;
    }

    public function getSetor (){
        return $this->setor;
    }

    public function setSiape($siape){
        $this->siape = $siape;
    }

    public function getSiape (){
        return $this->siape;
    }

    public function setFiscal($fiscal){
        $this->fiscal = $fiscal;
    }

    public function getFiscal (){
        return $this->fiscal;
    }

    public function setTelefone($telefone){
        $this->telefone = $telefone;
    }

    public function getTelefone (){
        return $this->telefone;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail (){
        return $this->email;
    }

    public function setLista($lista_itens){
        $this->lista_itens = $lista_itens;
    }

    public function getLista (){
        return $this->lista_itens;
    }

    public function setJustificativa($justificativa){
        $this->justificativa = $justificativa;
    }

    public function getJustificativa (){
        return $this->justificativa;
    }

    public function setCertificacao($certificacao){
        $this->certificacao = $certificacao;
    }

    public function getCertificacao (){
        return $this->certificacao;
    }

    public function setDocsComplementares($docs_complementares){
        $this->docs_complementares = $docs_complementares;
    }

    public function getDocsComplementares (){
        return $this->docs_complementares;
    }

    public function setPrioridade($prioridade){
        $this->prioridade = $prioridade;
    }

    public function getPrioridade (){
        return $this->prioridade;
    }

    public function setDataDesejada($data_desejada){
        $this->data_desejada = $data_desejada;
    }

    public function getDataDesejada (){
        return $this->data_desejada;
    }

    public function setVinculacao($vinculacao){
        $this->vinculacao = $vinculacao;
    }

    public function getVinculacao (){
        return $this->vinculacao;
    }

    public function setAlmoxerifado($almoxerifado){
        $this->almoxerifado = $almoxerifado;
    }

    public function getAlmoxerifado (){
        return $this->almoxerifado;
    }

    public function setCienciaDirecao($ciencia_direcao){
        $this->ciencia_direcao = $ciencia_direcao;
    }

    public function getCienciaDirecao (){
        return $this->ciencia_direcao;
    }

    public function setAutorizacao($autorizacao){
        $this->autorizacao = $autorizacao;
    }

    public function getAutorizacao (){
        return $this->autorizacao;
    }
}




