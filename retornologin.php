<?php
session_start(); // Inicia a sessão

// Incluir a configuração de conexão com o banco de dados
include_once('config/db.php');

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Receber e limpar os valores do formulário
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Verificar se os campos foram preenchidos
    if (empty($email) || empty($senha)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); window.history.back();</script>";
        exit();
    }

    // Preparar consulta para verificar o e-mail
    $sql = "SELECT id_usuario, nome, senha, tipo_usuario_id FROM usuario WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar se o e-mail foi encontrado
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();

            // Verificar a senha
            if (password_verify($senha, $usuario['senha'])) {
                // Armazenar informações do usuário na sessão
                $_SESSION['id'] = $usuario['id_usuario'];
                $_SESSION['nome'] = $usuario['nome'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario_id'];

                // Redirecionar com base no tipo de usuário
                switch ($usuario['tipo_usuario_id']) {
                    case 1: // Cliente
                        header("Location: /visitante/cliente/index_cliente.php");
                        break;
                    case 2: // Prestador
                        header("Location: /visitante/prestador/index_prestador.php");
                        break;
                    case 3: // Admin
                        header("Location: /visitante/admin/index_admin.php");
                        break;
                    default:
                        echo "<script>alert('Tipo de usuário inválido!'); window.history.back();</script>";
                        exit();
                }
                exit();
            } else {
                // Senha incorreta
                echo "<script>alert('Senha incorreta!'); window.history.back();</script>";
                exit();
            }
        } else {
            // E-mail não encontrado
            echo "<script>alert('E-mail não encontrado!'); window.history.back();</script>";
            exit();
        }

        $stmt->close();
    } else {
        echo "<script>alert('Erro no sistema. Tente novamente mais tarde.'); window.history.back();</script>";
        exit();
    }
} else {
    // Acesso direto ao arquivo sem ser via POST
    echo "<script>alert('Acesso inválido!'); window.location.href = 'login.php';</script>";
    exit();
}

$conn->close();
?>
