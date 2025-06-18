function gerarSenhaPersonalizada(tamanho, usarMaiusculas, usarMinusculas, usarNumeros, usarSimbolos) {
    let caracteres = '';
    if (usarMinusculas) caracteres += 'abcdefghijklmnopqrstuvwxyz';
    if (usarMaiusculas) caracteres += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (usarNumeros) caracteres += '0123456789';
    if (usarSimbolos) caracteres += '!@#$%^&*()-_=+[]{}<>?/';

    if (caracteres.length === 0) return '⚠️ Selecione pelo menos um tipo de caractere.';

    let senha = '';
    for (let i = 0; i < tamanho; i++) {
      senha += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    return senha;
  }

  document.getElementById('gerar').addEventListener('click', () => {
    const tamanhoInput = document.getElementById('tamanho');
    const tamanho = parseInt(tamanhoInput.value, 10);
    if (isNaN(tamanho) || tamanho < 4 || tamanho > 32) {
      alert('Informe um tamanho válido entre 4 e 32.');
      tamanhoInput.focus();
      return;
    }

    const usarMaiusculas = document.getElementById('maiusculas').checked;
    const usarMinusculas = document.getElementById('minusculas').checked;
    const usarNumeros = document.getElementById('numeros').checked;
    const usarSimbolos = document.getElementById('simbolos').checked;

    const senha = gerarSenhaPersonalizada(tamanho, usarMaiusculas, usarMinusculas, usarNumeros, usarSimbolos);
    if (senha.startsWith('⚠️')) {
      alert(senha);
      return;
    }
    document.getElementById('senha').value = senha;

    salvarSenha(senha);
  });

  document.getElementById('copiar').addEventListener('click', () => {
    const senhaInput = document.getElementById('senha');
    if (!senhaInput.value) {
      alert('Nenhuma senha para copiar!');
      return;
    }
    senhaInput.select();
    senhaInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(senhaInput.value).then(() => {
      alert('Senha copiada para a área de transferência!');
    });
  });