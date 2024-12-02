<?php
session_start();

// Verificar se o usuário está logado e é do tipo admin
if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] != 3) {
    session_destroy(); // Limpar a sessão em caso de acesso inválido
    header("Location: ../login.php");
    exit();
}

// Incluir a configuração de conexão com o banco de dados
include_once('../config/db.php');

// Funções para exclusão
if (isset($_GET['delete_post'])) {
    $post_id = intval($_GET['delete_post']);
    $sql_delete_post = "DELETE FROM posts WHERE id_post = ?";
    $stmt = $conn->prepare($sql_delete_post);
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    header("Location: index_admin.php");
    exit();
}

if (isset($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);
    $sql_delete_user = "DELETE FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql_delete_user);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    header("Location: index_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Admin</title>
    <link rel="stylesheet" href="../stylehome.css">
    <style>
        .admin-section {
            margin-top: 20px;
        }

        .admin-section h2 {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f4f4f4;
        }

        .action-links a {
            margin-right: 10px;
            text-decoration: none;
            color: #007BFF;
        }

        .action-links a:hover {
            text-decoration: underline;
        }

        .add-button {
            display: inline-block;
            margin-bottom: 15px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .add-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker - Admin</h1>
            <nav>
                <a href="?logout=true">Sair</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="admin-section">
            <h2>Gerenciar Posts</h2>
            <a href="criar-post-admin.php" class="add-button">Adicionar Post</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_posts = "SELECT * FROM posts";
                    $result_posts = $conn->query($sql_posts);
                    while ($post = $result_posts->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $post['id_post']; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['content']); ?></td>
                            <td><?php echo htmlspecialchars($post['categoria']); ?></td>
                            <td class="action-links">
                                <a href="editar-post-admin.php?id=<?php echo $post['id_post']; ?>">Editar</a>
                                <a href="?delete_post=<?php echo $post['id_post']; ?>" onclick="return confirm('Tem certeza que deseja excluir este post?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <section class="admin-section">
            <h2>Gerenciar Usuários</h2>
            <a href="criar-usuario-admin.php" class="add-button">Adicionar Usuário</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_usuarios = "SELECT id_usuario, nome, email, celular, tipo_usuario_id FROM usuario";
                    $result_usuarios = $conn->query($sql_usuarios);
                    while ($usuario = $result_usuarios->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $usuario['id_usuario']; ?></td>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['celular']); ?></td>
                            <td>
                                <?php
                                switch ($usuario['tipo_usuario_id']) {
                                    case 1: echo 'Cliente'; break;
                                    case 2: echo 'Prestador'; break;
                                    case 3: echo 'Admin'; break;
                                }
                                ?>
                            </td>
                            <td class="action-links">
                                <a href="editar-usuario-admin.php?id=<?php echo $usuario['id_usuario']; ?>">Editar</a>
                                <a href="?delete_user=<?php echo $usuario['id_usuario']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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
