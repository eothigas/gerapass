// Função para mostrar o nome do usuário logado na popup
function mostrarUsuarioLogado(nome) {
  document.getElementById('usuario-logado').textContent = `Olá, ${nome}`;
  document.getElementById('btn-sair').style.display = 'inline-block';  // mostra o botão sair
  document.getElementById('btn-login').style.display = 'none'; // esconde botão entrar
}

// Função para esconder dados do usuário e o botão sair
function limparUsuarioLogado() {
  document.getElementById('usuario-logado').textContent = '';
  document.getElementById('btn-sair').style.display = 'none';
  document.getElementById('lista-senhas').innerHTML = '';
  document.getElementById('btn-login').style.display = 'inline-block'; // mostra botão entrar
}

// Função para fazer login
    async function login() {
        const email = document.getElementById('usuario').value;
        const senha = document.getElementById('senha').value;
        console.log('Email:', email, 'Senha:', senha);  // <-- teste aqui

        if (!email || !senha) {
            document.getElementById('msg').textContent = "Preencha e-mail e senha.";
            return;
        }

  try {
    const resposta = await fetch('https://tfportifolio.com.br/gerapass/extensao-gerenciador/api/login-api', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email, password: senha })
    });

    const data = await resposta.json();

    if (data.success) {
      localStorage.setItem('token', data.token);
      localStorage.setItem('usuario', JSON.stringify(data.usuario));

      document.getElementById('msg').textContent = "Login realizado com sucesso!";
      mostrarUsuarioLogado(data.usuario.nome);

      listarSenhas();
    } else {
      document.getElementById('msg').textContent = data.message;
    }
  } catch (error) {
    document.getElementById('msg').textContent = "Erro na conexão: " + error.message;
  }
}

// Função para listar senhas
async function listarSenhas() {
  const token = localStorage.getItem('token');
  if (!token) {
    document.getElementById('msg').textContent = "Você precisa estar logado para ver as senhas.";
    return;
  }

  try {
    const resposta = await fetch('https://tfportifolio.com.br/gerapass/extensao-gerenciador/api/senhas-listar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ token })
    });

    const data = await resposta.json();

    if (data.success) {
      const lista = data.senhas.map(s => `<li><b>${s.site}</b>: ${s.login} / ${s.senha}</li>`).join('');
      document.getElementById('lista-senhas').innerHTML = `<ul>${lista}</ul>`;
      document.getElementById('msg').textContent = "";
    } else {
      document.getElementById('msg').textContent = data.message;
      document.getElementById('lista-senhas').innerHTML = "";
    }
  } catch (error) {
    document.getElementById('msg').textContent = "Erro ao buscar senhas: " + error.message;
  }
}

// Função para logout
function logout() {
  localStorage.removeItem('token');
  localStorage.removeItem('usuario');
  limparUsuarioLogado();
  document.getElementById('msg').textContent = "Você saiu da conta.";
}

// Configura eventos e verifica login na inicialização
window.onload = function() {
  document.getElementById('btn-login').addEventListener('click', login);
  document.getElementById('btn-sair').addEventListener('click', logout);

  const usuario = localStorage.getItem('usuario');
  if (usuario) {
    const usuarioObj = JSON.parse(usuario);
    mostrarUsuarioLogado(usuarioObj.nome);
    listarSenhas();
  } else {
    limparUsuarioLogado();
  }
};
