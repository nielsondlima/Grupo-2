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

// Funções para exclusão e registro no log
if (isset($_GET['delete_post'])) {
    $post_id = intval($_GET['delete_post']);
    $sql_delete_post = "DELETE FROM posts WHERE id_post = ?";
    $stmt = $conn->prepare($sql_delete_post);

    if ($stmt) {
        $stmt->bind_param('i', $post_id);
        if ($stmt->execute()) {
            // Registrar no log
            $log_evento = "Postagem ID $post_id excluída.";
            $sql_log = "INSERT INTO log (user_id, data_hora, evento) VALUES (?, NOW(), ?)";
            $stmt_log = $conn->prepare($sql_log);
            $stmt_log->bind_param('is', $_SESSION['id'], $log_evento);
            $stmt_log->execute();
        }
    }
    header("Location: index_admin.php");
    exit();
}

if (isset($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);

    // Excluir registros relacionados
    $sql_delete_posts = "DELETE FROM posts WHERE user_id = ?";
    $stmt_posts = $conn->prepare($sql_delete_posts);
    $stmt_posts->bind_param('i', $user_id);
    $stmt_posts->execute();

    $sql_delete_logs = "DELETE FROM log WHERE user_id = ?";
    $stmt_logs = $conn->prepare($sql_delete_logs);
    $stmt_logs->bind_param('i', $user_id);
    $stmt_logs->execute();

    $sql_delete_2fa = "DELETE FROM autenticacao_2fa WHERE user_id = ?";
    $stmt_2fa = $conn->prepare($sql_delete_2fa);
    $stmt_2fa->bind_param('i', $user_id);
    $stmt_2fa->execute();

    // Excluir o usuário
    $sql_delete_user = "DELETE FROM usuario WHERE id_usuario = ?";
    $stmt_user = $conn->prepare($sql_delete_user);
    $stmt_user->bind_param('i', $user_id);
    if ($stmt_user->execute()) {
        // Registrar no log
        $log_evento = "Usuário ID $user_id excluído.";
        $sql_log = "INSERT INTO log (user_id, data_hora, evento) VALUES (?, NOW(), ?)";
        $stmt_log = $conn->prepare($sql_log);
        $stmt_log->bind_param('is', $_SESSION['id'], $log_evento);
        $stmt_log->execute();
    }

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
                    $sql_posts = "
                        SELECT 
                            p.id_post, 
                            p.title, 
                            p.content, 
                            c.nome AS categoria
                        FROM posts p
                        JOIN categorias c ON p.categoria = c.id_categoria
                    ";
                    $result_posts = $conn->query($sql_posts);
                    while ($post = $result_posts->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $post['id_post']; ?></td>
                            <td><?php echo htmlspecialchars($post['title']); ?></td>
                            <td><?php echo htmlspecialchars($post['content']); ?></td>
                            <td><?php echo htmlspecialchars($post['categoria']); ?></td>
                            <td class="action-links">
                                <a href="?delete_post=<?php echo $post['id_post']; ?>" onclick="return confirm('Tem certeza que deseja excluir este post?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <section class="admin-section">
            <h2>Gerenciar Usuários</h2>
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
                                <a href="?delete_user=<?php echo $usuario['id_usuario']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <section class="admin-section">
            <h2>Log do Sistema</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Admin</th>
                        <th>Evento</th>
                        <th>Data/Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_logs = "SELECT * FROM log ORDER BY id_log DESC";
                    $result_logs = $conn->query($sql_logs);
                    while ($log = $result_logs->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $log['id_log']; ?></td>
                            <td><?php echo $log['user_id']; ?></td>
                            <td><?php echo htmlspecialchars($log['evento']); ?></td>
                            <td><?php echo htmlspecialchars($log['data_hora']); ?></td>
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
