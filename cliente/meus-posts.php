<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
include_once('../config/db.php');

// Consultar os posts do cliente logado
$user_id = $_SESSION['id'];
$sql_posts = "SELECT posts.id_post, posts.title, posts.content, posts.created_at, usuario.celular, categorias.nome AS categoria
              FROM posts
              INNER JOIN usuario ON posts.user_id = usuario.id_usuario
              INNER JOIN categorias ON posts.categoria = categorias.id_categoria
              WHERE posts.user_id = ? 
              ORDER BY posts.created_at DESC";

// Preparar a consulta
$stmt = $conn->prepare($sql_posts);
$stmt->bind_param("i", $user_id);
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
    <style>
        /* Estilo para a navegação */
        nav {
            padding: 10px 0;
        }

        nav a {
            color: #fff; /* Cor do texto branca */
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            background-color: #0056b3; /* Cor de fundo ao passar o mouse */
            color: #fff; /* Cor do texto continua branca */
        }

        .post {
            display: flex;
            flex-direction: column;
            background-color: #f4f4f4;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .post h3 {
            font-size: 1.5em;
            margin: 10px 0;
        }

        .post p {
            font-size: 1em;
            margin-bottom: 10px;
        }

        .post-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .post-meta {
            font-size: 0.9em;
            color: #555;
        }

        .category {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .section-content {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column; /* Coloca os posts um abaixo do outro */
            gap: 20px; /* Adiciona um espaçamento entre os posts */
        }

        .user-welcome {
            font-size: 1.1em;
            color: #fff; /* Cor branca para o texto "Bem-vindo" */
        }

    </style>
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
                            <!-- Exibir a categoria com o nome -->
                            <div class="category"><?php echo htmlspecialchars($post['categoria']); ?></div>
                            <img src="../imgs/solicitacao.png" alt="Imagem Padrão do Post" class="post-image">
                            <div class="post-content">
                                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p><?php echo nl2br(string: htmlspecialchars($post['content'])); ?></p>
                                <div class="post-meta">
                                    <p><strong>Publicado em:</strong> <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></p>
                                    <p><strong>Telefone para contato:</strong> <?php echo htmlspecialchars($post['celular']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Você ainda não criou nenhum post.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
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
