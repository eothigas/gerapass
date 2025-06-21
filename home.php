<?php 
    require_once 'includes/actions/session_check.php';

    $h1      	 = "Sistema Gerenciador de Senhas";
    $title    	 = "Sistema Gerenciador de Senhas";
    $description = "Sistema Gerenciador de Senhas";
    $keywords    = $title;

    $tfp_css_paginas = array(
        "paginas/home",
        "elementos/bar-btn",
        "elementos/widget",
    );

    $tfp_js_paginas = [
        // "customJS/gerarSenha",
    ];
    
    include "includes/configuracoes.php";
    include "includes/date-widget.php";

?>
</head>
<body class="bg-dark">

    <main> 
        <?php include "includes/widget.php"; ?>

        <div class="container" id="present">
            <div class="row flex">
                <div class="col-10 col-md-4">
                    <img src="<?php echo $url;?>imagens/main/security.png" alt="Imagem de segurança" class="img-responsive">
                </div>
                <div class="col-10 col-md-8">
                    <h2>Sistema <span>GeraPass</span></h2>
                    <p>Sistema desenvolvido para gerenciamento, criação e segurança de senhas.</p>
                    <a href="<?php echo $url; ?>novo-login" title="Criar Novo Login">Criar Login</a>
                </div>
            </div>
        </div>
 
        <?php include "includes/bar-buttons.php"; ?>
    
    <script>
    <?php echo $tfp->tfpJsMinify($tfp_js_paginas ?? null); ?>
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>