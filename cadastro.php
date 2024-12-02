<?php
// Iniciar a sessão no início do arquivo
session_start();

// Incluir a configuração de conexão com o banco de dados
include_once('config/db.php');

// Verificar se a conexão com o banco de dados foi estabelecida
if (!isset($conn) || $conn->connect_error) {
    die('Erro na conexão com o banco de dados: ' . $conn->connect_error);
}

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário e realizar a sanitização
    $nome = $conn->real_escape_string(trim($_POST['input-1']));
    $data_nasc = $conn->real_escape_string(trim($_POST['date']));
    $genero = $conn->real_escape_string(trim($_POST['genero']));
    $nome_mae = $conn->real_escape_string(trim($_POST['input-4']));
    $cpf = $conn->real_escape_string(trim($_POST['input-5']));
    $senha = trim($_POST['input-6']);
    $confirm_senha = trim($_POST['input-6-5']);
    $endereco = $conn->real_escape_string(trim($_POST['endereco']));
    $bairro = $conn->real_escape_string(trim($_POST['bairro']));
    $cidade = $conn->real_escape_string(trim($_POST['cidade']));
    $email = $conn->real_escape_string(trim($_POST['input-8']));
    $celular = $conn->real_escape_string(trim($_POST['cel']));
    $tipo_usuario = $conn->real_escape_string(trim($_POST['tipo_usuario']));
    $especialidade = isset($_POST['zona']) ? $conn->real_escape_string(trim($_POST['zona'])) : null;

    // Validar se as senhas são iguais
    if ($senha !== $confirm_senha) {
        echo "<script>alert('As senhas não coincidem!'); window.history.back();</script>";
        exit;
    }

    // Verificar se o CPF ou e-mail já existem no banco
    $sql_check = "SELECT * FROM usuario WHERE cpf = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('ss', $cpf, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>alert('O CPF ou o e-mail já estão cadastrados!'); window.history.back();</script>";
        $stmt_check->close();
        exit;
    }
    $stmt_check->close();

    // Definir o tipo de usuário com base na escolha e validação
    if ($tipo_usuario === 'cliente') {
        $tipo_usuario_id = 1; // Cliente
        $especialidade = null; // Cliente não tem especialidade
    } elseif ($tipo_usuario === 'prestador') {
        if (empty($especialidade)) {
            echo "<script>alert('Prestadores devem ter uma especialidade!'); window.history.back();</script>";
            exit;
        }
        $tipo_usuario_id = 2; // Prestador
    } else {
        echo "<script>alert('Tipo de usuário inválido!'); window.history.back();</script>";
        exit;
    }

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir o novo usuário no banco de dados
    $sql_insert = "INSERT INTO usuario (nome, data_nasc, genero, nome_mae, cpf, senha, endereco, bairro, cidade, email, celular, tipo_usuario_id, especialidade) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);

    if (!$stmt_insert) {
        die("Erro ao preparar SQL: " . $conn->error);
    }

    $stmt_insert->bind_param(
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

    if ($stmt_insert->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href = 'login.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar usuário. Tente novamente mais tarde.');</script>";
    }

    $stmt_insert->close();
    $conn->close();
} else {
    echo "<script>alert('Acesso inválido!'); window.location.href = 'index.php';</script>";
}
?>
