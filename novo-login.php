<?php 
    require_once 'includes/actions/session_check.php';

    $h1      	 = "Sistema Gerenciador de Senhas";
    $title    	 = "Sistema Gerenciador de Senhas";
    $description = "Sistema Gerenciador de Senhas";
    $keywords    = $title;

    $tfp_css_paginas = array(
        "paginas/novo-login",
        "elementos/widget",
        "elementos/bar-btn",
    );

    $tfp_js_paginas = [
        "customJS/gerarSenha",
    ];
    
    include "includes/configuracoes.php";
    include "includes/date-widget.php";

?>
</head>
<body class="bg-dark">

    <main>

        <?php include "includes/widget.php"; ?>
        <div class="container">
            <hr class="divider-top">

            <h2>Novo Login</h2>
            <div class="row flex">
                <form method="POST" action="<?php echo $url; ?>includes/actions/save_login" class="row flex main-form">
                    <div class=" col-12 acesso">
                        <h2>Informações de Acesso</h2>

                        <label for="site">Insira o nome do Site: *</label>
                        <input type="text" id="site" name="site" required placeholder="ex: google.com">
                        
                        <label for="login">Insira o nome de Login: *</label>
                        <input type="text" id="login" name="login" required placeholder="ex: usuario@usuario.com">
                        
                        <hr>

                        <h3>Gerar Senha</h3>
                        <div class="print">

                            <div class="checkboxes">
                                <p>Selecione os tipos de caracteres desejados: *</p>
                                <label><input type="checkbox" id="maiusculas" > Incluir letras maiúsculas</label>
                                <label><input type="checkbox" id="minusculas" > Incluir letras minúsculas</label>
                                <label><input type="checkbox" id="numeros" > Incluir números</label>
                                <label><input type="checkbox" id="simbolos"> Incluir símbolos</label>
                            </div>

                            <label for="tamanho">Tamanho da senha: *</label>
                            <input type="number" id="tamanho" name="tamanho" required
                                    placeholder="Digite um número de até 32">
                            <hr>
                            <h3>Sua senha:</h3>
                            <div class="flex-container">
                                <input type="text" id="senha" name="senha" readonly placeholder="Sua senha aparecerá aqui!" required>
                                <button type="button" id="gerar">Gerar Senha</button>
                            </div>
                    
                        
                            <div class="flex buttons">
                                <button type="submit" id="salvar">Criar Login</button>
                                <button type="button" id="copiar">Copiar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include "includes/bar-buttons.php"; ?>

    </main>
    
    <script>
    <?php echo $tfp->tfpJsMinify($tfp_js_paginas ?? null); ?>
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const msg = document.getElementById('mensagem-save');
            if (msg) {
                setTimeout(() => {
                msg.style.display = 'none';
                }, 4000);
            }
        });
    </script>

</body>
</html>