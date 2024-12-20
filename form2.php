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
                            <input id="date" type="text" name="date" placeholder="Data de nascimento (DD/MM/AAAA)" required>
                        </div>
                        <div class="input-box">
                            <select name="genero" id="genero" required>
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
                        <div class="input-box">
                            <input id="input-8" type="email" name="input-8" placeholder="Digite seu email" required>
                        </div>
                        <div class="input-box">
                            <input id="cel" type="tel" name="cel" placeholder="Digite seu celular (xx) xxxxx-xxxx" required>
                        </div>
                        <div class="input-box">
                            <select id="tipo_usuario" name="tipo_usuario" onchange="mostrarEspecialidade()" required>
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
                        <div class="input-box form-buttons">
                            <button type="reset">Limpar</button>
                            <button type="submit">Continuar</button>
                        </div>
                    </div>
                </form>

                <script>
                    function mostrarEspecialidade() {
                        const tipoUsuario = document.getElementById('tipo_usuario').value;
                        const especialidadeBox = document.getElementById('especialidade-box');
                        especialidadeBox.style.display = tipoUsuario === 'prestador' ? 'block' : 'none';
                    }

                    // Funções de máscara e validação
                    function aplicarMascara(elemento, mascara) {
                        elemento.addEventListener('input', (event) => {
                            let value = event.target.value.replace(/\D/g, '');
                            event.target.value = mascara(value);
                        });
                    }

                    function bloquearNumeros(event) {
                        if (/\d/.test(event.key)) {
                            event.preventDefault();
                        }
                    }

                    const mascaras = {
                        cpf: (value) => value.replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d{1,2})$/, "$1-$2"),
                        data: (value) => value.replace(/(\d{2})(\d)/, "$1/$2").replace(/(\d{2})(\d)/, "$1/$2"),
                        celular: (value) => value.replace(/(\d{2})(\d)/, "($1) $2").replace(/(\d{5})(\d{1,4})$/, "$1-$2"),
                        cep: (value) => value.replace(/(\d{5})(\d{1,3})$/, "$1-$2"),
                    };

                    aplicarMascara(document.getElementById('input-5'), mascaras.cpf); // CPF
                    aplicarMascara(document.getElementById('date'), mascaras.data); // Data de nascimento
                    aplicarMascara(document.getElementById('cel'), mascaras.celular); // Celular
                    aplicarMascara(document.getElementById('cep'), mascaras.cep); // CEP

                    document.getElementById('input-1').addEventListener('keypress', bloquearNumeros);
                    document.getElementById('input-4').addEventListener('keypress', bloquearNumeros);

                    document.querySelector('form').addEventListener('submit', function(event) {
                        const senha = document.getElementById('input-6').value;
                        const confirmSenha = document.getElementById('input-6-5').value;
                        const senhaForte = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/;

                        if (senha !== confirmSenha) {
                            alert('As senhas não coincidem.');
                            event.preventDefault();
                        } else if (!senhaForte.test(senha)) {
                            alert('A senha deve ter pelo menos 10 caracteres, incluindo uma letra, um número e um caractere especial.');
                            event.preventDefault();
                        }
                    });
                </script>
                <script src="Validacep.js"></script>
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
