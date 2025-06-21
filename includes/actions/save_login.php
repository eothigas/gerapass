<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Carrega o arquivo de configuração
$config = parse_ini_file(__DIR__ . '/../../includes/webdev/php.ini', true);
if (!$config || empty($config['security']['aes_key'])) {
    die(json_encode(['status' => 'error', 'message' => 'Chave de criptografia não definida.']));
}

$aes_key = $config['security']['aes_key'];

// Dados do banco
$dbConfig = $config['database'];
$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Erro na conexão: ' . $e->getMessage()]));
}

// Recebe e valida os dados do POST
$site  = trim(filter_input(INPUT_POST, 'site', FILTER_SANITIZE_STRING));
$login = trim(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING));
$senha = trim(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT));

if (!$site || !$login || !$senha) {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos obrigatórios!']);
    exit;
}

// Criptografa a senha com AES-256-CBC
function criptografar($texto, $chave) {
    $iv = openssl_random_pseudo_bytes(16); // IV de 16 bytes
    $criptografado = openssl_encrypt($texto, 'AES-256-CBC', $chave, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $criptografado); // Salva IV + conteúdo criptografado
}

$senha_criptografada = criptografar($senha, $aes_key);

// IDs fixos ou vindos da sessão
$colecao_id = 1;
$admin_usuario_id = $_SESSION['id'] ?? null;

if (!$admin_usuario_id) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não autenticado.']);
    exit;
}

// Insere no banco
try {
    $stmt = $pdo->prepare("INSERT INTO logins (nome, login, senha, criado, colecao_id, admin_usuario_id) VALUES (?, ?, ?, NOW(), ?, ?)");
    $stmt->execute([$site, $login, $senha_criptografada, $colecao_id, $admin_usuario_id]);

    echo json_encode(['status' => 'success', 'message' => 'Login salvo com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar login: ' . $e->getMessage()]);
}
