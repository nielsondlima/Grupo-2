<?php
session_start();

// Conexão com o banco de dados
include_once('config/db.php');

// Verifica se a conexão está ativa
if (!isset($conn) || $conn->connect_error) {
    die('Erro na conexão com o banco de dados.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $senha = $_POST['senha'];

    // Verificar se o usuário existe no banco de dados
    $sql = "SELECT * FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verificar se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            $_SESSION['id'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario_id'];

            // Redirecionar conforme o tipo de usuário
            switch ($usuario['tipo_usuario_id']) {
                case 3: // Admin
                    header("Location: admin/admin_usuario.php");
                    exit;
                case 2: // Cliente
                    header("Location: cliente/meus-posts.php");
                    exit;
                case 1: // Prestador
                    header("Location: prestador/land-post.php");
                    exit;
                default:
                    echo "Erro: Tipo de usuário inválido.";
                    exit;
            }
        } else {
            echo "E-mail ou senha incorretos.";
        }
    } else {
        echo "E-mail não encontrado.";
    }

    $stmt->close();
} else {
    echo "Acesso inválido!";
}
$conn->close();
?>
