DROP DATABASE IF EXISTS projeto;
CREATE DATABASE projeto
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE projeto;

CREATE TABLE ong (
    ong_id INT AUTO_INCREMENT PRIMARY KEY,
    ong_nome VARCHAR(150) NOT NULL,
    ong_cnpj VARCHAR(18) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE adotante (
    adot_id INT AUTO_INCREMENT PRIMARY KEY,
    adot_nome VARCHAR(150) NOT NULL,
    adot_telefone VARCHAR(20),
    adot_cpf VARCHAR(14) UNIQUE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE usuario (
    usu_id INT AUTO_INCREMENT PRIMARY KEY,
    usu_nome VARCHAR(150) NOT NULL,
    usu_email VARCHAR(150) UNIQUE NOT NULL,
    usu_senha VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE animal (
    ani_id INT AUTO_INCREMENT PRIMARY KEY,
    especie VARCHAR(100) NOT NULL,
    raça VARCHAR(100) NOT NULL,
    nome VARCHAR(100),
    fase_vida VARCHAR(50),
    sexo VARCHAR(10),      
    ong_id INT NOT NULL,
    adot_id INT NULL,
    CONSTRAINT fk_animal_ong
      FOREIGN KEY (ong_id) REFERENCES ong(ong_id)
      ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_animal_adotante
      FOREIGN KEY (adot_id) REFERENCES adotante(adot_id)
      ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE adocao (
    ado_id INT AUTO_INCREMENT PRIMARY KEY,
    ani_id INT NOT NULL,
    adot_id INT NOT NULL,
    ong_id INT NOT NULL,
    data_adocao DATE NOT NULL,
    CONSTRAINT fk_adocao_animal
      FOREIGN KEY (ani_id)  REFERENCES animal(ani_id),
    CONSTRAINT fk_adocao_adotante
      FOREIGN KEY (adot_id) REFERENCES adotante(adot_id),
    CONSTRAINT fk_adocao_ong
      FOREIGN KEY (ong_id)  REFERENCES ong(ong_id)
) ENGINE=InnoDB;


INSERT INTO ong (ong_nome, ong_cnpj) VALUES
('Patinhas Felizes',        '12.345.678/0001-90'),
('Amigos dos Bichos',       '23.456.789/0001-01'),
('SOS Gatinhos',            '34.567.890/0001-12');

INSERT INTO adotante (adot_nome, adot_telefone, adot_cpf) VALUES
('Ana Silva',        '(11) 98888-1111', '111.111.111-11'),
('Bruno Costa',      '(11) 97777-2222', '222.222.222-22'),
('Carla Oliveira',   '(11) 96666-3333', '333.333.333-33'),
('Diego Santos',     '(11) 95555-4444', '444.444.444-44'),
('Eduardo Pereira',  '(11) 94444-5555', '555.555.555-55');

INSERT INTO animal (especie, `raça`, nome, fase_vida, sexo, ong_id, adot_id) VALUES
('Cachorro', 'SRD',              'Bolt',   'Filhote', 'Macho',  1, 1), 
('Gato',     'Siamês',           'Luna',   'Adulto',  'Fêmea',  3, 2),  
('Cachorro', 'Poodle',           'Nina',   'Adulto',  'Fêmea',  2, NULL),
('Gato',     'Persa',            'Mingau', 'Filhote', 'Macho',  3, NULL),
('Cachorro', 'Golden Retriever', 'Thor',   'Adulto',  'Macho',  1, 3),  
('Gato',     'SRD',              'Mel',    'Adulto',  'Fêmea',  2, NULL),
('Cachorro', 'Beagle',           'Scooby', 'Idoso',   'Macho',  1, NULL),
('Outro',    'Coelho',           'Pipoca', 'Filhote', 'Fêmea',  2, 4);  

INSERT INTO adocao (ani_id, adot_id, ong_id, data_adocao) VALUES
(1, 1, 1, '2025-01-10'), 
(2, 2, 3, '2025-02-05'), 
(5, 3, 1, '2025-02-20'),  
(8, 4, 2, '2025-03-01'); 