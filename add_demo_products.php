<?php
$servername = "192.168.18.193"; // Atualize para o novo endereço do servidor
$username = "espetacular"; // Use novo nome de usuário
$password = "superevoltado"; // Use nova senha
$dbname = "leonardogamer.blog"; // Mantenha o nome do banco de dados o mesmo

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Produtos de demonstração
$produtos = [
    ['nome' => 'Produto 1', 'descricao' => 'Descrição do Produto 1', 'preco' => 10.00, 'imagem' => 'url_da_imagem_1.jpg'],
    ['nome' => 'Produto 2', 'descricao' => 'Descrição do Produto 2', 'preco' => 20.00, 'imagem' => 'url_da_imagem_2.jpg'],
    ['nome' => 'Produto 3', 'descricao' => 'Descrição do Produto 3', 'preco' => 30.00, 'imagem' => 'url_da_imagem_3.jpg'],
];

// Insere os produtos no banco de dados
foreach ($produtos as $produto) {
    $sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssds", $produto['nome'], $produto['descricao'], $produto['preco'], $produto['imagem']);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo "Produtos de demonstração adicionados com sucesso!";
?>
