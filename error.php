<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro - ProLinker</title>
    <link rel="stylesheet" href="formulario.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .error-container {
            text-align: center;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .error-container h1 {
            font-size: 2.5rem;
            color: #e74c3c;
        }
        .error-container p {
            font-size: 1.2rem;
        }
        .error-container a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .error-container a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Ops! Algo deu errado.</h1>
        <p><?php echo htmlspecialchars($_GET['message'] ?? 'Erro inesperado.'); ?></p>
        <a href="index.php">Voltar à página inicial</a>
    </div>
</body>
</html>
