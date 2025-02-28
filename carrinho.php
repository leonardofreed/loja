<?php
session_start();

// Verificar se o cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header('Location: login.php'); // Redirecionar para o login
    exit();
}

$cliente_id = $_SESSION['cliente_id'];

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

// Buscar informações do cliente (incluindo o bairro)
$stmt_cliente = $pdo->prepare('SELECT bairro FROM clientes WHERE id = ?');
$stmt_cliente->execute([$cliente_id]);
$cliente = $stmt_cliente->fetch();

if (!$cliente) {
    die('Cliente não encontrado.');
}

$bairro_cliente = $cliente['bairro'];

// Buscar a taxa de entrega do bairro do cliente
$stmt_taxa = $pdo->prepare('SELECT taxa FROM taxas_entrega WHERE bairro = ?');
$stmt_taxa->execute([$bairro_cliente]);
$taxa_entrega = $stmt_taxa->fetchColumn(); // Retorna a taxa ou false se não existir

if ($taxa_entrega === false) {
    $taxa_entrega = 0.00; // Taxa padrão (ou ajuste conforme necessário)
    $mensagem_erro = "Taxa de entrega não encontrada para o bairro: " . htmlspecialchars($bairro_cliente);
} else {
    $mensagem_erro = ""; // Sem erro
}

// Buscar itens do carrinho
$stmt_carrinho = $pdo->prepare('SELECT carrinho.*, produtos.nome, produtos.preco, produtos.imagem FROM carrinho JOIN produtos ON carrinho.produto_id = produtos.id WHERE carrinho.cliente_id = ?');
$stmt_carrinho->execute([$cliente_id]);
$itens_carrinho = $stmt_carrinho->fetchAll();

$total = 0;

// Calcular o total dos itens
foreach ($itens_carrinho as $item) {
    $total += $item['preco'] * $item['quantidade'];
}

// Calcular o total com a taxa de entrega
$total_com_entrega = $total + $taxa_entrega;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="carrinho.css"> <!-- Link para o arquivo CSS externo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Ícones do FontAwesome -->
</head>
<body>
    <h1>Carrinho de Compras</h1>
    <div class="carrinho-container">
        <?php if (!empty($mensagem_erro)): ?>
            <p class="mensagem-erro"><?php echo $mensagem_erro; ?></p>
        <?php endif; ?>

        <?php if (empty($itens_carrinho)): ?>
            <p class="carrinho-vazio">Seu carrinho está vazio.</p>
        <?php else: ?>
            <ul class="lista-carrinho">
                <?php foreach ($itens_carrinho as $item): ?>
                    <li class="item-carrinho">
                        <div class="item-imagem">
                            <img src="<?php echo htmlspecialchars($item['imagem']); ?>" alt="<?php echo htmlspecialchars($item['nome']); ?>">
                        </div>
                        <div class="item-info">
                            <h2><?php echo htmlspecialchars($item['nome']); ?></h2>
                            <p>Quantidade: <?php echo $item['quantidade']; ?></p>
                            <p>Preço Unitário: R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></p>
                            <p>Subtotal: R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></p>
                        </div>
                        <form action="remover_carrinho.php" method="post" class="form-remover">
                            <input type="hidden" name="carrinho_id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="btn-remover">
                                <i class="fas fa-trash"></i> Remover
                            </button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Exibir o total com a taxa de entrega -->
            <div class="total-container">
                <p>Subtotal: R$ <?php echo number_format($total, 2, ',', '.'); ?></p>
                <p>Taxa de entrega (<?php echo htmlspecialchars($bairro_cliente); ?>): R$ <?php echo number_format($taxa_entrega, 2, ',', '.'); ?></p>
                <h3>Total com entrega: R$ <?php echo number_format($total_com_entrega, 2, ',', '.'); ?></h3>
                <a href="finalizar_compra.php" class="btn-finalizar">Finalizar Compra</a>
            </div>
        <?php endif; ?>
    </div>
    <a href="index.php" class="btn-continuar">Continuar Comprando</a>

    <script>
        // Adicionando interatividade com JavaScript
        document.querySelectorAll('.btn-remover').forEach(button => {
            button.addEventListener('click', (e) => {
                if (!confirm('Tem certeza que deseja remover este item do carrinho?')) {
                    e.preventDefault(); // Cancela o envio do formulário se o usuário não confirmar
                }
            });
        });
    </script>
</body>
</html>