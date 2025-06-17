<?php
    session_start();

    // URLs de ambiente
    $local     = "http://localhost/_Dev/gerapass/";
    $producao  = "https://www.tfportifolio.com.br/gerapass/";

    // Define URL conforme o ambiente
    $url = ($_SERVER['HTTP_HOST'] === 'localhost') ? $local : $producao;

    $codigoAnalytics = 'G-';
    $canonical       = $url;
    $image_url       = 'imagens/logo.png';

    // DADOS

    $logo_site = 'imagens/logo.png';
    $nome_site = 'GeraPass';


    include "webdev/class.webdev.php";

    $tfp = new TFPCFG();
    $tfp->tfp_url = "";
    $tfp->tfp_assets_dir = "assets/";
    $tfp->tfp_css_padrao = array(
        "padrao/global",
        "padrao/reset",
        "padrao/slicknav.min",
    );
    $tfp->tfp_js_padrao = array(
        "padrao/jquery-3.6.0.min",
        "padrao/jquery.slicknav.min",
    );

    // Minifica e imprime o CSS no <head>
    $tfp->tfpCssMinify(isset($tfp_css_paginas) ? $tfp_css_paginas : null);

    // Scripts JS minificados: padrão
    $tfp->tfpJsMinify($tfp_js_paginas ?? null);

    include "webdev/head.webdev.min.php";
?>