<?php 
    $h1      	 = "Sistema Gerenciador de Senhas";
    $title    	 = "Sistema Gerenciador de Senhas";
    $description = "Sistema Gerenciador de Senhas";
    $keywords    = $title;

    $tfp_css_paginas = array(
        "paginas/home",
    );
    
    include "includes/configuracoes.php";

?>
</head>
<body>

    <main>
        
    </main>

    <script>
        <?php echo $tfp->tfpJsMinify($tfp_js_paginas ?? null); ?>
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>