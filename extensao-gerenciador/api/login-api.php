<?php
// Habilita CORS (acesso da extensão)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Caminho até o php.ini
$url = realpath(__DIR__ . '/../../'); // sobe até /gerapass
$config = parse_ini_file($url . '/includes/webdev/php.ini', true);

// Verifica se conseguiu carregar config
if (!$config) {
    echo json_encode(["success" => false, "message" => "Erro ao carregar configurações."]);
    exit;
}

// Dados do banco
$host     = $config['database']['host'];
$dbname   = $config['database']['dbname'];
$username = $config['database']['user'];
$password = $config['database']['password'];
$charset  = 'utf8mb4';

// Conexão PDO
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro ao conectar ao banco de dados."]);
    exit;
}

// Lê os dados enviados em JSON
$input = json_decode(file_get_contents("php://input"), true);
$email = $input['email'] ?? '';
$senha = $input['password'] ?? '';

// Valida campos
if (empty($email) || empty($senha)) {
    echo json_encode(["success" => false, "message" => "Preencha e-mail e senha."]);
    exit;
}

// Busca usuário
$stmt = $conn->prepare("SELECT id, nome, email, senha FROM admin_usuario WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica senha
if ($user && password_verify($senha, $user['senha'])) {
    // Gera token simples (apenas o ID)
    $token = $user['id'];

    echo json_encode([
        "success" => true,
        "token" => $token,
        "usuario" => [
            "id" => $user['id'],
            "nome" => $user['nome'],
            "email" => $user['email']
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "E-mail ou senha inválidos."]);
}
