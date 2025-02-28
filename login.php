<?php
session_start();

$host = "localhost"; // Host do banco de dados externo
$port = 3306; // Porta do banco de dados
$dbname = "ecommerce"; // Nome do banco de dados
$user = "ecommerce"; // Usuário do banco de dados
$password = "ecommerce"; // Senha do banco de dados
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Verificar se o usuário está logado
$cliente_logado = isset($_SESSION['cliente_id']);

// Processar o formulário de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Buscar o cliente no banco de dados
    $stmt = $pdo->prepare('SELECT id, senha FROM clientes WHERE email = ?');
    $stmt->execute([$email]);
    $cliente = $stmt->fetch();

    if ($cliente && password_verify($senha, $cliente['senha'])) {
        // Login bem-sucedido: armazenar o cliente_id na sessão
        $_SESSION['cliente_id'] = $cliente['id'];
        header('Location: carrinho.php'); // Redirecionar para o carrinho
        exit();
    } else {
        echo "E-mail ou senha incorretos.";
    }
}

// Processar o logout
if (isset($_GET['logout'])) {
    session_destroy(); // Destruir a sessão
    header('Location: login.php'); // Redirecionar para a página de login
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="login.css"> <!-- Link para o arquivo CSS externo -->
</head>
<body>
    <!-- Links de Cadastre-se e Sair no canto superior direito -->
    <div class="user-actions">
        <?php if ($cliente_logado): ?>
            <a href="?logout=1" class="btn-sair">Sair</a>
        <?php else: ?>
            <a href="cadastro.php" class="btn-cadastro">Cadastre-se</a>
        <?php endif; ?>
    </div>

    <h1>Login</h1>
    <form method="post">
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>