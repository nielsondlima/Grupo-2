<?php
session_start(); // Inicia a sessão



// Verifique se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redireciona para a página de login
    exit();
}

// Incluindo o arquivo de conexão
include_once('../config/db.php');

// Verifique se a conexão foi estabelecida
if (!isset($conn)) {
    die("Erro na conexão com o banco de dados.");
}

// Obtenha o ID do usuário logado
$id_usuario = $_SESSION['id'];

// Recuperar informações do usuário
$sql = "SELECT * FROM usuario WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit();
}

if (isset($_POST['logout'])) {
    session_destroy(); // Destroi a sessão
    header("Location: /Grupo-2/index.php");
    exit();
    
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Perfil do Usuário</title>
    <link rel="stylesheet" href="stylehome.css">
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="land-post.php">Home</a>
                <a href="perfil_prestador.php">Meu Perfil</a>
               <!-- Botão de logout -->
    <form method="POST" style="text-align: right;">
        <button type="submit" name="logout">Logout</button>
    </form>
            </nav>
            <div class="user-welcome">
                <p>Bem-vindo, <?php echo $usuario['nome']; ?></p>
            </div>
        </div>
    </header>

    <main class="container">
        <section id="perfil">
            <h2>Meu Perfil</h2>
            <div class="perfil-content">
                <img src="imgs/avatar.jpg" alt="Foto do Perfil" class="perfil-image">
                <div class="perfil-info">
                    <h3><?php echo $usuario['nome']; ?></h3>
                    <p><strong>E-mail:</strong> <?php echo $usuario['email']; ?></p>
                    <p><strong>Telefone:</strong> <?php echo $usuario['celular']; ?></p>
                    <p><strong>Endereço:</strong> <?php echo $usuario['endereco']; ?>, <?php echo $usuario['bairro']; ?> - <?php echo $usuario['cidade']; ?></p>
                    <p><strong>Tipo de Usuário:</strong> <?php echo $usuario['tipo_usuario']; ?></p>
                    <button class="edit-button" onclick="window.location.href='editar-perfil.php'">Editar Perfil</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
