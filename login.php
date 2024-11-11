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
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
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