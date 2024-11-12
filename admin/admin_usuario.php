<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: acesso_negado.php");
    exit();
}

$mensagem = "";

// Função para lidar com a adição de usuário
if (isset($_POST['add_user'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $tipo_usuario = $_POST['tipo_usuario'];

    try {
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
        $query = "INSERT INTO usuario (nome, email, senha, cpf, tipo_usuario) VALUES (:nome, :email, :senha, :cpf, :tipo_usuario)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hashed);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':tipo_usuario', $tipo_usuario);
        $stmt->execute();
        $mensagem = "Usuário adicionado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}

// Função para alterar um usuário existente
if (isset($_POST['update_user'])) {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $tipo_usuario = $_POST['tipo_usuario'];

    try {
        $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);
        $query = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, cpf = :cpf, tipo_usuario = :tipo_usuario WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hashed);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':tipo_usuario', $tipo_usuario);
        $stmt->execute();
        $mensagem = "Usuário atualizado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}

// Função para excluir um usuário
if (isset($_POST['delete_user'])) {
    $id_usuario = $_POST['id_usuario'];

    try {
        $query = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $mensagem = "Usuário excluído com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Usuários - ProLinker</title>
</head>
<body>
    <?php if (!empty($mensagem)): ?>
        <div class="mensagem">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>

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

    <!-- Formulários de Alteração e Exclusão permanecem os mesmos -->
</body>
</html>

