document.querySelector('form').addEventListener('submit', (event) => {
    const nome = document.getElementById('input-1').value.trim();
    const cpf = document.getElementById('input-5').value.trim();
    const senha = document.getElementById('input-6').value;
    const confirmSenha = document.getElementById('input-6-5').value;
    const email = document.getElementById('input-8').value.trim();
    const celular = document.getElementById('cel').value.trim();
    const telefoneFixo = document.getElementById('tel').value.trim();

    // Função auxiliar para exibir alertas de validação
    const exibirErro = (mensagem) => {
        alert(mensagem);
        event.preventDefault();
    };

    // Validação do nome
    if (nome.length < 3) {
        exibirErro('O nome deve ter pelo menos 3 caracteres.');
    }

    // Validação do CPF
    if (!validarCPF(cpf)) {
        exibirErro('Por favor, insira um CPF válido.');
    }

    // Validação das senhas
    if (senha !== confirmSenha) {
        exibirErro('As senhas não coincidem.');
    }

    // Validação de email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        exibirErro('Por favor, insira um e-mail válido.');
    }

    // Validação do celular
    const celularPattern = /^\(\d{2}\) \d{5}-\d{4}$/;
    if (!celularPattern.test(celular)) {
        exibirErro('Por favor, insira um celular no formato correto: (xx) xxxxx-xxxx.');
    }

    // Validação do telefone fixo
    const telefoneFixoPattern = /^\(\d{2}\) \d{4}-\d{4}$/;
    if (telefoneFixo && !telefoneFixoPattern.test(telefoneFixo)) {
        exibirErro('Por favor, insira um telefone fixo no formato correto: (xx) xxxx-xxxx.');
    }
});

// Permitir apenas números
function apenasNumeros(event) {
    const charCode = event.charCode || event.keyCode;
    if (!/^[0-9]$/.test(String.fromCharCode(charCode)) && ![8, 9, 46].includes(charCode)) {
        event.preventDefault();
    }
}

// Máscara do CPF
function mascaraCPF(cpf) {
    cpf = cpf.replace(/\D/g, "");
    if (cpf.length > 11) cpf = cpf.slice(0, 11);
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return cpf;
}

// Máscara de telefone e celular
function mascaraTelefone(telefone, isCelular = false) {
    telefone = telefone.replace(/\D/g, "");
    if (isCelular) {
        telefone = telefone.slice(0, 11);
        telefone = telefone.replace(/(\d{2})(\d)/, "($1) $2");
        telefone = telefone.replace(/(\d{5})(\d{1,4})$/, "$1-$2");
    } else {
        telefone = telefone.slice(0, 10);
        telefone = telefone.replace(/(\d{2})(\d)/, "($1) $2");
        telefone = telefone.replace(/(\d{4})(\d{1,4})$/, "$1-$2");
    }
    return telefone;
}

// Máscara da data (DD/MM/AAAA)
function mascaraData(data) {
    data = data.replace(/\D/g, "");
    if (data.length > 8) data = data.slice(0, 8);
    if (data.length > 2) data = data.replace(/(\d{2})(\d)/, "$1/$2");
    if (data.length > 5) data = data.replace(/(\d{2})\/(\d{2})(\d)/, "$1/$2/$3");
    return data;
}

// Aplicar as máscaras e validações nos campos
document.getElementById('date').addEventListener('input', (event) => {
    event.target.value = mascaraData(event.target.value);
});
document.getElementById('date').addEventListener('keydown', apenasNumeros);

document.getElementById('input-5').addEventListener('input', (event) => {
    event.target.value = mascaraCPF(event.target.value);
});
document.getElementById('input-5').addEventListener('keydown', apenasNumeros);

document.getElementById('cel').addEventListener('input', (event) => {
    event.target.value = mascaraTelefone(event.target.value, true);
});
document.getElementById('cel').addEventListener('keydown', apenasNumeros);

document.getElementById('tel').addEventListener('input', (event) => {
    event.target.value = mascaraTelefone(event.target.value);
});
document.getElementById('tel').addEventListener('keydown', apenasNumeros);

// Função para validar CPF
function validarCPF(cpf) {
    cpf = cpf.replace(/\D/g, "");

    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        return false;
    }

    let soma = 0;
    let resto;

    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) {
        return false;
    }

    soma = 0;
    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) {
        return false;
    }

    return true;
}
