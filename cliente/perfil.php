<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Metadados para configuração da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Perfil do Usuário</title>
    <!-- Links para os arquivos CSS -->
    <link rel="stylesheet" href="stylehome.css">
    <link rel="stylesheet" href="perfil.css">
</head>
<body>
    <!-- Cabeçalho da página -->
    <header>
        <div class="container">
            <!-- Logo do site -->
            <h1>ProLinker</h1>
            <!-- Barra de navegação -->
            <nav>
                <!-- Links para as diferentes páginas do site -->
                <a href="index.php">Home</a>
                <a href="criar-post.php">Criar Post</a>
                <a href="meus-posts.php">Meus Posts</a>
                <a href="perfil.php">Meu Perfil</a>
                <a href="">Sair</a>
            </nav>
            <!-- Mensagem de boas-vindas ao usuário -->
            <div class="user-welcome">
                <p>Bem-vindo, Nielson Lima</p>
            </div>
        </div>
    </header>

    <!-- Conteúdo principal da página -->
    <main class="container">
        <!-- Seção de perfil do usuário -->
        <section id="perfil">
            <h2>Meu Perfil</h2>
            <!-- Container para informações do perfil -->
            <div class="perfil-content">
                <!-- Imagem de perfil do usuário -->
                <img src="imgs/avatar.jpg" alt="Foto do Perfil" class="perfil-image">
                <!-- Informações detalhadas do perfil -->
                <div class="perfil-info">
                    <h3>Nielson Lima</h3>
                    <p><strong>E-mail:</strong> nielson.lima@example.com</p>
                    <p><strong>Telefone:</strong> (21) 98765-4321</p>
                    <p><strong>Endereço:</strong> Rua das Flores, 123 - Rio de Janeiro, RJ</p>
                    <p><strong>Tipo de Usuário:</strong> Cliente</p>
                    <!-- Botão para editar o perfil -->
                    <button class="edit-button">Editar Perfil</button>
                </div>
            </div>
        </section>
    </main>

    <!-- Rodapé da página -->
    <footer>
        <div class="container">
            <p>&copy; 2024 ProLinker. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
