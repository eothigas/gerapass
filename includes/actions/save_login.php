<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Ajuste o caminho para seu arquivo de config com dados do banco
$config = parse_ini_file(__DIR__ . '/../../includes/webdev/php.ini', true);

if (!$config) {
    die(json_encode(['status' => 'error', 'message' => 'Erro ao carregar config do banco']));
}

try {
    $host = $config['database']['host'];
    $dbname = $config['database']['dbname'];
    $user = $config['database']['user'];
    $pass = $config['database']['password'];
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Erro na conexão: ' . $e->getMessage()]));
}

// Recebe dados do POST (use filter_input para segurança)
$site = trim(filter_input(INPUT_POST, 'site', FILTER_SANITIZE_STRING));
$login = trim(filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING));
$senha = trim(filter_input(INPUT_POST, 'senha', FILTER_DEFAULT)); // senha pode ter símbolos

// Validações básicas
if (!$site || !$login || !$senha) {
    echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos obrigatórios!']);
    exit;
}

// Você pode definir o colecao_id e admin_usuario_id aqui ou receber via POST também
// Exemplo fixo:
$colecao_id = 1; 
$admin_usuario_id = $_SESSION['id'] ?? null; // assume que admin está logado e tem ID na sessão

// Faz hash da senha para salvar com segurança
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir no banco
try {
    $sql = "INSERT INTO logins (nome, login, senha, criado, colecao_id, admin_usuario_id) VALUES (?, ?, ?, NOW(), ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$site, $login, $senha_hash, $colecao_id, $admin_usuario_id]);

    echo json_encode(['status' => 'success', 'message' => 'Login salvo com sucesso!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar login: ' . $e->getMessage()]);
}
