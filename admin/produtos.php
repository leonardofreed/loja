<?php
include '../includes/auth.php'; // Verificar autenticação
include '../includes/db.php';  // Conexão com o banco de dados

// Adicionar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $stmt = $pdo->prepare('INSERT INTO produtos (nome, descricao, preco) VALUES (?, ?, ?)');
    $stmt->execute([$nome, $descricao, $preco]);
}

// Excluir produto
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
    $stmt->execute([$id]);
}

// Buscar produtos
$stmt = $pdo->query('SELECT * FROM produtos');
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Produtos</title>
    <link rel="stylesheet" href="../styles/admin.css">
</head>
<body>
    <header>
        <h1>Gerenciar Produtos</h1>
        <nav>
            <a href="index.php">Dashboard</a>
            <a href="produtos.php">Produtos</a>
            <a href="clientes.php">Clientes</a>
            <a href="pedidos.php">Pedidos</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <h2>Adicionar Produto</h2>
        <form method="post">
            <input type="text" name="nome" placeholder="Nome" required>
            <textarea name="descricao" placeholder="Descrição" required></textarea>
            <input type="number" name="preco" step="0.01" placeholder="Preço" required>
            <button type="submit" name="adicionar">Adicionar</button>
        </form>

        <h2>Lista de Produtos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?php echo $produto['id']; ?></td>
                        <td><?php echo $produto['nome']; ?></td>
                        <td><?php echo $produto['descricao']; ?></td>
                        <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="editar_produto.php?id=<?php echo $produto['id']; ?>">Editar</a>
                            <a href="?excluir=<?php echo $produto['id']; ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>