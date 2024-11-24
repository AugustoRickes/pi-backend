CREATE DATABASE "NOPRECINHODB";

\c "NOPRECINHODB"

CREATE TABLE Produto (
    UUID UUID PRIMARY KEY,
    CODIGO VARCHAR(255),
    NOME VARCHAR(255),
    MARCA VARCHAR(255) NULL,
);

CREATE TABLE Usuario (
    UUID UUID PRIMARY KEY,
    NOME VARCHAR(255),
    CIDADE VARCHAR(255),
    ESTADO VARCHAR(255),
    TEM_CARRO BOOLEAN,
    KM_POR_LITRO FLOAT,
    CREDITOS INT
);

CREATE TABLE Estabelecimento (
    UUID UUID PRIMARY KEY,
    CNPJ VARCHAR(14) UNIQUE,
    RAZAO_SOCIAL VARCHAR(255),
    ENDERECO VARCHAR(255),
    CIDADE VARCHAR(255),
    ESTADO VARCHAR(255)
);

CREATE TABLE NotaFiscal (
    UUID UUID PRIMARY KEY,
    IDUSUARIO UUID REFERENCES Usuario(UUID),
    IDESTABELECIMENTO UUID REFERENCES Estabelecimento(UUID),
    DATAEMISSAO TIMESTAMP,
    VALORTOTAL NUMERIC(18, 2)
);

CREATE TABLE ItemNotaFiscal (
    UUID UUID PRIMARY KEY,
    IDNOTAFISCAL UUID REFERENCES NotaFiscal(UUID),
    IDPRODUTO UUID REFERENCES Produto(UUID),
    QUANTIDADE INT,
    VALORUNITARIO NUMERIC(18, 2),
    VALORTOTAL NUMERIC(18, 2)
);

CREATE TABLE Lista (
    UUID UUID PRIMARY KEY,
    IDPRODUTO UUID REFERENCES Produto(UUID),
    IDUSUARIO UUID REFERENCES Usuario(UUID),
    QUANTIDADE INT
);

CREATE TABLE ListaGerada (
    UUID UUID PRIMARY KEY,
    IDUSUARIO UUID REFERENCES Usuario(UUID),
    IDESTABELECIMENTO UUID REFERENCES Estabelecimento(UUID),
    DATAHORA TIMESTAMP
);

CREATE TABLE ItensListaGerada (
    UUID UUID PRIMARY KEY,
    IDLISTAGERADA UUID REFERENCES ListaGerada(UUID),
    IDPRODUTO UUID REFERENCES Produto(UUID),
    PRECO NUMERIC(18, 2),
    MEDIAMERCADO NUMERIC(18, 2),
    QUANTIDADE INT
);