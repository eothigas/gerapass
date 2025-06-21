<?php 
    require_once 'includes/actions/session_check.php';

    $h1      	 = "Sistema Gerenciador de Senhas";
    $title    	 = "Sistema Gerenciador de Senhas";
    $description = "Sistema Gerenciador de Senhas";
    $keywords    = $title;

    $tfp_css_paginas = array(
        "paginas/home",
        "elementos/bar-btn",
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
        <div class="container" id="home">
            <div class="row flex align-items-start">
                <div class="col-10 col-md-9 col-lg-9">
                    <div class="welcome">
                        <h4>Bem vindo</h4>
                        <h2 style="color: var(--secondary);"><?php echo $_SESSION['nome'] ?? 'Usuário' ?>!</h2>
                    </div>
                </div>
                <div class="col-10 col-md-3 col-lg-3">
                    <div class="card <?php echo $classes['card_class']; ?>">
                        <p class="time-text"><span><?php echo horaAtualComFuso($fuso); ?></span></p>
                        <p class="day-text"><?php echo diaFormatadoComFuso($fuso); ?></p>
                        <i class="bi bi-moon moon <?php echo $classes['moon_class']; ?>"></i>
                        <i class="bi bi-sun sun <?php echo $classes['sun_class']; ?>"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="container" id="present">
            <div class="row flex">
                <div class="col-10 col-md-4">
                    <img src="<?php echo $url;?>imagens/main/security.png" alt="Imagem de segurança" class="img-responsive">
                </div>
                <div class="col-10 col-md-8">
                    <h2>Sistema <span>GeraPass</span></h2>
                    <p>Sistema desenvolvido para gerenciamento, criação e segurança de senhas.</p>
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