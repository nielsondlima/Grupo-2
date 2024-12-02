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
