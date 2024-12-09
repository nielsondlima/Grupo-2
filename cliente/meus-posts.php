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

// Verificar se uma solicitação de exclusão foi feita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    $post_id = intval($_POST['delete_post']);

    // Verificar se o post pertence ao usuário logado
    $sql_check_owner = "SELECT id_post FROM posts WHERE id_post = ? AND user_id = ?";
    $stmt_check = $conn->prepare($sql_check_owner);
    $stmt_check->bind_param("ii", $post_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Excluir o post
        $sql_delete = "DELETE FROM posts WHERE id_post = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $post_id);
        $stmt_delete->execute();
        $stmt_delete->close();
        echo "<script>alert('Post excluído com sucesso.'); window.location.href = 'meus-posts.php';</script>";
    } else {
        echo "<script>alert('Você não tem permissão para excluir este post.'); window.location.href = 'meus-posts.php';</script>";
    }

    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Meus Posts</title>
    <link rel="stylesheet" href="../stylehome.css">
    <style>
        nav {
            padding: 10px 0;
        }

        nav a {
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            background-color: #0056b3;
            color: #fff;
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

        .delete-button {
            display: inline-block;
            background-color: #ff4d4d;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #cc0000;
        }

        .section-content {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            gap: 20px;
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
                            <div class="category"><?php echo htmlspecialchars($post['categoria']); ?></div>
                            <img src="../imgs/solicitacao.png" alt="Imagem Padrão do Post" class="post-image">
                            <div class="post-content">
                                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                                <div class="post-meta">
                                    <p><strong>Publicado em:</strong> <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></p>
                                    <p><strong>Telefone para contato:</strong> <?php echo htmlspecialchars($post['celular']); ?></p>
                                </div>
                                <form method="POST" action="">
                                    <input type="hidden" name="delete_post" value="<?php echo $post['id_post']; ?>">
                                    <button type="submit" class="delete-button">Excluir Post</button>
                                </form>
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
