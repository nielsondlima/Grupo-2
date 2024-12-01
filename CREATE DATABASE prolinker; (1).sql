CREATE DATABASE prolinker;
USE prolinker;

-- Tabela de tipos de usuário
CREATE TABLE tipos_usuario (
    id_tipo INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(50) NOT NULL
);

-- Inserção de tipos de usuário
INSERT INTO tipos_usuario (descricao) VALUES ('cliente'), ('prestador'), ('admin');

-- Tabela de usuários
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    data_nasc DATE NOT NULL,
    genero ENUM('masculino', 'feminino') NOT NULL,
    nome_mae VARCHAR(255) NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    celular VARCHAR(15) NOT NULL,
    tipo_usuario_id INT NOT NULL,
    especialidade VARCHAR(255),
    FOREIGN KEY (tipo_usuario_id) REFERENCES tipos_usuario(id_tipo)
);


-- Tabela de posts
CREATE TABLE posts (
    id_post INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuario(id_usuario)
);

-- Tabela de log de autenticação
CREATE TABLE log (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    data_hora DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuario(id_usuario)
);



