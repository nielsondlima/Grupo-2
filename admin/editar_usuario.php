<?php
include_once('../config/db.php'); // Inclui a conexão com MySQLi

// Verifique se a conexão foi realizada corretamente
if (!isset($conn)) {
    die('Erro: A variável $conn não foi definida. Verifique sua configuração.');
}

$mensagem = "";

// Verifique se o ID foi passado na URL
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Buscar os dados do usuário para preenchê-los no formulário de edição
    $query = "SELECT * FROM usuario WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        die("Usuário não encontrado.");
    }

    $stmt->close();
}

// Função para atualizar um usuário
if (isset($_POST['edit_user'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $tipo_usuario = $_POST['tipo_usuario'];

    try {
        // Atualizar a senha somente se for fornecida
        if (!empty($senha)) {
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
            $query = "UPDATE usuario SET nome = ?, email = ?, senha = ?, cpf = ?, tipo_usuario = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sssssi', $nome, $email, $senha_hashed, $cpf, $tipo_usuario, $id_usuario);
        } else {
            $query = "UPDATE usuario SET nome = ?, email = ?, cpf = ?, tipo_usuario = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ssssi', $nome, $email, $cpf, $tipo_usuario, $id_usuario);
        }

        if ($stmt->execute()) {
            // Redirecionar para a página de administração de usuários após a atualização
            header("Location: admin_usuario.php");
            exit(); // Certifique-se de parar a execução do script aqui após o redirecionamento
        } else {
            $mensagem = "Erro ao atualizar usuário: " . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
</head>
<body>
    <!-- Exibe a mensagem de sucesso ou erro -->
    <?php if (!empty($mensagem)): ?>
        <div class="mensagem">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>

    <h2>Editar Usuário</h2>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" value="<?php echo $usuario['senha']; ?> name="senha">

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" value="<?php echo $usuario['cpf']; ?>" required>

        <label for="tipo_usuario">Tipo de Usuário:</label>
        <select id="tipo_usuario" name="tipo_usuario">
            <option value="cliente" <?php echo ($usuario['tipo_usuario'] == 'cliente') ? 'selected' : ''; ?>>Cliente</option>
            <option value="prestador" <?php echo ($usuario['tipo_usuario'] == 'prestador') ? 'selected' : ''; ?>>Prestador</option>
            <option value="admin" <?php echo ($usuario['tipo_usuario'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
        </select>

        <button type="submit" name="edit_user">Atualizar Usuário</button>
    </form>
</body>
</html>

<?php
// Fechar a conexão após o uso
$conn->close();
?>
