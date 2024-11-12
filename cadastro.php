<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitização de dados de entrada
    $nome = htmlspecialchars($_POST['input-1']);
    $data_nasc = htmlspecialchars($_POST['date']);
    $genero = htmlspecialchars($_POST['genero']);
    $nome_mae = htmlspecialchars($_POST['input-4']);
    $cpf = htmlspecialchars($_POST['input-5']);
    $senha = password_hash($_POST['input-6'], PASSWORD_BCRYPT);
    $cep = htmlspecialchars($_POST['cep']);
    $endereco = htmlspecialchars($_POST['endereco']);
    $bairro = htmlspecialchars($_POST['bairro']);
    $cidade = htmlspecialchars($_POST['cidade']);
    $email = htmlspecialchars($_POST['input-8']);
    $celular = htmlspecialchars($_POST['cel']);
    $tipo_usuario = htmlspecialchars($_POST['tipo_usuario']);
    $especialidade = isset($_POST['zona']) ? htmlspecialchars($_POST['zona']) : NULL;

    // Uso de prepared statement
    $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, endereco, especialidade, data_nasc, genero, cpf, cidade, bairro, nome_mae, tipo_usuario)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $nome, $email, $senha, $endereco, $especialidade, $data_nasc, $genero, $cpf, $cidade, $bairro, $nome_mae, $tipo_usuario);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>