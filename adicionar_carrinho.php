<?php
session_start();

$host = "localhost"; // Host do banco de dados externos
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'];
    $quantidade = $_POST['quantidade'];
    $cliente_id = 1; // Supondo que o cliente com ID 1 está logado

    // Verificar se o produto já está no carrinho
    $stmt = $pdo->prepare('SELECT * FROM carrinho WHERE cliente_id = ? AND produto_id = ?');
    $stmt->execute([$cliente_id, $produto_id]);
    $item = $stmt->fetch();

    if ($item) {
        // Atualizar a quantidade
        $nova_quantidade = $item['quantidade'] + $quantidade;
        $stmt = $pdo->prepare('UPDATE carrinho SET quantidade = ? WHERE id = ?');
        $stmt->execute([$nova_quantidade, $item['id']]);
    } else {
        // Inserir novo item no carrinho
        $stmt = $pdo->prepare('INSERT INTO carrinho (cliente_id, produto_id, quantidade) VALUES (?, ?, ?)');
        $stmt->execute([$cliente_id, $produto_id, $quantidade]);
    }

    header('Location: carrinho.php');
    exit;
}