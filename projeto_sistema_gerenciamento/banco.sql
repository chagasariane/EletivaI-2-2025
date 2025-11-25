-- Criação do banco de dados
DROP DATABASE IF EXISTS projeto;
CREATE DATABASE projeto
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE projeto;

-- =========================
-- Tabela: ONG
-- =========================
CREATE TABLE ong (
    ong_id   INT AUTO_INCREMENT PRIMARY KEY,
    ong_nome VARCHAR(150) NOT NULL,
    ong_cnpj VARCHAR(18) UNIQUE NOT NULL
) ENGINE=InnoDB;

-- =========================
-- Tabela: ADOTANTE
-- =========================
CREATE TABLE adotante (
    adot_id       INT AUTO_INCREMENT PRIMARY KEY,
    adot_nome     VARCHAR(150) NOT NULL,
    adot_telefone VARCHAR(20),
    adot_cpf      VARCHAR(14) UNIQUE NOT NULL
) ENGINE=InnoDB;

-- =========================
-- Tabela: USUARIO
-- =========================
CREATE TABLE usuario (
    usu_id    INT AUTO_INCREMENT PRIMARY KEY,
    usu_nome  VARCHAR(150) NOT NULL,
    usu_email VARCHAR(150) UNIQUE NOT NULL,
    usu_senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- =========================
-- Tabela: ANIMAL
-- =========================
CREATE TABLE animal (
    ani_id    INT AUTO_INCREMENT PRIMARY KEY,
    especie   VARCHAR(100) NOT NULL,
    `raça`    VARCHAR(100) NOT NULL,
    nome      VARCHAR(100),
    fase_vida VARCHAR(50),
    sexo      VARCHAR(10),          -- <-- adicionada
    ong_id    INT NOT NULL,
    adot_id   INT NULL,
    CONSTRAINT fk_animal_ong
      FOREIGN KEY (ong_id) REFERENCES ong(ong_id)
      ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_animal_adotante
      FOREIGN KEY (adot_id) REFERENCES adotante(adot_id)
      ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Tabela: ADOCAO
-- =========================
CREATE TABLE adocao (
    ado_id      INT AUTO_INCREMENT PRIMARY KEY,
    ani_id      INT NOT NULL,
    adot_id     INT NOT NULL,
    ong_id      INT NOT NULL,
    data_adocao DATE NOT NULL,
    CONSTRAINT fk_adocao_animal
      FOREIGN KEY (ani_id)  REFERENCES animal(ani_id),
    CONSTRAINT fk_adocao_adotante
      FOREIGN KEY (adot_id) REFERENCES adotante(adot_id),
    CONSTRAINT fk_adocao_ong
      FOREIGN KEY (ong_id)  REFERENCES ong(ong_id)
) ENGINE=InnoDB;
