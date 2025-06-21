<?php
session_start();

$url = realpath(__DIR__ . '/../../');
$config = parse_ini_file($url . '/includes/webdev/php.ini', true);

$email = $_POST['email'] ?? '';
$senha = $_POST['password'] ?? '';

if (!$config) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao carregar configurações do sistema.'];
    $_SESSION['old_email'] = $email;
    header("Location: ../../");
    exit();
}

$host     = $config['database']['host'];
$dbname   = $config['database']['dbname'];
$username = $config['database']['user'];
$password = $config['database']['password'];
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Erro ao conectar ao banco de dados: ' . $e->getMessage()];
    $_SESSION['old_email'] = $email;
    header("Location: ../../");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($email) || empty($senha)) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Preencha todos os campos.'];
        $_SESSION['old_email'] = $email;
        header("Location: ../../");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM admin_usuario WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        session_regenerate_id(true);

        $_SESSION['id'] = $user['id'];
        $_SESSION['nome'] = $user['nome'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['ultimo_acesso'] = time();

        header("Location: ../../home");
        exit();
    } else {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'E-mail ou senha inválidos.'];
        $_SESSION['old_email'] = $email;
        header("Location: ../../");
        exit();
    }
}
