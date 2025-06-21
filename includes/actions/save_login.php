<?php
session_start();

$config = parse_ini_file(__DIR__ . '/../../includes/webdev/php.ini', true);
if (!$config || empty($config['security']['aes_key'])) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Chave de criptografia não definida.'];
    header('Location: formulario.php');
    exit;
}

$aes_key = $config['security']['aes_key'];

$dbConfig = $config['database'];
$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro na conexão: ' . $e->getMessage()];
    header('Location: ../../novo-login');
    exit;
}

$site  = trim(filter_input(INPUT_POST, 'site', FILTER_SANITIZE_STRING));
$login = trim(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING));
$senha = trim(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT));

if (!$site || !$login || !$senha) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Preencha todos os campos obrigatórios!'];
    header('Location: ../../novo-login');
    exit;
}

function criptografar($texto, $chave) {
    $iv = openssl_random_pseudo_bytes(16);
    $criptografado = openssl_encrypt($texto, 'AES-256-CBC', $chave, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $criptografado);
}

$senha_criptografada = criptografar($senha, $aes_key);

$colecao_id = 1;
$admin_usuario_id = $_SESSION['id'] ?? null;

try {
    // Verifica se o nome já existe
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM logins WHERE nome = ?");
    $stmt->execute([$site]);
    $existe = $stmt->fetchColumn();

    if ($existe > 0) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Já existe um login igual ao inserido. Por favor, digite dados diferentes.'];
        header('Location: ../../novo-login');
        exit;
    }

    // Insere se não existir
    $stmt = $pdo->prepare("INSERT INTO logins (nome, login, senha, criado, colecao_id, admin_usuario_id) VALUES (?, ?, ?, NOW(), ?, ?)");
    $stmt->execute([$site, $login, $senha_criptografada, $colecao_id, $admin_usuario_id]);

    $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Login salvo com sucesso!'];
    header('Location: ../../novo-login');
    exit;
} catch (PDOException $e) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao salvar login: ' . $e->getMessage()];
    header('Location: ../../novo-login');
    exit;
}
