CREATE DATABASE indicacao_imoveis;

USE indicacao_imoveis;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(191) NOT NULL UNIQUE,
    departamento VARCHAR(191) NOT NULL,
    email VARCHAR(191) NOT NULL UNIQUE,
    senha VARCHAR(191) NOT NULL,
    nivel VARCHAR(50) NOT NULL,
    reset_token VARCHAR(191) DEFAULT NULL,
    reset_expires DATETIME DEFAULT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE imoveis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    nome_proprietario VARCHAR(191) NOT NULL,
    contato_proprietario VARCHAR(191) NOT NULL,
    endereco_imovel VARCHAR(191) NOT NULL UNIQUE,
    status VARCHAR(100) DEFAULT 'Indicado',
    data_indicacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);