<?php
// Habilita CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Carrega config
$config = parse_ini_file(__DIR__ . '/../../includes/webdev/php.ini', true);
if (!$config || empty($config['security']['aes_key'])) {
    echo json_encode(["success" => false, "message" => "Chave de criptografia ausente."]);
    exit;
}

$aes_key = $config['security']['aes_key'];

// Conexão com o banco
$db = $config['database'];
$dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4";

try {
    $conn = new PDO($dsn, $db['user'], $db['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro ao conectar ao banco: " . $e->getMessage()]);
    exit;
}

// Recebe token via JSON
$input = json_decode(file_get_contents("php://input"), true);
$token = $input['token'] ?? '';

if (empty($token)) {
    echo json_encode(["success" => false, "message" => "Token ausente."]);
    exit;
}

// Decodifica token
$usuario_id = (int) $token; // sem base64, como você pediu
if ($usuario_id <= 0) {
    echo json_encode(["success" => false, "message" => "Token inválido."]);
    exit;
}

// Função para descriptografar
function descriptografar($dados_base64, $chave) {
    $dados = base64_decode($dados_base64);
    $iv = substr($dados, 0, 16);
    $criptografado = substr($dados, 16);
    return openssl_decrypt($criptografado, 'AES-256-CBC', $chave, OPENSSL_RAW_DATA, $iv);
}

// Busca logins do usuário
try {
    $stmt = $conn->prepare("SELECT nome, login, senha FROM logins WHERE admin_usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Descriptografa cada senha
    $senhas = array_map(function ($linha) use ($aes_key) {
        return [
            "site"  => $linha['nome'],
            "login" => $linha['login'],
            "senha" => descriptografar($linha['senha'], $aes_key)
        ];
    }, $registros);

    echo json_encode(["success" => true, "senhas" => $senhas]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro ao buscar senhas: " . $e->getMessage()]);
}
