<?php
session_start();
require '../config/db.php';

// Verificar se o usuário é admin
if ($_SESSION['tipo_usuario'] !== 'admin') {
    header("Location: acesso_negado.php");
    exit();
}

// Função para lidar com a adição de usuário
if (isset($_POST['add_user'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $query = "INSERT INTO usuario (nome, email, senha, cpf, tipo_usuario) VALUES (:nome, :email, :senha, :cpf, :tipo_usuario)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':tipo_usuario', $tipo_usuario);
    $stmt->execute();
    echo "Usuário adicionado com sucesso!";
}

// Função para alterar um usuário existente
if (isset($_POST['update_user'])) {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $query = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, cpf = :cpf, tipo_usuario = :tipo_usuario WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':tipo_usuario', $tipo_usuario);
    $stmt->execute();
    echo "Usuário atualizado com sucesso!";
}

// Função para excluir um usuário
if (isset($_POST['delete_user'])) {
    $id_usuario = $_POST['id_usuario'];

    $query = "DELETE FROM usuario WHERE id_usuario = :id_usuario";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    echo "Usuário excluído com sucesso!";
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

    <h2>Alterar Usuário</h2>
    <form method="POST">
        <label for="id_usuario">ID do Usuário:</label>
        <input type="text" id="id_usuario" name="id_usuario" required>
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
        <button type="submit" name="update_user">Alterar Usuário</button>
    </form>

    <h2>Excluir Usuário</h2>
    <form method="POST">
        <label for="id_usuario">ID do Usuário:</label>
        <input type="text" id="id_usuario" name="id_usuario" required>
        <button type="submit" name="delete_user">Excluir Usuário</button>
    </form>
</body>
</html>
