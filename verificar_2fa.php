<?php
session_start();
include_once('config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $codigo_informado = trim($_POST['codigo']);

    // Validar código 2FA
    $sql_verificar = "SELECT * FROM autenticacao_2fa WHERE user_id = ? AND codigo = ? AND usado = FALSE AND expira_em > NOW()";
    $stmt = $conn->prepare($sql_verificar);
    $stmt->bind_param("is", $user_id, $codigo_informado);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Código válido
        $sql_update = "UPDATE autenticacao_2fa SET usado = TRUE WHERE user_id = ? AND codigo = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("is", $user_id, $codigo_informado);
        $stmt_update->execute();

        echo "Verificação concluída com sucesso!";
        // Redirecionar ou concluir fluxo
        header("Location: sucesso.php");
    } else {
        echo "Código inválido ou expirado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação 2FA</title>
</head>
<body>
    <h1>Verificação de Dois Fatores</h1>
    <form method="POST" action="verificar_2fa.php">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_GET['user_id']); ?>">
        <label for="codigo">Digite o código enviado:</label>
        <input type="text" id="codigo" name="codigo" required>
        <button type="submit">Verificar</button>
    </form>
</body>
</html>
