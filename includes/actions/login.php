<?php
session_start();

// Caminho absoluto até o php.ini
$url = realpath(__DIR__ . '/../../'); // sobe até /gerapass
$config = parse_ini_file($url . '/includes/webdev/php.ini', true);

// Verifica se as configurações foram carregadas
if (!$config) {
    die("Erro ao carregar configurações do sistema.");
}

// Dados do banco de dados
$host     = $config['database']['host'];
$dbname   = $config['database']['dbname'];
$username = $config['database']['user'];
$password = $config['database']['password'];
$charset  = 'utf8mb4';

// Conexão com o banco de dados via PDO
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Processa o formulário se foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['password'] ?? '';

    // Verifica campos
    if (empty($email) || empty($senha)) {
        die("Preencha todos os campos.");
    }

    // Busca o usuário pelo email
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM admin_usuario WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifica se achou e se a senha confere
    if ($user && password_verify($senha, $user['senha'])) {
        session_regenerate_id(true); // Regenera ID da sessão para evitar fixation

        $_SESSION['id']    = $user['id'];
        $_SESSION['nome']  = $user['nome'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['ultimo_acesso'] = time(); // timestamp para timeout

        header("Location: ../../home");
        exit();
    } else {
        $_SESSION['erro_login'] = "E-mail ou senha inválidos.";
        header("Location: ../../");
        exit();
    }
}
?>
