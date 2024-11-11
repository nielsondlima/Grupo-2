document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, ''); 

    
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar CEP');
                }
                return response.json();
            })
            .then(data => {
                if (!data.erro) {
                    document.getElementById('endereco').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('cidade').value = data.localidade;
                } else {
                    alert('CEP não encontrado.');
                    clearFields();
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao buscar dados do CEP.');
                clearFields();
            });
    } else {
        alert('CEP inválido. Deve conter 8 dígitos.');
        clearFields();
    }
});