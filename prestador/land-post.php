<?php
// Verifique se o usuário deseja fazer logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset(); // Remove todas as variáveis de sessão
    session_destroy(); // Destroi a sessão
    header("Location: ../login.php"); // Redireciona para a página de login
    exit();
}

// Verifique se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php"); // Redireciona para a página de login
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Cadastro Cliente</title>
    <link rel="stylesheet" href="formulario.css">
    <link rel="stylesheet" href="stylepost.css">
    <link rel="stylesheet" href="stylehome.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="land-post.php">Home</a>
                <a href="post.php">Requisição</a>
                <a href="perfil_prestador.php">Meu Perfil</a>
                <a href="logout.php">Sair</a>
            </nav>
            <div class="user-welcome">
                <p>Bem-vindo, Vitor França</p>
            </div>
        </div>
    </header>

    <main class="container">

        <div class="card">
            <div class="card-header">
              <img src="https://lncimg.lance.com.br/cdn-cgi/image/width=828,quality=75,fit=pad,format=webp/uploads/2019/10/15/5da5d77a9db85.jpeg" alt="User Avatar" class="avatar">
              <h3>Edilson da Silva</h3>
            </div>
            <div class="card-title">Preciso de um eletricista</div>
            <div class="card-description">
                <h3>Fez muito frio semana passada, e acabei abusando do chuveiro elétrico. Acabou que a resitência queimou, e voltou a esfriar.</h3>
                <div class="imagem" id="imagem"> <img src="https://midias.jornalcruzeiro.com.br/wp-content/uploads/2021/01/chuveiro-547x364.jpg" alt=""></div>
            </div>

                <div class="icons-container">
                <button id="button1"> <img src="https://cdn.icon-icons.com/icons2/906/PNG/512/commenting_icon-icons.com_70233.png" alt="" srcset=""></button>
                <button id="button2"> <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrlEOQUDoqYMLLGIc0Sf9R4kTO2SKiXxWADQ&s" alt=""></button>
                </div>
                <input type="text" class="comment-input" placeholder="Deixe um comentário...">
            </div>
          </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
