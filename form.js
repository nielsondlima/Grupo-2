document.querySelector('form').addEventListener('submit', (event) => {
    const nome = document.getElementById('input-1').value.trim();
    const cpf = document.getElementById('input-5').value.trim();
    const senha = document.getElementById('input-6').value;
    const confirmSenha = document.getElementById('input-6-5').value;
    const email = document.getElementById('input-8').value.trim();
    const celular = document.getElementById('cel').value.trim();
    const telefoneFixo = document.getElementById('tel').value.trim();

    // Validação do nome
    if (nome.length < 3) {
        alert('O nome deve ter pelo menos 3 caracteres.');
        event.preventDefault();
    }

    // Validação do CPF 
    if (!validarCPF(cpf)) {
        alert('Por favor, insira um CPF válido.');
        event.preventDefault();
    }

    // Validação das senhas
    if (senha !== confirmSenha) {
        alert('As senhas não coincidem.');
        event.preventDefault();
    }

    // Validação de email simples
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Por favor, insira um e-mail válido.');
        event.preventDefault();
    }

    // Validação do celular 
    const celularPattern = /^\(\d{2}\) \d{5}-\d{4}$/;
    if (!celularPattern.test(celular)) {
        alert('Por favor, insira um celular no formato correto (xx) xxxxx-xxxx.');
        event.preventDefault();
    }

    // Validação do telefone fixo 
    const telefoneFixoPattern = /^\(\d{2}\) \d{4}-\d{4}$/;
    if (!telefoneFixoPattern.test(telefoneFixo)) {
        alert('Por favor, insira um telefone fixo no formato correto (xx) xxxx-xxxx.');
        event.preventDefault();
    }
});

//permitir apenas numeros
function apenasNumeros(event) {
    const charCode = event.charCode || event.keyCode;
    if (charCode !== 8 && charCode !== 9 && charCode !== 46 && (charCode < 37 || charCode > 40) && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
}

//mascara do cpf
function mascaraCPF(cpf) {
    cpf = cpf.replace(/\D/g, ""); 
    if (cpf.length > 11) cpf = cpf.slice(0, 11);
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    return cpf;
}

//mascara do telefone e celular
function mascaraTelefone(telefone, isCelular = false) {
    telefone = telefone.replace(/\D/g, ""); 
    if (isCelular) {
        if (telefone.length > 11) telefone = telefone.slice(0, 11);
        telefone = telefone.replace(/(\d{2})(\d)/, "($1) $2");
        telefone = telefone.replace(/(\d{5})(\d{1,4})$/, "$1-$2");
    } else {
        if (telefone.length > 10) telefone = telefone.slice(0, 10);
        telefone = telefone.replace(/(\d{2})(\d)/, "($1) $2");
        telefone = telefone.replace(/(\d{4})(\d{1,4})$/, "$1-$2");
    }
    return telefone;
}

//mascara da data
function mascaraData(data) {
    data = data.replace(/\D/g, ""); 
    if (data.length > 8) data = data.slice(0, 8); 
    if (data.length > 2) data = data.replace(/(\d{2})(\d)/, "$1/$2"); 
    if (data.length > 5) data = data.replace(/(\d{2})\/(\d{2})(\d)/, "$1/$2/$3"); 
    return data;
}

//apenas números na data
document.getElementById('date').addEventListener('input', (event) => {
    event.target.value = mascaraData(event.target.value);
});
document.getElementById('date').addEventListener('keydown', apenasNumeros);

//aplicar a máscara e validar os números ao digitar
document.getElementById('input-5').addEventListener('input', (event) => {
    event.target.value = mascaraCPF(event.target.value);
});
document.getElementById('input-5').addEventListener('keydown', apenasNumeros);

document.getElementById('cel').addEventListener('input', (event) => {
    event.target.value = mascaraTelefone(event.target.value, true); // Celular
});
document.getElementById('cel').addEventListener('keydown', apenasNumeros);

document.getElementById('tel').addEventListener('input', (event) => {
    event.target.value = mascaraTelefone(event.target.value); // Telefone fixo
});
document.getElementById('tel').addEventListener('keydown', apenasNumeros);

//apenas cpf válido
function validarCPF(cpf) {
    // Remove a máscara
    cpf = cpf.replace(/\D/g, '');

    // Verifica se o CPF tem 11 dígitos e se não é uma sequência de números repetidos (como 111.111.111-11)
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
        return false;
    }

    let soma = 0;
    let resto;

    // Calcula o primeiro dígito verificador
    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) {
        return false;
    }

    soma = 0;

    // Calcula o segundo dígito verificador
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