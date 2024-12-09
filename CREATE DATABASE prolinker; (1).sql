-- Criar o banco de dados
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

-- Tabela de categorias
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL
);

-- Inserir categorias
INSERT INTO categorias (nome) VALUES 
('Manutenção e Reformas'),
('Tecnologia'),
('Saúde'),
('Marketing'),
('Produção'),
('Fotografia'),
('Tradução'),
('Educação'),
('Artes Visuais'),
('Administração');

-- Tabela de posts
CREATE TABLE posts (
    id_post INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    categoria INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (user_id) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

-- Tabela de log de autenticação
CREATE TABLE log (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    data_hora DATETIME NOT NULL,
    evento TEXT NOT NULL,
    tipo_evento VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

-- Tabela para autenticação de dois fatores
CREATE TABLE autenticacao_2fa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    codigo VARCHAR(6) NOT NULL,
    expira_em DATETIME NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

-- Inserir administrador padrão
INSERT INTO usuario (nome, data_nasc, genero, nome_mae, cpf, senha, endereco, bairro, cidade, email, celular, tipo_usuario_id)
VALUES (
    'Administrador Master', -- Nome
    '1970-01-01',           -- Data de nascimento
    'masculino',            -- Gênero
    'Maria da Silva',       -- Nome da mãe
    '000.000.000-00',       -- CPF
    PASSWORD('senha123'),   -- Senha (criptografada com função do MySQL)
    'Rua Principal, 123',   -- Endereço
    'Centro',               -- Bairro
    'Cidade Exemplo',       -- Cidade
    'admin@prolinker.com',  -- E-mail
    '11999999999',          -- Celular
    3                       -- Tipo de usuário (Admin)
);

-- Inserir logs iniciais para teste
INSERT INTO log (user_id, data_hora, evento, tipo_evento)
VALUES 
(1, NOW(), 'Usuário ID 2 criado.', 'criação'),
(1, NOW(), 'Login bem-sucedido.', 'login');
