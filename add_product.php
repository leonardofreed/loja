<?php
$servername = "localhost"; // Update to the new server address
$username = "espetacular"; // Use new username
$password = "superevoltado"; // Use new password
$dbname = "leonardogamer.blog"; // Keep the database name the same



// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);

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
    die("Falha ao preparar: " . $conn->error);

}

$stmt->bind_param("ssds", $name, $description, $price, $image);

if ($stmt->execute()) {
    echo json_encode(array("sucesso" => true));

} else {
    echo json_encode(array("sucesso" => false, "erro" => $stmt->error));

}

$stmt->close();
$conn->close();
?>
