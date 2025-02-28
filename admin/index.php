<?php
include '../includes/auth.php'; // Verificar autenticação
include '../includes/db.php';  // Conexão com o banco de dados
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../styles/admin.css">
</head>
<body>
    <header>
        <h1>Painel Admin</h1>
        <nav>
            <a href="produtos.php">Produtos</a>
            <a href="clientes.php">Clientes</a>
            <a href="pedidos.php">Pedidos</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <h2>Bem-vindo ao Painel Admin</h2>
        <div class="stats">
            <div class="stat-card">
                <h3>Produtos</h3>
                <p><?php
                    $stmt = $pdo->query('SELECT COUNT(*) FROM produtos');
                    echo $stmt->fetchColumn();
                ?></p>
            </div>
            <div class="stat-card">
                <h3>Clientes</h3>
                <p><?php
                    $stmt = $pdo->query('SELECT COUNT(*) FROM clientes');
                    echo $stmt->fetchColumn();
                ?></p>
            </div>
            <div class="stat-card">
                <h3>Pedidos</h3>
                <p><?php
                    $stmt = $pdo->query('SELECT COUNT(*) FROM pedidos');
                    echo $stmt->fetchColumn();
                ?></p>
            </div>
        </div>
    </main>
</body>
</html>