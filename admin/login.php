<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verificar credenciais (exemplo: admin@example.com / admin123)
    if ($email === 'admin@example.com' && $senha === 'admin123') {
        $_SESSION['admin_logado'] = true;
        header('Location: index.php'); // Redirecionar para o dashboard
        exit();
    } else {
        echo "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../styles/admin.css">
</head>
<body>
    <div class="login-container">
        <h1>Login Admin</h1>
        <form method="post">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>