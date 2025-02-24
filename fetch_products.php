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

$sql = "SELECT id, nome, descricao, preco, imagem FROM produtos";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Falha ao preparar: " . $conn->error);

}

$stmt->execute();
$result = $stmt->get_result();

$produtos = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
} else {
    echo json_encode(array("message" => "Nenhum produto encontrado"));

    exit;
}

$stmt->close();
$conn->close();

echo json_encode($produtos);
?>
