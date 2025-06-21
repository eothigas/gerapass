document.addEventListener('DOMContentLoaded', () => {
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

  function exibirMensagem(texto, tipo = 'sucesso') {
    const mensagemDiv = document.getElementById('mensagem');
    mensagemDiv.textContent = texto;
    mensagemDiv.className = `mensagem ${tipo}`;
    mensagemDiv.style.display = 'block';
    setTimeout(() => {
      mensagemDiv.style.display = 'none';
    }, 4000);
  }

  

  document.getElementById('gerar').addEventListener('click', () => {
    const tamanhoInput = document.getElementById('tamanho');
    const tamanho = parseInt(tamanhoInput.value, 10);
    if (isNaN(tamanho) || tamanho < 4 || tamanho > 32) {
      exibirMensagem('Informe um tamanho válido entre 4 e 32.', 'erro');
      tamanhoInput.focus();
      return;
    }

    const usarMaiusculas = document.getElementById('maiusculas').checked;
    const usarMinusculas = document.getElementById('minusculas').checked;
    const usarNumeros = document.getElementById('numeros').checked;
    const usarSimbolos = document.getElementById('simbolos').checked;

    const senha = gerarSenhaPersonalizada(tamanho, usarMaiusculas, usarMinusculas, usarNumeros, usarSimbolos);
    if (senha.startsWith('⚠️')) {
      exibirMensagem(senha, 'erro');
      return;
    }
    document.getElementById('senha').value = senha;
  });

  document.getElementById('copiar').addEventListener('click', () => {
    const senhaInput = document.getElementById('senha');
    if (!senhaInput.value) {
      exibirMensagem('Nenhuma senha para copiar!', 'erro');
      return;
    }
    senhaInput.select();
    senhaInput.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(senhaInput.value).then(() => {
      exibirMensagem('Senha copiada para a área de transferência!', 'sucesso');
    });
  });
});
