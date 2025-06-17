<!-- footer.php -->
<footer class="bg-dark text-white mt-5">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-6">
                <h5><?php echo $nome_site; ?>  |  © <?php echo date("Y"); ?> Todos os direitos reservados.</h5>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white text-decoration-none me-3">Política de Privacidade</a>
                <a href="#" class="text-white text-decoration-none">Contato</a>
            </div>
        </div>
    </div>

    <?php if($_SERVER["SERVER_NAME"] != "localhost"){ ?>
        <!-- Código do Analytics aqui! -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $codigoAnalytics;?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', '<?php echo $codigoAnalytics;?>');
        </script>
    <?php } ?>
</footer>