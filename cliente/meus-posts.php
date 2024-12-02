<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Incluir a configuração de conexão com o banco de dados
include_once('../config/db.php');

// Obter o ID do cliente logado
$user_id = $_SESSION['id'];

// Buscar os posts do cliente logado
$sql_posts = "SELECT posts.id_post, posts.title, posts.content, posts.created_at, usuario.celular 
              FROM posts 
              INNER JOIN usuario ON posts.user_id = usuario.id_usuario 
              WHERE posts.user_id = ? 
              ORDER BY posts.created_at DESC";
$stmt = $conn->prepare($sql_posts);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Meus Posts</title>
    <link rel="stylesheet" href="../stylehome.css">
    <link rel="stylesheet" href="../stylepost.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="index_cliente.php">Home</a>
                <a href="criar-post.php">Criar Post</a>
                <a href="meus-posts.php">Meus Posts</a>
                <a href="perfil.php">Meu Perfil</a>
                <a href="?logout=true">Sair</a>
            </nav>
            <div class="user-welcome">
                <p>Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?></p>
            </div>
        </div>
    </header>

    <main class="container">
        <section>
            <h2>Meus Posts</h2>
            <div class="section-content">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($post = $result->fetch_assoc()): ?>
                        <div class="post">
                            <img src="../imgs/solicitacao.png" alt="Imagem Padrão do Post" class="post-image">
                            <div class="post-content">
                                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                                <p><strong>Publicado em:</strong> <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></p>
                                <p><strong>Telefone para contato:</strong> <?php echo htmlspecialchars($post['celular']); ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Você ainda não criou nenhum post.</p>
                <?php endif; ?>
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

<?php
// Lógica de logout
if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_destroy();
    header("Location: ../login.php");
    exit();
}
?>
