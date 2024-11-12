<?php
include '/config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitização de dados de entrada
    $nome = htmlspecialchars($_POST['input-1']);
    $data_nasc = htmlspecialchars($_POST['date']);
    $genero = htmlspecialchars($_POST['genero']);
    $nome_mae = htmlspecialchars($_POST['input-4']);
    $cpf = htmlspecialchars($_POST['input-5']);
    $senha = password_hash($_POST['input-6'], PASSWORD_BCRYPT);
    $cep = htmlspecialchars($_POST['cep']);
    $endereco = htmlspecialchars($_POST['endereco']);
    $bairro = htmlspecialchars($_POST['bairro']);
    $cidade = htmlspecialchars($_POST['cidade']);
    $email = htmlspecialchars($_POST['input-8']);
    $celular = htmlspecialchars($_POST['cel']);
    $tipo_usuario = htmlspecialchars($_POST['tipo_usuario']);
    $especialidade = isset($_POST['zona']) ? htmlspecialchars($_POST['zona']) : NULL;

    // Uso de prepared statement
    $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, endereco, especialidade, data_nasc, genero, cpf, cidade, bairro, nome_mae, tipo_usuario)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $nome, $email, $senha, $endereco, $especialidade, $data_nasc, $genero, $cpf, $cidade, $bairro, $nome_mae, $tipo_usuario);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProLinker - Cadastro Prestador</title>
    <link rel="stylesheet" href="formulario.css">
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
        <section>
            <h2>Cadastro de Usuário</h2>
            <div class="section-content"> 
                <form action="cadastro.php" method="post">

                    <div class="input-gp">
                        <div class="input-box">
                            <input id="input-1" type="text" name="input-1" placeholder="Digite seu nome completo" required>
                        </div>
                        <div class="input-box">
                            <input id="date" type="text" name="date" placeholder="Data de nascimento" required>
                        </div>
                        <div class="input-box">
                            <select name="genero" id="genero">
                                <option value="" disabled selected>Gênero</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                            </select>
                        </div>
                        <div class="input-box">
                            <input id="input-4" type="text" name="input-4" placeholder="Digite seu Nome Materno" required>
                        </div>
                        <div class="input-box">
                            <input id="input-5" type="text" name="input-5" placeholder="Digite seu CPF" required>
                        </div>
                        <div class="input-box">
                            <input id="input-6" type="password" name="input-6" placeholder="Digite sua senha" required>
                        </div>
                        <div class="input-box">
                            <input id="input-6-5" type="password" name="input-6-5" placeholder="Confirme sua senha" required>
                        </div>
                        <div class="input-box">
                            <input id="cep" type="text" name="cep" placeholder="Digite seu CEP" required>
                        </div>
                        <div class="input-box">
                            <input id="endereco" type="text" name="endereco" placeholder="Endereço" readonly required>
                        </div>
                        <div class="input-box">
                            <input id="bairro" type="text" name="bairro" placeholder="Bairro" readonly required>
                        </div>
                        <div class="input-box">
                            <input id="cidade" type="text" name="cidade" placeholder="Cidade" readonly required>
                        </div>
                        <br>
                        <div class="input-box">
                            <input id="input-8" type="email" name="input-8" placeholder="Digite seu email" required>
                        </div>
                        <div class="input-box">
                            <input id="cel" type="tel" name="cel" placeholder="Digite seu celular" required>
                        </div>
                        <div class="input-box">
                            <select id="tipo_usuario" name="tipo_usuario" onchange="mostrarEspecialidade()">
                                <option value="" disabled selected>Tipo de usuário</option>
                                <option value="cliente">Cliente</option>
                                <option value="prestador">Prestador</option>
                            </select>
                        </div>
                        <div class="input-box" id="especialidade-box" style="display: none;">
                            <select id="zona" name="zona">
                                <option value="" disabled selected>Especialidade</option>
                                <option value="Manutenção">Manutenção e Reformas</option>
                                <option value="Tecnologia">Tecnologia</option>
                                <option value="Saúde">Saúde</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Produção">Produção</option>
                                <option value="Fotografia">Fotografia</option>
                                <option value="Tradução">Tradução</option>
                                <option value="Educação">Educação</option>
                                <option value="Artes">Artes Visuais</option>
                                <option value="Administração">Administração</option>
                            </select>
                        </div>
                        <!-- Botões colocados na mesma caixa da especialidade -->
                        <div class="input-box form-buttons">
                            <button type="reset">Limpar</button>
                            <button type="submit">Continuar</button>
                        </div>
                    </div>
                </form>
                <script src="formulario.js"></script>
                <script src="Validacep.js"></script>
                <script>
                    function mostrarEspecialidade() {
                        const tipoUsuario = document.getElementById('tipo_usuario').value;
                        const especialidadeBox = document.getElementById('especialidade-box');
                        if (tipoUsuario === 'prestador') {
                            especialidadeBox.style.display = 'block';
                        } else {
                            especialidadeBox.style.display = 'none';
                        }
                    }

                    document.querySelector('form').addEventListener('submit', function(event) {
                        const senha = document.getElementById('input-6').value;
                        const confirmSenha = document.getElementById('input-6-5').value;

                        if (senha !== confirmSenha) {
                            alert('As senhas não coincidem.');
                            event.preventDefault();
                        }
                    });
                </script>
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
