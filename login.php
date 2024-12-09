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
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .login-container h2 {
            margin-bottom: 1.5rem;
            font-size: 24px;
            color: #333;
            text-align: center;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .login-container form label {
            font-size: 14px;
            color: #555;
        }
        .login-container form input {
            padding: 0.8rem;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .login-container form button {
            padding: 0.8rem;
            font-size: 16px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-container form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
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
            <!-- Formulário de login -->
            <form method="POST" action="retornologin.php">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" required>
                
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" required>
                
                <button type="submit">Entrar</button>
                <button type="button" onclick="window.location.href='form2.php';">Cadastre-se</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
