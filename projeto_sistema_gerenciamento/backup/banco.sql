-- Criação do banco de dados
CREATE DATABASE projeto;

-- Seleciona o banco para uso
USE projeto;

-- =========================
-- Tabela: ONG
-- =========================
CREATE TABLE ong (
    ong_id INT AUTO_INCREMENT PRIMARY KEY,
    ong_nome VARCHAR(150) NOT NULL,
    ong_cnpj VARCHAR(18) UNIQUE NOT NULL
);

-- =========================
-- Tabela: ADOTANTE
-- =========================
CREATE TABLE adotante (
    adot_id INT AUTO_INCREMENT PRIMARY KEY,
    adot_nome VARCHAR(150) NOT NULL,
    adot_telefone VARCHAR(20),
    adot_cpf VARCHAR(14) UNIQUE NOT NULL
);

-- =========================
-- Tabela: USUARIO (usuários do sistema, ex: administradores ou funcionários da ONG)
-- =========================
CREATE TABLE usuario (
    usu_id INT AUTO_INCREMENT PRIMARY KEY,
    usu_nome VARCHAR(150) NOT NULL,
    usu_email VARCHAR(150) UNIQUE NOT NULL,
    usu_senha VARCHAR(255) NOT NULL
);

-- =========================
-- Tabela: ANIMAL
-- =========================
CREATE TABLE animal (
    ani_id INT AUTO_INCREMENT PRIMARY KEY,
    especie VARCHAR(100) NOT NULL,
    raça VARCHAR(100) NOT NULL,
    nome VARCHAR(100),
    fase_vida VARCHAR(50),
    ong_id INT NOT NULL,
    adot_id INT NULL,
    FOREIGN KEY (ong_id) REFERENCES ong(ong_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (adot_id) REFERENCES adotante(adot_id) ON DELETE SET NULL ON UPDATE CASCADE
);
