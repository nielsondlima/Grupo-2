<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
include_once('../config/db.php');

// Obter a especialidade do prestador logado
$user_id = $_SESSION['id'];
$sql_user = "SELECT especialidade FROM usuario WHERE id_usuario = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows === 0) {
    die("Usuário não encontrado.");
}

$especialidade = $result_user->fetch_assoc()['especialidade'];

// Buscar posts que correspondem à especialidade do prestador
$sql_posts = "SELECT p.id_post, p.title, p.content, c.nome AS categoria, u.nome AS cliente
              FROM posts p
              JOIN categorias c ON p.categoria = c.id_categoria
              JOIN usuario u ON p.user_id = u.id_usuario
              WHERE c.nome = ?";
$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bind_param("s", $especialidade);
$stmt_posts->execute();
$result_posts = $stmt_posts->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Land Post</title>
    <link rel="stylesheet" href="../stylehome.css">
    <style>
        .post {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .post img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .post-content {
            flex: 1;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="index_prestador.php">Home</a>
                <a href="land-post.php">Solicitações</a>
                <a href="perfil_prestador.php">Meu Perfil</a>
                <a href="?logout=true">Sair</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section id="land-post">
            <h2>Solicitações de Serviço</h2>
            <?php if ($result_posts->num_rows > 0): ?>
                <?php while ($post = $result_posts->fetch_assoc()): ?>
                    <div class="post">
                        <img src="../imgs/solicitacao.png" alt="Imagem padrão do post">
                        <div class="post-content">
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                            <p><strong>Solicitante:</strong> <?php echo htmlspecialchars($post['cliente']); ?></p>
                            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($post['content']); ?></p>
                            <p><strong>Categoria:</strong> <?php echo htmlspecialchars($post['categoria']); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nenhum post encontrado para sua especialidade.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
