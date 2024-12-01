<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redireciona para a página de login
    exit();
}

// Obter o tipo de usuário
$usuario_tipo = isset($_SESSION['tipo_usuario']) ? $_SESSION['tipo_usuario'] : null;

// Nome do usuário logado
$usuario_nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário';

// Determinar o link do perfil com base no tipo de usuário
$perfil_link = match ($usuario_tipo) {
    1 => 'prestador/perfil_prestador.php', // Prestador
    2 => 'cliente/perfil_cliente.php',     // Cliente
    3 => 'admin/admin_usuario.php',        // Admin
    default => 'perfil_prestador.php',     // Fallback
};
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Home</title>
    <link rel="stylesheet" href="stylehome.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>ProLinker</h1>
            <nav>
                <a href="index_logado.php">Home</a> <!-- Página inicial -->
                <?php if ($usuario_tipo == 1): ?> <!-- Mostrar apenas para prestador -->
                    <a href="prestador/land-post.php">Requisição</a>
                <?php endif; ?>
                <a href="<?php echo $perfil_link; ?>">Meu Perfil</a> <!-- Direciona para o perfil -->
                <a href="?logout=true">Sair</a> <!-- Botão de logout -->
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
                <p>Encontre rapidamente um técnico qualificado para resolver seus problemas em casa ou no trabalho. Conecte-se com profissionais da sua região!</p>
                <img src="imgs/problemahidraulico.jpg" alt="Problema Hidráulico" class="right-image">
            </div>
        </section>

        <section id="profoportunidades">
            <h2>Aumente Seus Ganhos como Profissional</h2>
            <div class="section-content">
                <p>Se você é um técnico em busca de novas oportunidades, junte-se ao ProLinker e amplie sua clientela. Ganhe mais oferecendo seus serviços a quem precisa!</p>
                <img src="imgs/eletricista.jpg" alt="Eletricista" class="left-image">
            </div>
        </section>

        <section id="sobrenos">
            <h2>Quem Somos</h2>
            <div class="section-content">
                <p>O ProLinker é a plataforma que conecta usuários a técnicos qualificados, facilitando a busca por serviços e a oferta de trabalho. Estamos aqui para simplificar sua vida!</p>
                <img src="imgs/varios.png" alt="Vários Profissionais" class="right-image">
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
    session_destroy(); // Destroi a sessão
    header("Location: login.php"); // Redireciona para a página de login
    exit();
}
?>
