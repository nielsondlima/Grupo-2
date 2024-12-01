<?php
session_start();
if (isset($_SESSION['id'])) {
    header("Location: index_logado.php");
    exit();
}
// Código HTML da página inicial para visitantes
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Home</title>
    <link rel="stylesheet" href="stylehome.css">
    <style>
        /* Garantir que o footer fique na parte inferior */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        main {
            flex: 1; /* Faz o conteúdo ocupar o espaço disponível */
        }
        footer {
            background: #f4f4f4;
            text-align: center;
            padding: 1rem 0;
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.1);
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
        <section id="solicitaservico">
            <a href="solicitaservico.php">
                <h2>Para o Usuário que Solicita o Serviço</h2>
                <div class="section-content">
                    <a href="solicitaservico.php" class="button">Clique aqui</a>
                    <p>Encontre rapidamente um técnico qualificado para resolver seus problemas em casa ou no trabalho. Conecte-se com profissionais da sua região!</p>
                    <img src="imgs/problemahidraulico.jpg" alt="Problema Hidráulico" class="right-image">
                </div>
            </a>
        </section>

        <section id="profoportunidades">
            <a href="profoportunidades.php">
                <h2>Aumente Seus Ganhos como Profissional</h2>
                <div class="section-content">
                    <a href="profoportunidades.php" class="button">Clique aqui</a>
                    <p>Se você é um técnico em busca de novas oportunidades, junte-se ao ProLinker e amplie sua clientela. Ganhe mais oferecendo seus serviços a quem precisa!</p>
                    <img src="imgs/eletricista.jpg" alt="Eletricista" class="left-image">
                </div>
            </a>
        </section>

        <section id="sobrenos">
            <a href="sobrenos.php">
                <h2>Quem Somos</h2>
                <div class="section-content">
                    <p>O ProLinker é a plataforma que conecta usuários a técnicos qualificados, facilitando a busca por serviços e a oferta de trabalho. Estamos aqui para simplificar sua vida!</p>
                    <img src="imgs/varios.png" alt="Vários Profissionais" class="right-image">
                </div>
            </a>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
