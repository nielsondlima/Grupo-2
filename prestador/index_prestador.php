<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] != 2) {
    session_destroy(); // Garante que a sessão inválida seja limpa
    header("Location: ../login.php");
    exit();
}

// Obter informações do usuário
$usuario_nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Prestador</title>
    <link rel="stylesheet" href="../stylehome.css">
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
            <div class="user-welcome">
                <p>Bem-vindo, <?php echo htmlspecialchars($usuario_nome); ?></p>
            </div>
        </div>
    </header>

    <main class="container">
        <section id="solicitaservico">
            <h2>Solicitações de Serviço</h2>
            <div class="section-content">
                <p>Acesse as solicitações disponíveis na sua área de especialidade e conecte-se com os clientes.</p>
                <img src="../imgs/solicitacao.png" alt="Solicitações" class="right-image">
            </div>
        </section>

        <section id="profoportunidades">
            <h2>Amplie Suas Oportunidades</h2>
            <div class="section-content">
                <p>Conquiste novos clientes e aumente sua renda oferecendo serviços de qualidade!</p>
                <img src="../imgs/eletricista.jpg" alt="Oportunidades" class="left-image">
            </div>
        </section>

        <section id="sobrenos">
            <h2>Quem Somos</h2>
            <div class="section-content">
                <p>O ProLinker conecta técnicos especializados a clientes que precisam de serviços. Junte-se à nossa plataforma para mais oportunidades.</p>
                <img src="../imgs/varios.png" alt="Profissionais" class="right-image">
            </div>
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