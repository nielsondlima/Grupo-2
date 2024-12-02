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
$sql = "SELECT * FROM usuario WHERE id_usuario = ?";
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

// Lógica de logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destroi a sessão
    header("Location: ../login.php"); // Redireciona para a página de login
    exit();
}

// Atualizar informações do usuário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $nome = $conn->real_escape_string(trim($_POST['nome']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $celular = $conn->real_escape_string(trim($_POST['celular']));
    $endereco = $conn->real_escape_string(trim($_POST['endereco']));
    $bairro = $conn->real_escape_string(trim($_POST['bairro']));
    $cidade = $conn->real_escape_string(trim($_POST['cidade']));
    $senha = isset($_POST['senha']) && !empty($_POST['senha']) ? password_hash(trim($_POST['senha']), PASSWORD_DEFAULT) : $usuario['senha'];

    $sql_update = "UPDATE usuario SET nome = ?, email = ?, celular = ?, endereco = ?, bairro = ?, cidade = ?, senha = ? WHERE id_usuario = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssssi", $nome, $email, $celular, $endereco, $bairro, $cidade, $senha, $id_usuario);

    if ($stmt_update->execute()) {
        echo "<script>alert('Informações atualizadas com sucesso!');</script>";
        // Atualize as informações do usuário na variável para refletir no formulário
        $usuario['nome'] = $nome;
        $usuario['email'] = $email;
        $usuario['celular'] = $celular;
        $usuario['endereco'] = $endereco;
        $usuario['bairro'] = $bairro;
        $usuario['cidade'] = $cidade;
    } else {
        echo "<script>alert('Erro ao atualizar as informações.');</script>";
    }
    $stmt_update->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Meu Perfil</title>
    <link rel="stylesheet" href="../stylehome.css">
    <link rel="stylesheet" href="../perfil.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="index_prestador.php">Home</a> <!-- Página inicial -->
                <a href="../prestador/land-post.php">Solicitações</a> <!-- Botão para land-post -->
                <a href="perfil_prestador.php">Meu Perfil</a> <!-- Página de perfil -->
                <a href="?action=logout">Sair</a> <!-- Botão de logout -->
            </nav>

            <div class="user-welcome">
                <p>Bem-vindo, <?php echo htmlspecialchars($usuario['nome']); ?></p>
            </div>
        </div>
    </header>

    <main class="container">
        <section id="perfil">
            <h2>Editar Meu Perfil</h2>
            <form method="POST" action="" class="perfil-form">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="celular">Telefone:</label>
                    <input type="text" name="celular" id="celular" value="<?php echo htmlspecialchars($usuario['celular']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" id="endereco" value="<?php echo htmlspecialchars($usuario['endereco']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="bairro">Bairro:</label>
                    <input type="text" name="bairro" id="bairro" value="<?php echo htmlspecialchars($usuario['bairro']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="cidade">Cidade:</label>
                    <input type="text" name="cidade" id="cidade" value="<?php echo htmlspecialchars($usuario['cidade']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha (deixe em branco para não alterar):</label>
                    <input type="password" name="senha" id="senha">
                </div>
                <div class="form-group">
                    <button type="submit" name="update" class="edit-button">Salvar Alterações</button>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
