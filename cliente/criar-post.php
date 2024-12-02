<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Incluir o arquivo de conexão com o banco de dados
include_once('../config/db.php');

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id']; // ID do cliente logado
    $title = $conn->real_escape_string(trim($_POST['title']));
    $content = $conn->real_escape_string(trim($_POST['content']));
    $categoria = $conn->real_escape_string(trim($_POST['categoria'])); // Nome da categoria selecionada

    // Verificar se a categoria existe no banco e obter seu ID
    $sql_categoria = "SELECT id_categoria FROM categorias WHERE nome = ?";
    $stmt_categoria = $conn->prepare($sql_categoria);
    $stmt_categoria->bind_param("s", $categoria);
    $stmt_categoria->execute();
    $result_categoria = $stmt_categoria->get_result();

    if ($result_categoria->num_rows === 0) {
        echo "<script>alert('Categoria inválida!');</script>";
    } else {
        $categoria_id = $result_categoria->fetch_assoc()['id_categoria'];

        // Inserir o post no banco de dados
        $sql_insert = "INSERT INTO posts (user_id, title, content, categoria) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bind_param("issi", $user_id, $title, $content, $categoria_id);

        if ($stmt->execute()) {
            echo "<script>alert('Post criado com sucesso!'); window.location.href = '../meus-posts.php';</script>";
        } else {
            echo "<script>alert('Erro ao criar o post. Por favor, tente novamente.');</script>";
        }

        $stmt->close();
    }

    $stmt_categoria->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Criar Post</title>
    <link rel="stylesheet" href="../stylehome.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="index_cliente.php">Home</a>
                <a href="meus-posts.php">Meus Posts</a>
                <a href="perfil.php">Meu Perfil</a>
                <a href="?logout=true">Sair</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section id="criar-post">
            <h2>Criar Post</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" name="title" id="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Descrição:</label>
                    <textarea name="content" id="content" rows="5" required></textarea>
                </div>
                <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <select name="categoria" id="categoria" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        <option value="Manutenção">Manutenção e Reformas</option>
                        <option value="Tecnologia">Tecnologia</option>
                        <option value="Saúde">Saúde</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Produção">Produção</option>
                        <option value="Fotografia">Fotografia</option>
                        <option value="Tradução">Tradução</option>
                        <option value="Educação">Educação</option>
                        <option value="Artes">Artes Visuais</option>
                        <option value="Administração">Administração</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-button">Criar Post</button>
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
