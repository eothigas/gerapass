<?php 
    $h1      	 = "Sistema Gerenciador de Senhas";
    $title    	 = "Sistema Gerenciador de Senhas";
    $description = "Sistema Gerenciador de Senhas";
    $keywords    = $title;

    $tfp_css_paginas = array(
        "paginas/home",
    );

    $tfp_js_paginas = [
        "customJS/teste",
        "customJS/gerarSenha",
    ];
    
    include "includes/configuracoes.php";

?>
</head>
<body>

    <main>
        <div class="container">
            <div class="principal">
                <h2>Gerar Senha</h2>
                <div class="print">
                    <label for="tamanho">Tamanho da senha:</label>
                    <input type="number" id="tamanho" max="32"
                    oninput="this.value = Math.max(0, Math.min(32, this.value))"
                    required>

                    <div class="checkboxes">
                        <label><input type="checkbox" id="maiusculas"> Incluir letras maiúsculas</label>
                        <label><input type="checkbox" id="minusculas"> Incluir letras minúsculas</label>
                        <label><input type="checkbox" id="numeros"> Incluir números</label>
                        <label><input type="checkbox" id="simbolos"> Incluir símbolos</label>
                    </div>

                    <button id="gerar">Gerar Senha</button>
                    <input type="text" id="senha" readonly>

                    <button id="copiar">Copiar</button>
                </div>
            </div>
        </div>
    </main>

    <script>
        <?php echo $tfp->tfpJsMinify($tfp_js_paginas ?? null); ?>
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>