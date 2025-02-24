<?php
$servername = "leonardogamer.blog";
$username = "espetacular";
$password = "revoltado";
$dbname = "loja_db";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Recebe os dados do produto
$data = json_decode(file_get_contents("php://input"), true);
$name = $data['name'];
$description = $data['description'];
$price = $data['price'];
$image = $data['image'];

// Insere o produto no banco de dados
$sql = "INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssds", $name, $description, $price, $image);

if ($stmt->execute()) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => $stmt->error));
}

$stmt->close();
$conn->close();
?>
