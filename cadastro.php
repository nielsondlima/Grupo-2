<?php
// Iniciar a sessão no início do arquivo
session_start();

// Incluir a configuração de conexão com o banco de dados
include_once('config/db.php'); // Ajuste o caminho conforme necessário

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
    $cep = $conn->real_escape_string(trim($_POST['cep']));
    $endereco = $conn->real_escape_string(trim($_POST['endereco']));
    $bairro = $conn->real_escape_string(trim($_POST['bairro']));
    $cidade = $conn->real_escape_string(trim($_POST['cidade']));
    $email = $conn->real_escape_string(trim($_POST['input-8']));
    $celular = $conn->real_escape_string(trim($_POST['cel']));
    $tipo_usuario = $conn->real_escape_string(trim($_POST['tipo_usuario']));
    $especialidade = isset($_POST['zona']) ? $conn->real_escape_string(trim($_POST['zona'])) : null;

    // Validar se as senhas são iguais
    if ($senha !== $confirm_senha) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Verificar se o CPF ou e-mail já existem no banco
    $sql_check = "SELECT * FROM usuario WHERE cpf = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('ss', $cpf, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "O CPF ou o e-mail já estão cadastrados!";
        $stmt_check->close();
        exit;
    }
    $stmt_check->close();

    // Verificar se o tipo de usuário selecionado existe na tabela tipos_usuario
    $sql_check_tipo = "SELECT id_tipo FROM tipos_usuario WHERE descricao = ?";
    $stmt_check_tipo = $conn->prepare($sql_check_tipo);
    $stmt_check_tipo->bind_param('s', $tipo_usuario);
    $stmt_check_tipo->execute();
    $result_check_tipo = $stmt_check_tipo->get_result();

    if ($result_check_tipo->num_rows == 0) {
        echo "Tipo de usuário inválido!";
        $stmt_check_tipo->close();
        exit;
    }

    // Obter o ID do tipo de usuário
    $usuario_tipo = $result_check_tipo->fetch_assoc();
    $tipo_usuario_id = $usuario_tipo['id_tipo'];
    $stmt_check_tipo->close();

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
        // Cadastro bem-sucedido, redireciona para a tela de login
        header('Location: login.php');
        exit;
    } else {
        echo "Erro ao cadastrar usuário: " . $stmt_insert->error;
    }

    $stmt_insert->close();
    $conn->close();
} else {
    echo "Acesso inválido!";
}
?>
