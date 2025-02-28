<?php
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

// Buscar produtos
$stmt = $pdo->query('SELECT * FROM produtos');
$produtos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Produtos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link para o arquivo CSS externo -->
</head>
<body>
    <h1>Catálogo de Produtos</h1>
    <div class="produtos-container">
        <?php foreach ($produtos as $produto): ?>
            <div class="produto">
                <!-- Exibir a imagem do produto -->
                <?php if (!empty($produto['imagem'])): ?>
                    <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="produto-imagem">
                <?php else: ?>
                    <img src="caminho/para/imagem-padrao.jpg" alt="Imagem padrão" class="produto-imagem">
                <?php endif; ?>
                <h2><?php echo htmlspecialchars($produto['nome']); ?></h2>
                <p><?php echo htmlspecialchars($produto['descricao']); ?></p>
                <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                <form action="adicionar_carrinho.php" method="post">
                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                    <label for="quantidade">Quantidade:</label>
                    <input type="number" id="quantidade" name="quantidade" value="1" min="1">
                    <button type="submit">Adicionar ao Carrinho</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="carrinho.php" class="ver-carrinho">Ver Carrinho</a>
</body>
</html>