<?php
// Iniciar a sessão no início do arquivo
session_start();

// Incluir a configuração de conexão com o banco de dados
include_once('config/db.php'); // Ajuste o caminho conforme necessário

// Verificar se a conexão com o banco de dados foi estabelecida
if (!isset($conn)) {
    die('A variável $conn não foi definida. Verifique sua configuração no arquivo db.php.');
}

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $nome = $_POST['input-1'];
    $data_nasc = $_POST['date'];
    $genero = $_POST['genero'];
    $nome_mae = $_POST['input-4'];
    $cpf = $_POST['input-5'];
    $senha = $_POST['input-6'];
    $confirm_senha = $_POST['input-6-5'];
    $cep = $_POST['cep'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $email = $_POST['input-8'];
    $celular = $_POST['cel'];  // Corrigido para pegar o campo celular do formulário
    $tipo_usuario = $_POST['tipo_usuario'];  // Captura o tipo de usuário selecionado
    $especialidade = isset($_POST['zona']) ? $_POST['zona'] : null;

    // Validar se as senhas são iguais
    if ($senha !== $confirm_senha) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Verificar se o CPF ou e-mail já existem no banco
    $sql_check = "SELECT * FROM usuario WHERE cpf = '$cpf' OR email = '$email'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "O CPF ou o e-mail já estão cadastrados!";
        exit;
    }

    // Verificar se o tipo de usuário selecionado existe na tabela tipos_usuario
    $sql_check_tipo = "SELECT * FROM tipos_usuario WHERE nome = '$tipo_usuario'";
    $result_check_tipo = $conn->query($sql_check_tipo);

    if ($result_check_tipo->num_rows == 0) {
        echo "Tipo de usuário inválido!";
        exit;
    }

    // Obter o ID do tipo de usuário
    $usuario_tipo = $result_check_tipo->fetch_assoc();
    $tipo_usuario_id = $usuario_tipo['id_tipo'];

    // Hash da senha
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Inserir o novo usuário no banco de dados
    $sql_insert = "INSERT INTO usuario (nome, data_nasc, genero, nome_mae, cpf, senha, endereco, bairro, cidade, email, celular, tipo_usuario_id, especialidade) 
                   VALUES ('$nome', '$data_nasc', '$genero', '$nome_mae', '$cpf', '$senha_hash', '$endereco', '$bairro', '$cidade', '$email', '$celular', '$tipo_usuario_id', '$especialidade')";

    if ($conn->query($sql_insert) === TRUE) {
        // Cadastro bem-sucedido, redireciona para a tela de login
        header('Location: login.php'); // Redireciona para o login
        exit;
    } else {
        echo "Erro ao cadastrar usuário: " . $conn->error;
    }
}
?>
