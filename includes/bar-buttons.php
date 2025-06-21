<div class="button-container">
    <a href="<?php echo $url;?>home" class="button" title="Home">
        <i class="bi bi-house icon"></i>
        <span class="label">Home</span>
    </a>
    <a href="<?php echo $url;?>colecoes" class="button" title="Coleções">
        <i class="bi bi-collection icon"></i>
        <span class="label">Coleções</span>
    </a>
    <a href="<?php echo $url;?>configuracoes" class="button" title="Configurações">
        <i class="bi bi-gear icon"></i>
        <span class="label">Config</span>
    </a>
    <form action="<?php echo $url; ?>includes/actions/logout" method="post" style="display: inline;">
        <button type="submit" class="button" title="Sair">
            <i class="bi bi-door-open icon"></i>
            <span class="label">Sair</span>
        </button>
    </form>
</div>
