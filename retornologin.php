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

    // Verificar se os campos de email e senha não estão vazios
    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else {

        // Obter os valores do formulário e limpar contra SQL Injection
        $email = $conn->real_escape_string($_POST['email']);
        $senha = $_POST['senha'];

        // Consultar o banco de dados para verificar se o email existe
        $sql_code = "SELECT * FROM usuario WHERE email = '$email'";
        $sql_query = $conn->query($sql_code);

        if (!$sql_query) {
            die("Falha na execução do código SQL: " . $conn->error);
        }

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            // Verificar se a senha fornecida corresponde ao hash armazenado
            if (password_verify($senha, $usuario['senha'])) {

                // Armazenar os dados do usuário na sessão
                $_SESSION['id'] = $usuario['id_usuario'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario_id']; // Armazenar o tipo de usuário (ID)

                // Redirecionar conforme o tipo de usuário
                if ($usuario['tipo_usuario_id'] == 3) {
                    header("Location: admin/admin_usuario.php");
                    exit;
                } else if ($usuario['tipo_usuario_id'] == 2) {
                    header("Location: cliente/meus-posts.php");
                    exit;
                } else if ($usuario['tipo_usuario_id'] == 1) {
                    header("Location: prestador/land-post.php");
                    exit;
                } else {
                    echo "Falha ao logar! Tipo de usuário inválido.";
                }

            } else {
                echo "Falha ao logar! E-mail ou senha incorretos.";
            }

        } else {
            echo "Falha ao logar! E-mail não encontrado.";
        }
    }

} else {
    // Se não for um POST, exibe a mensagem para enviar o formulário.
    echo "Por favor, envie o formulário.";
}
?>
