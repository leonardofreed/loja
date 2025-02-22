<?php
$servername = "localhost";
$username = "root";
$password = "superevoltado";
$dbname = "loja_db";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, nome, descricao, preco, imagem FROM produtos";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

$produtos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
} else {
    echo json_encode(array("message" => "No products found"));
    exit;
}

$stmt->close();
$conn->close();

echo json_encode($produtos);
?>
