<?php
session_start();

$timeout = 1800; // 30 minutos de inatividade

// Verifica se está logado
if (!isset($_SESSION['id'])) {
    header("Location: /gerapass/");
    exit();
}

// Verifica timeout
if (isset($_SESSION['ultimo_acesso']) && (time() - $_SESSION['ultimo_acesso']) > $timeout) {
    // Sessão expirada por inatividade
    session_unset();
    session_destroy();
    header("Location: /gerapass/");
    exit();
}

// Atualiza timestamp do último acesso
$_SESSION['ultimo_acesso'] = time();
