<?php
$servername = "192.168.18.193"; // Update to the new server address
$username = "espetacular"; // Use new username
$password = "superevoltado"; // Use new password
$dbname = "leonardogamer.blog"; // Keep the database name the same

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);

}

// Recebe o ID do produto a ser excluído
$id = $_GET['id'];

// Exclui o produto do banco de dados
$sql = "DELETE FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Falha ao preparar: " . $conn->error);

}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(array("sucesso" => true));

} else {
    echo json_encode(array("sucesso" => false, "erro" => $stmt->error));

}

$stmt->close();
$conn->close();
?>
