CREATE DATABASE compras;

USE compras;

CREATE TABLE prazo(
	id SERIAL PRIMARY KEY,
	prazo DATE
);

CREATE TABLE NivelAcesso(
	id INT PRIMARY KEY,
    tipo VARCHAR(50)
);

CREATE TABLE categoria(
	nome_categoria VARCHAR(255) PRIMARY KEY
);

CREATE TABLE usuario(
	siape VARCHAR(10) PRIMARY KEY,
	nivel_acesso INT,
	setor VARCHAR(255),
	nome VARCHAR(150),
	telefone VARCHAR(12),
	nome_substituto VARCHAR(255) NULL,
	email VARCHAR(255) UNIQUE,
	senha VARCHAR(255),
	FOREIGN KEY(nivel_acesso) REFERENCES nivelacesso(id)
);

CREATE TABLE produto(
	sipac INT PRIMARY KEY,
	prod_categoria VARCHAR(255),
	catmat_catser INT,
	natureza_despesa VARCHAR(255),
	descricao TEXT,
	item_pe VARCHAR(255),
	unidade_medida VARCHAR(255),
	FOREIGN KEY (prod_categoria) REFERENCES categoria(nome_categoria)
);

CREATE TABLE pedido_compra_individual(
		id BIGINT auto_increment PRIMARY KEY,
    	siape_requisitante VARCHAR(255),
    	valor_estimado_unidade FLOAT,
    	qtde INT,
    	justificativa_necessidade TEXT,
    	justificativa_qtde TEXT,
    	prioridade INT,
    	data_compra VARCHAR(255),
		vinculacao VARCHAR(255),
		almoxarifado VARCHAR(255),
    	ciencia VARCHAR(255),
    	atorizacao VARCHAR(255),
    	FOREIGN KEY(siape_requisitante) REFERENCES usuario(siape)
);

CREATE TABLE pedidofinal(
		id BIGINT auto_increment PRIMARY KEY,
    	siape_requisitante VARCHAR(255),
    	habilitacao_especifica TEXT,
    	dotacao_orcamentaria TEXT,
    	FOREIGN KEY (siape_requisitante) REFERENCES usuario(siape)
);

CREATE TABLE pedido_to_pedido_compra_ind(
	id SERIAL,
    id_pci BIGINT,
    id_produto INT,
    FOREIGN KEY (id_pci) REFERENCES pedido_compra_individual(id),
    FOREIGN KEY (id_produto) REFERENCES produto(sipac)
);

CREATE TABLE pedidofinal_pedidoindiv(
	id SERIAL PRIMARY KEY,
	id_pedidofinal BIGINT,
    id_pedidoindividual BIGINT,
    FOREIGN KEY (id_pedidofinal) REFERENCES pedidofinal(id),
    FOREIGN KEY(id_pedidoindividual) REFERENCES pedido_compra_individual(id)
);