<?php
// Conexão com o banco de dados
include_once('config/db.php');

// Verificar se a conexão com o banco está ativa
if (!isset($conn) || $conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Gerar hash da senha usando password_hash
$senha = 'senha_master';
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// SQL para inserir o administrador
$sql = "INSERT INTO usuario (nome, data_nasc, genero, nome_mae, cpf, senha, endereco, bairro, cidade, email, celular, tipo_usuario_id, especialidade) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Erro ao preparar o SQL: " . $conn->error);
}

$stmt->bind_param(
    'ssssssssssiss', 
    $nome, 
    $data_nasc, 
    $genero, 
    $nome_mae, 
    $cpf, 
    $senha_hash, 
    $endereco, 
    $bairro, 
    $cidade, 
    $email, 
    $celular, 
    $tipo_usuario_id, 
    $especialidade
);

// Dados do administrador
$nome = 'Administrador';
$data_nasc = '1980-01-01';
$genero = 'masculino';
$nome_mae = 'Maria da Silva';
$cpf = '000.000.000-00';
$endereco = 'Rua Exemplo, 123';
$bairro = 'Centro';
$cidade = 'Cidade Exemplo';
$email = 'admin@prolinker.com';
$celular = '11999999999';
$tipo_usuario_id = 3;
$especialidade = NULL;

// Executar a instrução
if ($stmt->execute()) {
    echo "Administrador inserido com sucesso!";
} else {
    echo "Erro ao inserir administrador: " . $stmt->error;
}

$stmt->close();
$conn->close(); // Fechar conexão somente aqui
?>
