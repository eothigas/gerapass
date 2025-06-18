<?php 
    $h1      	 = "Sistema Gerenciador de Senhas";
    $title    	 = "Sistema Gerenciador de Senhas";
    $description = "Sistema Gerenciador de Senhas";
    $keywords    = $title;

    $tfp_css_paginas = array(
        "paginas/home",
    );

    $tfp_js_paginas = [
        "customJS/gerarSenha",
    ];
    
    include "includes/configuracoes.php";

?>
</head>
<body>

    <main>
        <div class="container">
            <div class="row gap-2 flex">
                <div class="col-sm-10 col-md-10 col-lg-10 acesso">
                    <h2>Informações de Acesso</h2>
                    
                    <label for="site">Insira o nome do Site: *</label>
                    <input type="text" id="site">

                    <label for="login">Insira o nome de Login: *</label>
                    <input type="text" id="login">
                </div>
                <div class="col-sm-10 col-md-10 col-lg-10 principal">
                    <h2>Gerar Senha</h2>
                    <div class="print">
                        <label for="tamanho">Tamanho da senha: *</label>
                        <input type="number" id="tamanho" max="32"
                        oninput="this.value = Math.max(0, Math.min(32, this.value))"
                        required placeholder="Digite um número de 4 a 32">

                        <div class="checkboxes">
                            <p>Selecione os tipos de caracteres desejados: *</p>
                            <label><input type="checkbox" id="maiusculas"> Incluir letras maiúsculas</label>
                            <label><input type="checkbox" id="minusculas"> Incluir letras minúsculas</label>
                            <label><input type="checkbox" id="numeros"> Incluir números</label>
                            <label><input type="checkbox" id="simbolos"> Incluir símbolos</label>
                        </div>
                        <hr>
                        <h2>Sua senha: </h2>
                        <input type="text" id="senha" readonly placeholder="Sua senha aparecerá aqui!">
                    
                        <div class="flex buttons">
                            <button id="gerar">Gerar Senha</button> 
                            <button id="salvar">Salvar Senha</button> 
                            <button id="copiar">Copiar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Seu JS minificado carregado após as bibliotecas -->
    <script>
    <?php echo $tfp->tfpJsMinify($tfp_js_paginas ?? null); ?>
    </script>

    <!-- Bootstrap -->
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>