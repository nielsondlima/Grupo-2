<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id']) || $_SESSION['tipo_usuario'] != 1) {
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
    <title>ProLinker - Cliente</title>
    <link rel="stylesheet" href="../stylehome.css">
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="index_cliente.php">Home</a>
                <a href="criar-post.php">Criar Post</a>
                <a href="meus-posts.php">Meus Posts</a>
                <a href="perfil.php">Meu Perfil</a>
                <a href="?logout=true">Sair</a>
            </nav>
            <div class="user-welcome">
                <p>Bem-vindo, <?php echo htmlspecialchars($usuario_nome); ?></p>
            </div>
        </div>
    </header>

    <main class="container">
        <section id="solicitaservico">
            <h2>Para o Usuário que Solicita o Serviço</h2>
            <div class="section-content">
                <p>Encontre rapidamente um técnico qualificado para resolver seus problemas em casa ou no trabalho. Conecte-se com profissionais da sua região! você, como cliente, pode publicar suas necessidades de serviço, sejam elas emergenciais ou planejadas, e encontrar prestadores capacitados prontos para ajudá-lo!</p>
                <img src="../imgs/problemahidraulico.jpg" alt="Problema Hidráulico" class="right-image">
            </div>
        </section>

        <section id="profoportunidades">
            <h2>Aumente Seus Ganhos como Profissional</h2>
            <div class="section-content">
                <p>Se você é um técnico em busca de novas oportunidades, junte-se ao ProLinker e amplie sua clientela! Nossa plataforma conecta você diretamente a clientes que precisam de seus serviços, facilitando sua visibilidade no mercado. Comece a receber solicitações de serviço em sua área, sejam elas de pequenos reparos ou grandes projetos!</p>
                <img src="../imgs/eletricista.jpg" alt="Eletricista" class="left-image">
            </div>
        </section>

        <section id="sobrenos">
            <h2>Quem Somos</h2>
            <div class="section-content">
                <p>O ProLinker é a plataforma que conecta usuários a técnicos qualificados, facilitando a busca por serviços e a oferta de trabalho. Estamos aqui para simplificar sua vida!</p>
                <img src="../imgs/varios.png" alt="Vários Profissionais" class="right-image">
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
