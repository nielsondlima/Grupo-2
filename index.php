<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Home</title>
    <link rel="stylesheet" href="stylehome.css">
    <style>
        .cadastro-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #ffffff;
            background-color: #4682b4; /* Cor do nav */
            border-radius: 5px;
            margin-left: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .cadastro-button:hover {
            background-color: #4169e1; /* Azul Royal no hover */
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        section h2 {
            flex: 1;
            font-size: 2rem;
            color: #4682b4;
            margin-bottom: 20px;
        }

        @media screen and (max-width: 768px) {
            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .cadastro-button {
                margin-left: 0;
                margin-top: 10px;
            }
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
            <div class="section-header">
                <h2>SOLICITE SERVIÇOS</h2>
                <!-- Botão de cadastro -->
                <a href="form2.php" class="cadastro-button">Cadastre-se</a>
            </div>
            <div class="section-content">
                <p>Encontre rapidamente um técnico qualificado para resolver seus problemas em casa ou no trabalho. Conecte-se com profissionais da sua região! Você, como cliente, pode publicar suas necessidades de serviço, sejam elas emergenciais ou planejadas, e encontrar prestadores capacitados prontos para ajudá-lo!</p>
                <img src="imgs/problemahidraulico.jpg" alt="Problema Hidráulico" class="right-image">
            </div>
        </section>

        <section id="profoportunidades">
            <div class="section-header">
                <h2>AUMENTE SEUS GANHOS</h2>
                <!-- Botão de cadastro -->
                <a href="form2.php" class="cadastro-button">Cadastre-se</a>
            </div>
            <div class="section-content">
                <p>Se você é um técnico em busca de novas oportunidades, junte-se ao ProLinker e amplie sua clientela! Nossa plataforma conecta você diretamente a clientes que precisam de seus serviços, facilitando sua visibilidade no mercado. Comece a receber solicitações de serviço em sua área, sejam elas de pequenos reparos ou grandes projetos!</p>
                <img src="imgs/eletricista.jpg" alt="Eletricista" class="left-image">
            </div>
        </section>

        <section id="sobrenos">
            <h2>QUEM SOMOS</h2>
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
