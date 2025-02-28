<?php
session_start();

$host = "localhost"; // Host do banco de dados externo
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
    $carrinho_id = $_POST['carrinho_id'];

    $stmt = $pdo->prepare('DELETE FROM carrinho WHERE id = ?');
    $stmt->execute([$carrinho_id]);

    header('Location: carrinho.php');
    exit;
}