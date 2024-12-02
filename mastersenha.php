<?php
// Conectar ao banco
include_once('config/db.php');

// Atualizar a senha do usuário admin
$nova_senha = password_hash('senha123', PASSWORD_DEFAULT); // Hash seguro
$sql_update = "UPDATE usuario SET senha = ? WHERE email = 'admin@prolinker.com'";
$stmt = $conn->prepare($sql_update);
$stmt->bind_param('s', $nova_senha);

if ($stmt->execute()) {
    echo "Senha do administrador atualizada com sucesso!";
} else {
    echo "Erro ao atualizar a senha: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
