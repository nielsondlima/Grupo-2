<?php
include_once('config/db.php'); // Ajuste o caminho conforme necessário

if (!isset($conn)) {
    die('A variável $conn não foi definida. Verifique sua configuração no arquivo db.php.');
}

if (isset($_POST['email']) && isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else {

        $email = $conn->real_escape_string($_POST['email']); // Usando $conn
        $senha = $conn->real_escape_string($_POST['senha']); // Usando $conn

        $sql_code = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $conn->query($sql_code) or die("Falha na execução do código SQL: " . $conn->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {

            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            if ($usuario['tipo_usuario'] == 'Admin') {
                header("Location: admin/admin_usuario.php");
            exit;
            } else if ($usuario['tipo_usuario'] == 'Cliente') {
                header("Location: cliente/meus-posts.php");
            } else if ($usuario['tipo_usuario'] == 'Prestador') {
                header("Location: prestador/land-post.php");
            } else {
                echo "Falha ao logar! Tipo de usuário inválido.";
            }

        } else {
            echo "Falha ao logar! E-mail ou senha incorretos.";
        }
    }

} else {
    echo "Por favor, envie o formulário.";
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Login</title>
    <link rel="stylesheet" href="formulario.css">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .login-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="page-container">
        <header>
            <div class="container">
                <h1>ProLinker</h1>
                <nav>
                    <a href="index.php">Home</a>
                    <a href="login.php">Login</a>
                </nav>
            </div>
        </header>

        <main class="container">
            <div class="login-container">
                <h2>Login</h2>
<<<<<<< HEAD
                <!-- Formulário de login -->
                <form method="POST" action="retornologin.php">
=======
                <form method="POST" action="">
>>>>>>> d3a2a51de2b2b805f52168455664936cac253e76
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" required>
                    
                    <label for="senha">Senha:</label>
                    <input type="password" name="senha" id="senha" required>
                    
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </main>

        <footer>
            <div class="container">
                <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>
