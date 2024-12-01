<?php
session_start(); // Inicia a sessão
session_start();
include_once('../config/db.php'); // Inclui a conexão com MySQLi

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: acesso_negado.php");
}

// Verifique se a conexão foi realizada corretamente
if (!isset($conn)) {
    die('Erro: A variável $conn não foi definida. Verifique sua configuração.');
}

$mensagem = "";

// Função para adicionar um novo usuário
if (isset($_POST['add_user'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $tipo_usuario = $_POST['tipo_usuario'];

    try {
        // Hash da senha
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

        // Inserir dados no banco
        $query = "INSERT INTO usuario (nome, email, senha, cpf, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssss', $nome, $email, $senha_hashed, $cpf, $tipo_usuario);

        if ($stmt->execute()) {
            $mensagem = "Usuário adicionado com sucesso!";
        } else {
            $mensagem = "Erro ao adicionar usuário: " . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}

// Função para excluir um usuário
if (isset($_POST['delete_user'])) {
    $id_usuario = $_POST['id'];

    try {
        $query = "DELETE FROM usuario WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            $mensagem = "Usuário excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir usuário: " . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}

// Função para logout
if (isset($_POST['logout'])) {
    session_destroy(); // Destroi a sessão
    header("Location: /Grupo-2/index.php");
    exit();
    
}

// Buscar os usuários para exibir na tabela
$query = "SELECT * FROM usuario";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Usuários - ProLinker</title>
</head>
<body>
    <!-- Botão de logout -->
    <form method="POST" style="text-align: right;">
        <button type="submit" name="logout">Logout</button>
    </form>

    
   
    <h2>Adicionar Usuário</h2>
    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>

        <label for="tipo_usuario">Tipo de Usuário:</label>
        <select id="tipo_usuario" name="tipo_usuario">
            <option value="cliente">Cliente</option>
            <option value="prestador">Prestador</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit" name="add_user">Adicionar Usuário</button>
    </form>

    <h2>Usuários Cadastrados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>CPF</th>
                <th>Tipo de Usuário</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Verifica se há usuários cadastrados e exibe
            if ($result->num_rows > 0) {
                while ($usuario = $result->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nome']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['cpf']; ?></td>
                    <td><?php echo $usuario['tipo_usuario']; ?></td>
                    <td>
                        <!-- Formulário para excluir usuário -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <button type="submit" name="delete_user">Excluir</button>
                        </form>

                        <!-- Redirecionar para a página de edição -->
                        <form method="GET" action="editar_usuario.php" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                            <button type="submit">Editar</button>
                        </form>
                    </td>
                </tr>
            <?php
                endwhile;
            } else {
                echo "<tr><td colspan='6'>Nenhum usuário encontrado</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Fechar a conexão após o uso
$conn->close();
?>
